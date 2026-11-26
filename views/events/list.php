<?php 
/** @var array $interestedEventIds */
/** @var array $registeredEventIds */
require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="mb-0">
            Veranstaltungen
        </h1>

        <?php if (
            isset($_SESSION['role']) &&
            in_array($_SESSION['role'], ['organizer', 'admin'], true)
        ): ?>

            <a
                href="/event-management-system/index.php?page=event-create"
                class="btn btn-gold">

                <i class="bi bi-plus-circle"></i>
                Veranstaltung erstellen
            </a>
        <?php endif; ?>
    </div>

    <?php if (empty($events)): ?>

        <div class="alert alert-info">
            Es sind keine Veranstaltungen vorhanden.
        </div>

    <?php else: ?>

        <div class="table-responsive event-table-container">

            <table class="table event-table mb-0">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titel</th>
                        <th>Von:</th>
                        <th>Bis:</th>
                        <th>Erstellt von</th>
                        <th>Erstellt am</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($events as $event): ?>
                        <?php $isInterested = in_array(
                            (int) $event['event_id'],
                            $interestedEventIds,
                            true);

                        $isRegistered = in_array((int) $event['event_id'],
                            $registeredEventIds,
                            true);
                    ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars((string) $event['event_id']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($event['title']) ?>
                            </td>

                            <td>
                                <?= date(
                                    'd.m.Y, H:i',
                                    strtotime($event['event_start']) #schönere Dartellung 
                                ) ?> Uhr
                            </td>

                            <td>
                                <?= date(
                                    'd.m.Y, H:i',
                                    strtotime($event['event_end'])
                                ) ?> Uhr
                            </td>

                            <td>
                                <?= htmlspecialchars($event['organizer_name']) ?>
                            </td>

                            <td>
                                <?= date(
                                    'd.m.Y, H:i',
                                    strtotime($event['created_at'])
                                ) ?> Uhr
                            </td>
                <!-- AKTIONEN -->
                            <td>

                        <!-- DETAILS -->
                                <a 
                                href="/event-management-system/index.php?page=event-details&id=<?= (int) $event['event_id'] ?>"
                                    class="btn btn-gold btn-sm"
                                    title="Veranstaltungsdetails anzeigen">
                                    <i class="bi bi-info-circle"></i>
                                </a>
                        <!-- STAR -->                
                                <?php if ($isRegistered): ?>
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary btn-sm"
                                        title="Bereits angemeldet"
                                        disabled>
                                        <i class="bi bi-star"></i>
                                    </button>
                                <?php elseif ($isInterested): ?>
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
                                            value="list"> <!--Verhindern, dass zurück zur Detailseite kommt -->

                                        <button
                                            type="submit"
                                            class="btn btn-gold btn-sm"
                                            title="Interesse entfernen">

                                            <i class="bi bi-star-fill"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
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
                                            value="list">

                                        <button
                                            type="submit"
                                            class="btn btn-outline-warning btn-sm"
                                            title="Als interessiert markieren">
                                            <i class="bi bi-star"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                        <!-- CHECK -->
                                <?php if ($isRegistered): ?>
                                    <form
                                        method="POST"
                                        action="/event-management-system/index.php?page=event-registration-cancel"
                                        class="d-inline">
                                        <input
                                            type="hidden"
                                            name="event_id"
                                            value="<?= (int) $event['event_id'] ?>">

                                        <input
                                            type="hidden"
                                            name="return_to"
                                            value="list">

                                        <button
                                            type="submit"
                                            class="btn btn-gold btn-sm"
                                            title="Anmeldemarkierungentfernen">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form
                                        method="POST"
                                        action="/event-management-system/index.php?page=event-register"
                                        class="d-inline">

                                        <input
                                            type="hidden"
                                            name="event_id"
                                            value="<?= (int) $event['event_id'] ?>">

                                        <input
                                            type="hidden"
                                            name="return_to"
                                            value="list">

                                            <button
                                            type="submit"
                                            class="btn btn-outline-gold btn-sm"
                                            title="Als angemeldet markieren.">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>