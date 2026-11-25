<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-5">

    <h1>Benutzerverwaltung</h1>

    <?php if (empty($users)): ?>

        <div class="alert alert-info">
            Es sind keine Benutzer vorhanden.
        </div>

    <?php else: ?>

        <div class="table-responsive event-table-container">

            <table class="table event-table mb-0">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Benutzername</th>
                        <th>E-Mail</th>
                        <th>Rolle</th>
                        <th>Status</th>
                        <th>Erstellt am</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($users as $user): ?>

                        <?php
                        $formId = 'user-form-' . (int) $user['user_id'];
                        ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars((string) $user['user_id']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($user['username']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($user['email']) ?>
                            </td>

                            <td>
                                <select
                                    name="role"
                                    class="form-select form-select-sm"
                                    form="<?= $formId ?>">

                                    <option
                                        value="user"
                                        <?= $user['role'] === 'user' ? 'selected' : '' ?>>
                                        User
                                    </option>

                                    <option
                                        value="organizer"
                                        <?= $user['role'] === 'organizer' ? 'selected' : '' ?>>
                                        Organizer
                                    </option>

                                    <option
                                        value="admin"
                                        <?= $user['role'] === 'admin' ? 'selected' : '' ?>>
                                        Admin
                                    </option>

                                </select>
                            </td>

                            <td>
                                <select
                                    name="status"
                                    class="form-select form-select-sm"
                                    form="<?= $formId ?>">

                                    <option
                                        value="Überprüfung"
                                        <?= $user['status'] === 'Überprüfung' ? 'selected' : '' ?>>
                                        Überprüfung
                                    </option>

                                    <option
                                        value="bestätigt"
                                        <?= $user['status'] === 'bestätigt' ? 'selected' : '' ?>>
                                        Bestätigt
                                    </option>

                                    <option
                                        value="Bearbeitung"
                                        <?= $user['status'] === 'Bearbeitung' ? 'selected' : '' ?>>
                                        Bearbeitung
                                    </option>

                                    <option
                                        value="abgelehnt"
                                        <?= $user['status'] === 'abgelehnt' ? 'selected' : '' ?>>
                                        Abgelehnt
                                    </option>

                                </select>
                            </td>

                            <td>
                                <?= htmlspecialchars($user['created_at']) ?>
                            </td>

                            <td>

                                <form
                                    id="<?= $formId ?>"
                                    method="POST"
                                    action="/event-management-system/index.php?page=admin-update-user">

                                    <input
                                        type="hidden"
                                        name="user_id"
                                        value="<?= (int) $user['user_id'] ?>">

                                    <button
                                        type="submit"
                                        class="btn btn-gold btn-sm">
                                        Speichern
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