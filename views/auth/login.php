<?php

session_start();

require_once __DIR__ . '/../../config/database.php';

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email)) {
        $errors[] = 'Bitte eine E-Mail-Adresse eingeben.';
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Bitte eine gültige E-Mail-Adresse eingeben.';
    }

    if (empty($password)) {
        $errors[] = 'Bitte ein Passwort eingeben.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "SELECT *
                FROM users
                WHERE email = :email"
        );

        $stmt->execute([
            'email' => $email
        ]);

        $user = $stmt->fetch();

        if (!$user) {
            $errors[] = 'Kein Benutzer mit dieser E-Mail-Adresse gefunden.';
        }
    }

    if (empty($errors)) {
        if (!password_verify(
            $password,
            $user['password_hash']
        )) {
            $errors[] =
                'Falsches Passwort.';
        }
    }

    if (empty($errors)) {
        $_SESSION['user_id'] =
            $user['user_id'];

        $_SESSION['username'] =
            $user['username'];

        $_SESSION['role'] =
            $user['role'];

        if ($user['role'] === 'admin') {
            header('Location: ../admin/dashboard.php');
            exit;
        }

        header('Location: ../events/list.php');
        exit;
    
    }

    
}

$successMessage = '';
if (isset($_GET['registered'])) {
    $successMessage =
        'Die Registrierung war erfolgreich. Bitte melden Sie sich an.';
}

require_once __DIR__ . '/../layout/header.php';
?>

<?php if (!empty($errors)): ?>

<div class="alert alert-danger">
    <ul class="mb-0">

        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>

    </ul>
</div>

<?php endif; ?>

<div class="container mt-5">

    <?php if (!empty($successMessage)): ?>

        <div class="alert alert-success">
            <?= htmlspecialchars($successMessage) ?>
        </div>

    <?php endif; ?>

    <h1>Anmelden</h1>

    <form method="POST">

        <div class="mb-3">
            <label for="email" class="form-label">
                E-Mail
            </label>

            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                value="<?= htmlspecialchars($email ?? '') ?>"
                required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">
                Passwort
            </label>

            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                required>
        </div>

        <button
            type="submit"
            class="btn btn-gold">
        
            Anmelden
        
        </button>

    </form>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>