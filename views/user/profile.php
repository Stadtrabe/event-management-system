<?php

/** @var array $user */
/** @var array $errors */
/** @var string $successMessage */
/** @var string $username */
/** @var string $email */

require_once __DIR__ . '/../layout/header.php';

?>

<div class="container mt-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <h1 class="mb-0">
            Mein Profil
        </h1>

        <a
            href="/event-management-system/index.php?page=my-events"
            class="btn btn-gold">
            <i class="bi bi-calendar-event"></i>
            Meine Veranstaltungen
        </a>
    </div>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($successMessage) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li>
                        <?= htmlspecialchars($error) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row g-4">
<!-- KONTODATEN -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h4 card-title mb-4">
                        Kontoinformationen
                    </h2>

                    <dl class="mb-0">
                        <dt>Benutzer-ID</dt>

                        <dd>
                            <?= htmlspecialchars(
                                (string) $user['user_id']
                            ) ?>
                        </dd>

                        <dt>Rolle</dt>

                        <dd>
                            <?= htmlspecialchars(
                                ucfirst($user['role'])
                            ) ?>
                        </dd>

                        <dt>Status</dt>

                        <dd>
                            <?= htmlspecialchars(
                                $user['status']
                            ) ?>
                        </dd>

                        <dt>Registriert seit</dt>

                        <dd class="mb-0">
                            <?= date(
                                'd.m.Y, H:i',
                                strtotime($user['created_at'])
                            ) ?> Uhr
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
<!-- PROFIL BEARBEITEN -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="h4 card-title mb-4">
                        Profildaten bearbeiten
                    </h2>

                    <form
                        method="POST"
                        action="/event-management-system/index.php?page=profile">

                        <div class="mb-3">
                            <label
                                for="username"
                                class="form-label">
                                Benutzername
                            </label>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                class="form-control"
                                value="<?= htmlspecialchars($username) ?>"
                                maxlength="45"
                                required>
                        </div>

                        <div class="mb-4">
                            <label
                                for="email"
                                class="form-label">
                                E-Mail-Adresse
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                value="<?= htmlspecialchars($email) ?>"
                                maxlength="100"
                                required>
                        </div>

                        <hr>

                        <h3 class="h5 mt-4">
                            Passwort ändern
                        </h3>

                        <p class="text-muted">
                            Lasse beide Passwortfelder leer, wenn das
                            aktuelle Passwort beibehalten werden soll.
                        </p>

                        <div class="mb-3">
                            <label
                                for="new_password"
                                class="form-label">
                                Neues Passwort
                            </label>

                            <input
                                type="password"
                                id="new_password"
                                name="new_password"
                                class="form-control"
                                minlength="8"
                                autocomplete="new-password">

                            <div class="form-text">
                                Das Passwort muss mindestens acht Zeichen
                                lang sein.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                for="password_confirm"
                                class="form-label">
                                Neues Passwort bestätigen
                            </label>

                            <input
                                type="password"
                                id="password_confirm"
                                name="password_confirm"
                                class="form-control"
                                minlength="8"
                                autocomplete="new-password">
                        </div>

                        <button
                            type="submit"
                            class="btn btn-gold">

                            <i class="bi bi-save"></i>
                            Profil speichern
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>