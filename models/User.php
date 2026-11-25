<?php

declare(strict_types=1);

class User
{
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): array|false {
        $stmt = $this->pdo->prepare(
            "SELECT *
            FROM users
            WHERE email = :email"
        );

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch();
    }

    public function create(
        string $username,
        string $email,
        string $passwordHash,
        string $role = 'user',
        string $status = 'Prüfung'
    ): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO users
            (
                username,
                email,
                password_hash,
                role,
                status
            )
            VALUES
            (
                :username,
                :email,
                :password_hash,
                :role,
                :status
            )"
        );

        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password_hash' => $passwordHash,
            'role' => $role,
            'status' => $status
        ]);
    }

    public function findAll(): array {
        $stmt = $this->pdo->prepare(
            "SELECT
                user_id,
                username,
                email,
                role,
                status,
                created_at
            FROM users
            ORDER BY user_id ASC"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function updateRoleAndStatus(
        int $userId,
        string $role,
        string $status
    ): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE users
            SET
                role = :role,
                status = :status
            WHERE user_id = :user_id"
        );

        return $stmt->execute([
            'role' => $role,
            'status' => $status,
            'user_id' => $userId
        ]);
    }

}