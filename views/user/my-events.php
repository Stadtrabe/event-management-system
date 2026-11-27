<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <h1 class="mb-4">Meine Veranstaltungen</h1>


    <!-- ANGEMELDETE VERANSTALTUNGEN -->

    <h2 class="h4 mb-3">
        Angemeldete Veranstaltungen
    </h2>

    <?php if (empty($registeredEvents)): ?>

        <div class="alert alert-gold">
            Du bist aktuell für keine Veranstaltung angemeldet.
        </div>

    <?php else: ?>

        <div class="table-responsive event-table-container mb-5">

            <table class="table event-table my-events-table mb-0">

                <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Von</th>
                        <th>Bis</th>
                        <th>Erstellt von</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($registeredEvents as $event): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($event['title']) ?>
                            </td>

                            <td>
                                <?= date(
                                    'd.m.Y, H:i',
                                    strtotime($event['event_start'])
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
                                <a
                                    href="/event-management-system/index.php?page=event-details&id=<?= (int) $event['event_id'] ?>&from=my-events"
                                    class="btn btn-gold btn-sm"
                                    title="Veranstaltungsdetails anzeigen">
                                    <i class="bi bi-info-circle"></i>
                                </a>

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
                                        value="my-events">

                                    <button
                                        type="submit"
                                        class="btn btn-gold btn-sm"
                                        title="Anmeldemarkierung entfernen">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <h2 class="h4 mb-3">
        Interessante Veranstaltungen
    </h2>

    <?php if (empty($interestedEvents)): ?>

        <div class="alert alert-gold">
            Du hast aktuell keine Veranstaltung als interessant markiert.
        </div>

    <?php else: ?>

        <div class="table-responsive event-table-container">

            <table class="table event-table my-events-table mb-0">

                <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Von</th>
                        <th>Bis</th>
                        <th>Erstellt von</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($interestedEvents as $event): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($event['title']) ?>
                            </td>

                            <td>
                                <?= date(
                                    'd.m.Y, H:i',
                                    strtotime($event['event_start'])
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
                                <a
                                    href="/event-management-system/index.php?page=event-details&id=<?= (int) $event['event_id'] ?>&from=my-events"
                                    class="btn btn-gold btn-sm"
                                    title="Veranstaltungsdetails anzeigen">
                                    <i class="bi bi-info-circle"></i>
                                </a>
                            
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
                                        value="my-events">

                                    <button
                                        type="submit"
                                        class="btn btn-gold btn-sm"
                                        title="Interesse entfernen">
                                        <i class="bi bi-star-fill"></i>
                                    </button>
                                </form>

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
                                        value="my-events">

                                    <button
                                        type="submit"
                                        class="btn btn-outline-gold btn-sm"
                                        title="Als angemeldet markieren">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>