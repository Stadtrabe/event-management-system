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
}