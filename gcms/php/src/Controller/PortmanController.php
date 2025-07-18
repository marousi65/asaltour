<?php
declare(strict_types=1);

namespace GCMS\Controller;

use GCMS\Config\Database;
use PDO;
use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class PortmanController
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
        $edit = filter_input(INPUT_GET,'edit', FILTER_SANITIZE_STRING) ?? '';
        $new  = filter_input(INPUT_GET,'new',  FILTER_SANITIZE_STRING) ?? '';

        try {
            match (true) {
                $edit === 'profile'      => $this->showEditProfile(),
                $edit === 'pass'         => $this->showEditPass(),
                $new  === 'psngrtrade'   => $this->showNewPsngrtrade(),
                $edit === 'psngrtrade'   => $this->showEditPsngrtrade(),
                default                  => print($this->twig->render('Portman/dashboard.twig')),
            };
        } catch (Exception $e) {
            echo $this->twig->render('error.twig',['message'=>$e->getMessage()]);
        }
    }

    private function showEditProfile(): void
    {
        $uid  = (int)($_SESSION['g_id_login'] ?? 0);
        $u    = $this->pdo->prepare('SELECT * FROM gcms_login WHERE id = :id');
        $u->execute([':id'=>$uid]);
        $user = $u->fetch();

        $m    = $this->pdo->prepare(
            'SELECT value FROM gcms_metalogin WHERE `key`="sailing" AND login_id=:id'
        );
        $m->execute([':id'=>$uid]);
        $raw    = $m->fetchColumn() ?: '';
        $sel    = array_filter(explode(',',$raw),'is_numeric');
        $all    = $this->pdo->query('SELECT id,name FROM gcms_sailing')->fetchAll();

        echo $this->twig->render('Portman/edit_profile.twig',[
            'user'     => $user,
            'sailings' => $all,
            'selected' => $sel,
            'csrf'     => $_SESSION['csrf']
        ]);
    }

    private function showEditPass(): void
    {
        echo $this->twig->render('Portman/edit_pass.twig',[
            'csrf'=>$_SESSION['csrf']
        ]);
    }

    private function showNewPsngrtrade(): void
    {
        $des   = $this->pdo->query('SELECT id,name FROM gcms_des')->fetchAll();
        $sings = $this->pdo->query('SELECT id,name FROM gcms_sailing')->fetchAll();

        echo $this->twig->render('Portman/new_psngrtrade.twig',[
            'desList'  => $des,
            'sailingList'=> $sings,
            'csrf'     => $_SESSION['csrf']
        ]);
    }

    private function showEditPsngrtrade(): void
    {
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT) ?? 0;
        $sql = '
          SELECT t.*, s.name AS sail_name, m1.name AS mabd_name, m2.name AS magh_name
          FROM gcms_psngrtrade t
          JOIN gcms_sailing s ON t.id_sailing = s.id
          JOIN gcms_des m1   ON t.id_mabd    = m1.id
          JOIN gcms_des m2   ON t.id_magh    = m2.id
          WHERE t.id = :id
        ';
        $stmt  = $this->pdo->prepare($sql);
        $stmt->execute([':id'=>$id]);
        $trade = $stmt->fetch();

        $des   = $this->pdo->query('SELECT id,name FROM gcms_des')->fetchAll();
        $sings = $this->pdo->query('SELECT id,name FROM gcms_sailing')->fetchAll();

        echo $this->twig->render('Portman/edit_psngrtrade.twig',[
            'trade'    => $trade,
            'desList'  => $des,
            'sailingList'=> $sings,
            'csrf'     => $_SESSION['csrf']
        ]);
    }
}
