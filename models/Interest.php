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

    public function findEventsByUser(int $userId): array {
        $stmt = $this->pdo->prepare(
            "SELECT
                events.event_id,
                events.title,
                events.location,
                events.event_start,
                events.event_end,
                users.username AS organizer_name,
                interests.interested_at
            FROM interests
            INNER JOIN events
                ON interests.event_id = events.event_id
            INNER JOIN users
                ON events.organizer_id = users.user_id
            WHERE interests.user_id = :user_id
            ORDER BY events.event_start ASC"
        );

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    public function countByEvent(int $eventId): int {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*)
            FROM interests
            WHERE event_id = :event_id"
        );

        $stmt->execute([
            'event_id' => $eventId
        ]);

        return (int) $stmt->fetchColumn();
    }
}