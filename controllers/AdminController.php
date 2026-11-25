<?php

declare(strict_types=1);

class AdminController
{
    private User $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    private function requireAdmin(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {

            header(
                'Location: /event-management-system/index.php?page=login'
            );

            exit;
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);

            require __DIR__ . '/../views/errors/403.php';

            exit;
        }
    }

    public function dashboard(): void {
        $this->requireAdmin();

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function users(): void {
        $this->requireAdmin();

        $users = $this->userModel->findAll();

        require __DIR__ . '/../views/admin/userList.php';
    }

    public function updateUser(): void {
        $this->requireAdmin();

        $allowedRoles = [
            'user',
            'organizer',
            'admin'
        ];

        $allowedStatuses = [
            'Überprüfung',
            'bestätigt',
            'Bearbeitung',
            'abgelehnt'
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header(
                'Location: /event-management-system/index.php?page=admin-users'
            );
            exit;
        }

        $userId = filter_input(
            INPUT_POST,
            'user_id',
            FILTER_VALIDATE_INT
        );

        $role = $_POST['role'] ?? '';
        $status = $_POST['status'] ?? '';

        if ($userId === false || $userId === null) {
            $this->showBadRequest("Die Benutzer-ID ist ungültig.");
        }

        if (!in_array($role, $allowedRoles, true)) {
            $this->showBadRequest('Ungültige Benutzerrolle.');
        }

        if (!in_array($status, $allowedStatuses, true)) {
            $this->showBadRequest('Ungültiger Benutzerstatus.');
        }

        if ( $userId === (int) $_SESSION['user_id'] && $role !== 'admin') {
            $this->showBadRequest(
                'Die eigene Admin-Rolle kann nicht entfernt werden.');
        }

        $updated = $this->userModel->updateRoleAndStatus(
            $userId,
            $role,
            $status
        );

        if ($updated) {
            header(
                'Location: /event-management-system/index.php?page=admin-users&updated=1'
            );
            exit;
        }

        $this->showBadRequest(
            'Die Benutzerdaten konnten nicht aktualisiert werden.'
        );
    }

    private function showBadRequest(string $message): void
    {
        http_response_code(400);

        require __DIR__ . '/../views/errors/400.php';

        exit;
    }
}