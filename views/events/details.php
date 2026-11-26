<?php 

# Intelephense false Error
/** @var array $event */

require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <h1>
        <?= htmlspecialchars($event['title']) ?>
    </h1>

    <div class="card mt-4">

        <div class="card-body">

            <h5 class="card-title">
                Veranstaltungsdetails
            </h5>

            <p>
                <strong>Ort:</strong><br>
                <?php if (!empty($event['location'])): ?>
<!-- n12br => behält Zeilenumbrüche bei, die sonst von HTML ignoriert werden -->
                    <?= nl2br(
                        htmlspecialchars($event['location'])
                    ) ?>

                <?php else: ?>

                    Keine Location angegeben.

                <?php endif; ?>
            </p>

            <p>
                <strong>Beginn:</strong><br>
                <?= date(
                    'd.m.Y, H:i',
                    strtotime($event['event_start'])
                ) ?> Uhr
            </p>

            <p>
                <strong>Ende:</strong><br>
                <?= date(
                    'd.m.Y, H:i',
                    strtotime($event['event_end'])
                ) ?> Uhr
            </p>

            <p>
                <strong>Erstellt von:</strong><br>
                <?= htmlspecialchars($event['organizer_name']) ?>
            </p>

            <p>
                <strong>Beschreibung:</strong><br>

                <?php if (!empty($event['description'])): ?>

                    <?= nl2br(
                        htmlspecialchars($event['description'])
                    ) ?>

                <?php else: ?>

                    Keine Beschreibung vorhanden.

                <?php endif; ?>

            </p>

            <p class="text-muted">
                Erstellt am
                <?= date(
                    'd.m.Y, H:i',
                    strtotime($event['created_at'])
                ) ?> Uhr
            </p>

        </div>

    </div>

<!-- BUTTONS -->
    <?php
    $isAdmin =
        isset($_SESSION['role']) &&
        $_SESSION['role'] === 'admin';

    $isOwner =
        isset($_SESSION['role'], $_SESSION['user_id']) &&
        $_SESSION['role'] === 'organizer' &&
        (int) $_SESSION['user_id'] === (int) $event['organizer_id'];
    ?>

    <?php if ($isAdmin || $isOwner): ?>
        <a
            href="/event-management-system/index.php?page=event-edit&id=<?= (int) $event['event_id'] ?>"
            class="btn btn-gold mt-3">
            <i class="bi bi-pencil"></i>
            Bearbeiten
        </a>
    <?php endif; ?>

    <a
        href="/event-management-system/index.php?page=events"
        class="btn btn-outline-secondary mt-3">
        Zurück zur Übersicht
    </a>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>