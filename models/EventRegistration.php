<?php

declare(strict_types=1);

class EventRegistration
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
            "SELECT registration_id
            FROM event_registration
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
        try {
            $this->pdo->beginTransaction(); # "atomare Operation": Entweder alles oder nichts.
            $stmt = $this->pdo->prepare(
                "INSERT INTO event_registration
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

            $stmt->execute([
                'user_id' => $userId,
                'event_id' => $eventId
            ]);

            $stmt = $this->pdo->prepare(
                "DELETE FROM interests
                WHERE user_id = :user_id
                AND event_id = :event_id"
            );

            $stmt->execute([
                'user_id' => $userId,
                'event_id' => $eventId
            ]);

            $this->pdo->commit();

            return true;
        } catch (Throwable $e) { # Kommt ein Fehler auf (Throwable): rollback
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }

    public function remove(
        int $userId,
        int $eventId
    ): bool {
        $stmt = $this->pdo->prepare(
            "DELETE FROM event_registration
            WHERE user_id = :user_id
            AND event_id = :event_id"
        );

        return $stmt->execute([
            'user_id' => $userId,
            'event_id' => $eventId
        ]);
    }

    public function findEventIdsByUser(
        int $userId
    ): array {
        $stmt = $this->pdo->prepare(
            "SELECT event_id
            FROM event_registration
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
                event_registration.created_at AS registered_at
            FROM event_registration
            INNER JOIN events
                ON event_registration.event_id = events.event_id
            INNER JOIN users
                ON events.organizer_id = users.user_id
            WHERE event_registration.user_id = :user_id
            ORDER BY events.event_start ASC"
        );

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    public function countByEvent(int $eventId): int{
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*)
            FROM event_registration
            WHERE event_id = :event_id"
        );

        $stmt->execute([
            'event_id' => $eventId
        ]);

        return (int) $stmt->fetchColumn();
    }

}