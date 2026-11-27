<?php

/** @var array $userStatistics */
/** @var int $eventCount */

require_once __DIR__ . '/../layout/header.php';

?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">
            Admin-Dashboard
        </h1>

        <a
            href="/event-management-system/index.php?page=admin-users"
            class="btn btn-gold">
            <i class="bi bi-people"></i>
            Benutzer verwalten
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1"></i>

                    <h2 class="display-5 mt-2">
                        <?= (int) $userStatistics['total'] ?>
                    </h2>

                    <p class="mb-0">
                        Benutzer gesamt
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-event fs-1"></i>

                    <h2 class="display-5 mt-2">
                        <?= $eventCount ?>
                    </h2>

                    <p class="mb-0">
                        Veranstaltungen
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="h4 mb-3">
        Rollenverteilung
    </h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h3 class="display-6">
                        <?= (int) $userStatistics['users'] ?>
                    </h3>

                    <p class="mb-0">
                        User
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h3 class="display-6">
                        <?= (int) $userStatistics['organizers'] ?>
                    </h3>

                    <p class="mb-0">
                        Organizer
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h3 class="display-6">
                        <?= (int) $userStatistics['admins'] ?>
                    </h3>

                    <p class="mb-0">
                        Admins
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>