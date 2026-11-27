<?php 

# Intelephense false Errors
/** @var array $event */
/** @var array $isInterested */
/** @var array $isRegistered */
/** @var array $from */
/** @var int $interestCount */
/** @var int $registrationCount */


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

            <div class="d-flex gap-4 mb-3">

                <div>
                    <i class="bi bi-star-fill nav-profil-icon"></i>
                    <strong>
                        <?= $interestCount ?>
                    </strong>
                    interessiert
                </div>

                <div>
                    <i class="bi bi-check-circle-fill nav-profil-icon"></i>
                    <strong>
                        <?= $registrationCount ?>
                    </strong>
                    angemeldet
                </div>

            </div>
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
    <div class="mt-3 d-flex gap-2 flex-wrap">
        <?php if ($isRegistered): ?>
        <button
            type="button"
            class="btn btn-outline-secondary"
            title="Du bist bereits für diese Veranstaltung angemeldet"
            disabled>
            <i class="bi bi-star"></i>
            Interesse
        </button>
        <?php elseif (!$isInterested): ?>
            <form
                method="POST"
                action="/event-management-system/index.php?page=event-interest-add"
                class="d-inline">
                <input
                    type="hidden"
                    name="event_id"
                    value="<?= (int) $event['event_id'] ?>">

                <input
                    type="hidden"
                    name="return_to"
                    value="details">

                <button
                    type="submit"
                    class="btn btn-outline-warning">
                    <i class="bi bi-star"></i>
                    Interesse markieren
                </button>
            </form>
        <?php else: ?>
            <form
                method="POST"
                action="/event-management-system/index.php?page=event-interest-remove"
                class="d-inline">
                <input
                    type="hidden"
                    name="event_id"
                    value="<?= (int) $event['event_id'] ?>">

                <input
                    type="hidden"
                    name="return_to"
                    value="details">

                <button
                    type="submit"
                    class="btn btn-gold">
                    <i class="bi bi-star-fill"></i>
                    Interesse entfernen
                </button>
            </form>
        <?php endif; ?>

        <?php if ($isRegistered): ?>
            <form
                method="POST"
                action="/event-management-system/index.php?page=event-registration-cancel">
                <input
                    type="hidden"
                    name="event_id"
                    value="<?= (int) $event['event_id'] ?>">

                <input
                    type="hidden"
                    name="return_to"
                    value="details">

                <button
                    type="submit"
                    class="btn btn-gold"
                    title="Anmeldung für diese Veranstaltung stornieren">
                    <i class="bi bi-check-circle-fill"></i>
                    Anmeldemarkierung entfernen
                </button>
            </form>
        <?php else: ?>
            <form
                method="POST"
                action="/event-management-system/index.php?page=event-register">
                <input
                    type="hidden"
                    name="event_id"
                    value="<?= (int) $event['event_id'] ?>">

                <input
                    type="hidden"
                    name="return_to"
                    value="details">

                <button
                    type="submit"
                    class="btn btn-outline-gold"
                    title="Für diese Veranstaltung anmelden">
                    <i class="bi bi-check-circle"></i>
                    Anmeldung markieren
                </button>
            </form>
        <?php endif; ?>
    </div>
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
        href="<?= $from === 'my-events'
            ? '/event-management-system/index.php?page=my-events'
            : '/event-management-system/index.php?page=events'
        ?>"
        class="btn btn-outline-secondary mt-3">
        Zurück zur Übersicht
    </a>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>