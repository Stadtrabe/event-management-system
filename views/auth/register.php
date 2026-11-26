<?php require_once __DIR__ . '/../layout/header.php'; ?>

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
    <h1>Registrierung</h1>

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
                value="<?= htmlspecialchars($username ?? '') ?>"
                required>
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

        <div class="mb-3">
            <label for="password_confirm" class="form-label">
                Passwort wiederholen
            </label>

            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                class="form-control"
                required>
        </div>

        <button
            type="submit"
            class="btn btn-gold">

            Registrieren

        </button>

    </form>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>