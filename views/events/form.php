<?php 

# Intelephense false Errors

/** @var bool $isEdit */
/** @var int|null $eventId */
/** @var array $errors */
/** @var string $title */
/** @var string $location */
/** @var string $description */
/** @var string $eventStart */
/** @var string $eventEnd */

require_once __DIR__ . '/../layout/header.php'; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <h1>
        <?= $isEdit
            ? 'Veranstaltung bearbeiten'
            : 'Veranstaltung erstellen'
        ?>
    </h1>

    <form method="POST" 
    action="<?= $isEdit
    ? '/event-management-system/index.php?page=event-edit&id=' . (int) $eventId
    : '/event-management-system/index.php?page=event-create'
?>">
        <div class="mb-3">
            <label
                for="title"
                class="form-label">
                Titel
            </label>

            <input
                type="text"
                id="title"
                name="title"
                class="form-control"
                value="<?= htmlspecialchars($title ?? '') ?>"
                required>
        </div>

        <div class="mb-3">
            <label
                for="location"
                class="form-label">
                Veranstaltungsort
            </label>

            <input
                type="text"
                id="location"
                name="location"
                class="form-control"
                value="<?= htmlspecialchars($location ?? '') ?>">
        </div>

        <div class="mb-3">
            <label
                for="description"
                class="form-label">
                Beschreibung
            </label>

            <textarea
                id="description"
                name="description"
                class="form-control"
                rows="5"><?= htmlspecialchars($description ?? '') ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label
                    for="event_start"
                    class="form-label">
                    Beginn
                </label>

                <input
                    type="datetime-local"
                    id="event_start"
                    name="event_start"
                    class="form-control"
                    value="<?= htmlspecialchars($eventStart ?? '') ?>"
                    required>
            </div>

            <div class="col-md-6 mb-3">
                <label
                    for="event_end"
                    class="form-label">
                    Ende
                </label>

                <input
                    type="datetime-local"
                    id="event_end"
                    name="event_end"
                    class="form-control"
                    value="<?= htmlspecialchars($eventEnd ?? '') ?>"
                    required>
            </div>
        </div>

        <button
            type="submit"
            class="btn btn-gold">
            <?= $isEdit
                ? 'Änderungen speichern'
                : 'Veranstaltung erstellen'
            ?>
        </button>

        <a
            href="/event-management-system/index.php?page=events"
            class="btn btn-outline-secondary">
            Abbrechen
        </a>


    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>