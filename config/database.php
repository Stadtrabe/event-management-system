<?php

declare(strict_types=1);

require_once __DIR__ . '/env.php';

$host = $env['DB_HOST'];
$dbname = $env['DB_NAME'];
$dbusername = $env['DB_USER'];
$dbpassword = $env['DB_PASSWORD'];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $dbusername,
        $dbpassword
    );
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (PDOException $e) {
    die("Datenbankfehler: " . $e->getMessage());
}