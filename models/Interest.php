<?php

declare(strict_types=1);

class Interest
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function exists(
        int $userId,
        int $eventId
    ): bool {
        $stmt = $this->pdo->prepare(
            "SELECT interest_id
            FROM interests
            WHERE user_id = :user_id
            AND event_id = :event_id"
        );

        $stmt->execute([
            'user_id' => $userId,
            'event_id' => $eventId
        ]);

        return $stmt->fetch() !== false;
    }

    public function add(
        int $userId,
        int $eventId
    ): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO interests
            (
                user_id,
                event_id
            )
            VALUES
            (
                :user_id,
                :event_id
            )"
        );

        return $stmt->execute([
            'user_id' => $userId,
            'event_id' => $eventId
        ]);
    }

    public function remove(
        int $userId,
        int $eventId
    ): bool {
        $stmt = $this->pdo->prepare(
            "DELETE FROM interests
            WHERE user_id = :user_id
            AND event_id = :event_id"
        );

        return $stmt->execute([
            'user_id' => $userId,
            'event_id' => $eventId
        ]);
    }

    public function findEventIdsByUser(int $userId): array {
        $stmt = $this->pdo->prepare(
            "SELECT event_id
            FROM interests
            WHERE user_id = :user_id"
        );

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll(
            PDO::FETCH_COLUMN
        );
    }
}