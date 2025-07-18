<?php
declare(strict_types=1);

namespace GCMS\Cron;

use DateInterval;
use DateTime;
use Exception;
use PDO;

class CronJob
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function run(): void
    {
        $this->processPendingPassengerTrades();
        $this->processPendingCarTrades();
    }

    private function processPendingPassengerTrades(): void
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, id_psngrtrade, num, buy_time
             FROM gcms_buypsngrtrade
             WHERE type = :type'
        );
        $stmt->execute([':type' => 'pending']);

        while ($row = $stmt->fetch()) {
            if ($this->isExpired($row['buy_time'])) {
                $this->returnPassengerCapacity((int)$row['id_psngrtrade'], (int)$row['num']);
                $this->markPassengerTradeCancelled((int)$row['id']);
            }
        }
    }

    private function processPendingCarTrades(): void
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, id_cartrade, id_car, buy_time
             FROM gcms_buycartrade
             WHERE type = :type'
        );
        $stmt->execute([':type' => 'pending']);

        while ($row = $stmt->fetch()) {
            if ($this->isExpired($row['buy_time'])) {
                $this->returnCarCapacity(
                    (int)$row['id_cartrade'],
                    (int)$row['id_car']
                );
                $this->markCarTradeCancelled((int)$row['id']);
            }
        }
    }

    private function isExpired(string $dbDate): bool
    {
        $dt = DateTime::createFromFormat('Y-m-d-H-i-s', $dbDate);
        if (!$dt) {
            throw new Exception("Invalid date format: $dbDate");
        }
        $dt->add(new DateInterval('PT1H'));
        return (new DateTime()) > $dt;
    }

    private function returnPassengerCapacity(int $tradeId, int $count): void
    {
        $stmt = $this->pdo->prepare(
            'SELECT free_capacity FROM gcms_psngrtrade WHERE id = :id'
        );
        $stmt->execute([':id' => $tradeId]);
        $free = (int)$stmt->fetchColumn();

        $update = $this->pdo->prepare(
            'UPDATE gcms_psngrtrade
             SET free_capacity = :new
             WHERE id = :id'
        );
        $update->execute([
            ':new' => $free + $count + 1,
            ':id'  => $tradeId
        ]);
    }

    private function returnCarCapacity(int $carTradeId, int $carId): void
    {
        $stmt1 = $this->pdo->prepare(
            'SELECT free_capacity FROM gcms_cartrade WHERE id = :id'
        );
        $stmt1->execute([':id' => $carTradeId]);
        $free = (int)$stmt1->fetchColumn();

        $stmt2 = $this->pdo->prepare(
            'SELECT unit FROM gcms_car WHERE id = :id'
        );
        $stmt2->execute([':id' => $carId]);
        $unit = (int)$stmt2->fetchColumn();

        $update = $this->pdo->prepare(
            'UPDATE gcms_cartrade
             SET free_capacity = :new
             WHERE id = :id'
        );
        $update->execute([
            ':new' => $free + $unit,
            ':id'  => $carTradeId
        ]);
    }

    private function markPassengerTradeCancelled(int $id): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE gcms_buypsngrtrade
             SET type = :type
             WHERE id = :id'
        );
        $stmt->execute([':type' => 'cancel', ':id' => $id]);
    }

    private function markCarTradeCancelled(int $id): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE gcms_buycartrade
             SET type = :type
             WHERE id = :id'
        );
        $stmt->execute([':type' => 'cancel', ':id' => $id]);
    }
}
