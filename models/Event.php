<?php

declare(strict_types=1);

class Event
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array {
        $stmt = $this->pdo->prepare(
            "SELECT
                events.event_id,
                events.title,
                events.location,
                events.description,
                events.event_start,
                events.event_end,
                events.organizer_id,
                events.created_at,
                users.username AS organizer_name
            FROM events
            INNER JOIN users
                ON events.organizer_id = users.user_id
            ORDER BY events.event_start ASC"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function create(
        string $title,
        ?string $location, #mit ? bedeutet string oder null
        ?string $description,
        string $eventStart,
        string $eventEnd,
        int $organizerId
    ): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO events
            (
                title,
                location,
                description,
                event_start,
                event_end,
                organizer_id
            )
            VALUES
            (
                :title,
                :location,
                :description,
                :event_start,
                :event_end,
                :organizer_id
            )"
        );

        return $stmt->execute([
            'title' => $title,
            'location' => $location,
            'description' => $description,
            'event_start' => $eventStart,
            'event_end' => $eventEnd,
            'organizer_id' => $organizerId
        ]);
    }

    public function findById(int $eventId): array|false {
        $stmt = $this->pdo->prepare(
            "SELECT
                events.event_id,
                events.title,
                events.location,
                events.description,
                events.event_start,
                events.event_end,
                events.organizer_id,
                events.created_at,
                users.username AS organizer_name
            FROM events
            INNER JOIN users
                ON events.organizer_id = users.user_id
            WHERE events.event_id = :event_id"
        );

        $stmt->execute([
            'event_id' => $eventId
        ]);

        return $stmt->fetch();
    }

    public function update(
        int $eventId,
        string $title,
        ?string $location,
        ?string $description,
        string $eventStart,
        string $eventEnd
    ): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE events
            SET
                title = :title,
                location = :location,
                description = :description,
                event_start = :event_start,
                event_end = :event_end
            WHERE event_id = :event_id"
        );

        return $stmt->execute([
            'event_id' => $eventId,
            'title' => $title,
            'location' => $location,
            'description' => $description,
            'event_start' => $eventStart,
            'event_end' => $eventEnd
        ]);
    }

    public function countAll(): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*)
            FROM events"
        );

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}