<?php require_once __DIR__ . '/../layout/header.php'; ?>

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

                            <td>
                                <a
                                    href="/event-management-system/index.php?page=event-details&id=<?= (int) $event['event_id'] ?>"
                                    class="btn btn-gold btn-sm">
                                    Details
                                </a>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>