<?php
declare(strict_types=1);

namespace GCMS\Controller;

use GCMS\Config\Database;
use PDO;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ShipmanController
{
    private PDO $pdo;
    private Environment $twig;

    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(16));
        }
        $this->pdo = Database::getConnection();
        $loader    = new FilesystemLoader(__DIR__ . '/../../src/View');
        $this->twig = new Environment($loader, ['cache'=>false,'debug'=>true]);
    }

    public function dispatch(): void
    {
        $action = filter_input(INPUT_GET,'shipman',FILTER_SANITIZE_STRING) ?? '';
        $edit   = filter_input(INPUT_GET,'edit',   FILTER_SANITIZE_STRING) ?? '';

        match (true) {
            $action === 'edit' && $edit === 'profile'    => $this->showEditProfile(),
            $action === 'edit' && $edit === 'pass'       => $this->showEditPass(),
            $action === 'new'  && $_GET['new']==='psngrtrade' => $this->showNewPsngrtrade(),
            $action === 'edit' && $edit==='psngrtrade'  => $this->showEditPsngrtrade(),
            $action === 'edit' && $edit==='cartrade'    => $this->showEditCartrade(),
            default => print($this->twig->render('Shipman/dashboard.twig')),
        };
    }

    private function showEditProfile(): void
    {
        $id   = (int)($_SESSION['g_id_login'] ?? 0);
        $stmt = $this->pdo->prepare('SELECT * FROM gcms_login WHERE id=:id');
        $stmt->execute([':id'=>$id]);
        $user = $stmt->fetch();

        $rawStmt = $this->pdo->prepare(
            'SELECT value FROM gcms_metalogin WHERE `key`="sailing" AND login_id=:id'
        );
        $rawStmt->execute([':id'=>$id]);
        $raw = $rawStmt->fetchColumn() ?: '';
        $sel = array_filter(explode(',',$raw),'is_numeric');
        $all = $this->pdo->query('SELECT id,name FROM gcms_sailing')->fetchAll();

        echo $this->twig->render('Shipman/edit_profile.twig', [
            'user'     => $user,
            'sailings' => $all,
            'selected' => $sel,
            'csrf'     => $_SESSION['csrf']
        ]);
    }

    private function showEditPass(): void
    {
        echo $this->twig->render('Shipman/edit_pass.twig', [
            'csrf' => $_SESSION['csrf']
        ]);
    }

    private function showNewPsngrtrade(): void
    {
        $dest = $this->pdo->query('SELECT id,name FROM gcms_des')->fetchAll();
        $sail = $this->pdo->query('SELECT id,name FROM gcms_sailing')->fetchAll();

        echo $this->twig->render('Shipman/new_psngrtrade.twig', [
            'desList'     => $dest,
            'sailingList' => $sail,
            'csrf'        => $_SESSION['csrf']
        ]);
    }

    private function showEditPsngrtrade(): void
    {
        $id   = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT) ?? 0;
        $sql  = '
        SELECT t.*, s.name AS sailing_name, m1.name AS mabd_name, m2.name AS magh_name
        FROM gcms_psngrtrade t
        JOIN gcms_sailing s ON t.id_sailing=s.id
        JOIN gcms_des m1   ON t.id_mabd =m1.id
        JOIN gcms_des m2   ON t.id_magh =m2.id
        WHERE t.id=:id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id'=>$id]);
        $trade = $stmt->fetch();

        $dest = $this->pdo->query('SELECT id,name FROM gcms_des')->fetchAll();
        $sail = $this->pdo->query('SELECT id,name FROM gcms_sailing')->fetchAll();

        echo $this->twig->render('Shipman/edit_psngrtrade.twig', [
            'trade'       => $trade,
            'desList'     => $dest,
            'sailingList' => $sail,
            'csrf'        => $_SESSION['csrf']
        ]);
    }

    private function showEditCartrade(): void
    {
        // مشابه psngrtrade اما جدول gcms_cartrade و اضافاتش
        // ...
    }
}
