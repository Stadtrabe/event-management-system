<?php

require_once __DIR__ . '/../../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

    if (empty($username)) {
        $errors[] = 'Bitte einen Benutzernamen eingeben.';
    }

    if (empty($email)) {
        $errors[] = 'Bitte eine E-Mail-Adresse eingeben.';
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Bitte eine gültige E-Mail-Adresse eingeben.';
    }

    if (empty($password)) {
        $errors[] = 'Bitte ein Passwort eingeben.';
    }

    if ($password !== $passwordConfirm) {
        $errors[] = 'Die Passwörter stimmen nicht überein.';
    }

    if (!empty($password) && strlen($password) < 8) {
        $errors[] = 'Das Passwort muss mindestens 8 Zeichen lang sein.';
    }

    if (empty($errors)) {

    $stmt = $pdo->prepare(
        "SELECT user_id
        FROM users
        WHERE email = :email"
    );

    $stmt->execute([
        'email' => $email
    ]);

    if ($stmt->fetch()) {
        $errors[] = 'Diese E-Mail-Adresse ist bereits registriert.';
    }
}
}

require_once __DIR__ . '/../layout/header.php';
?>

<div class="container mt-5">

    <h1>Registrierung</h1>

    <?php if (!empty($errors)): ?>

    <div class="alert alert-danger">

        <ul class="mb-0">

            <?php foreach ($errors as $error): ?>

                <li><?= htmlspecialchars($error) ?></li>

            <?php endforeach; ?>

        </ul>

    </div>

    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label for="username" class="form-label">
                Benutzername
            </label>

            <input
                type="text"
                id="username"
                name="username"
                class="form-control"
                value="<?= htmlspecialchars($username ?? '') ?>">
                <!-- required> -->
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">
                E-Mail
            </label>

            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                value="<?= htmlspecialchars($email ?? '') ?>">
                <!-- required> -->
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">
                Passwort
            </label>

            <input
                type="password"
                id="password"
                name="password"
                class="form-control">
                <!-- required> -->
        </div>

        <div class="mb-3">
            <label for="password_confirm" class="form-label">
                Passwort wiederholen
            </label>

            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                class="form-control">
                <!-- required> -->
        </div>

        <button
            type="submit"
            class="btn btn-gold">

            Registrieren

        </button>

    </form>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>