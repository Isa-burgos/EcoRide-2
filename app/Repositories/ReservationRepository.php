<?php

namespace App\Repositories;

use App\Models\ReservationModel;
use App\Models\VehicleModel;

class ReservationRepository extends Repository{

    private string $table = 'reservations';

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function isAlreadyReserved(int $userId, int $carshareId): bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE user_id = :user_id AND carshare_id = :carshare_id";
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'carshare_id' => $carshareId
            ]);

        return $stmt->fetchColumn() > 0;
    }

    public function countReservation($carshareId): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE carshare_id = :carshare_id";
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->execute(['carshare_id' => $carshareId]);
        return (int) $stmt->fetchColumn();
    }

    public function reserve(int $userId, int $carshareId, int $places = 1): bool
    {
        $sql = "INSERT INTO {$this->table}
                (user_id, carshare_id, reserved_places)
                VALUES
                (:user_id, :carshare_id, :reserved_places)
                ";

        return $this->execute($sql, [
            ':user_id' => $userId,
            'carshare_id' => $carshareId,
            'reserved_places' => $places
        ]);
    }

    public function countReservedSeats(int $carshareId): int
    {
        $sql = "SELECT SUM(reserved_places) FROM {$this->table} WHERE carshare_id = :carshare_id";
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->execute(['carshare_id' => $carshareId]);
        return (int) $stmt->fetchColumn() ?? 0;
    }

    public function getReservationsByCarshare(int $carshareId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE carshare_id = :carshare_id";
        return $this->fetch($sql, ['carshare_id' => $carshareId], false, ReservationModel::class);
    }

}