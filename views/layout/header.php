<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>


<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Event Management System</title>
<!-- Lädt Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="/event-management-system/assets/css/style.css"
        rel="stylesheet">
</head>

<body>
<!-- Bootstrap: navbar-dark -> schwarzer Hintergrund - hellere schrift -->
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container">

        <a class="navbar-brand"
            href="/event-management-system">
                Event Management System
        </a>

    <div class="navbar-nav">

    <?php if (isset($_SESSION['user_id'])): ?>

        <a class="nav-link"
            href="/event-management-system/views/events/list.php">
                Events
        </a>

        <a class="nav-link"
            href="/event-management-system/views/auth/logout.php">
                Logout
        </a>

        <a class="nav-link nav-profil"
            href="/event-management-system/views/user/profile.php">
                <i class="bi bi-person-fill nav-profil-icon"></i>
                <?= htmlspecialchars($_SESSION['username']) ?>
        </a>

    <?php else: ?>

        <a class="nav-link"
            href="/event-management-system/views/auth/login.php">
                Login
        </a>

        <a class="nav-link"
            href="/event-management-system/views/auth/register.php">
                Registrierung
        </a>

    <?php endif; ?>

    </div>

</nav>