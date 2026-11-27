<?php

declare(strict_types=1);

class UserController {
    private Interest $interestModel;
    private EventRegistration $registrationModel;
    private User $userModel;

    public function __construct(
        User $userModel,
        Interest $interestModel,
        EventRegistration $registrationModel) {
            $this->userModel = $userModel;
            $this->interestModel = $interestModel;
            $this->registrationModel = $registrationModel;
    }

    private function requireLogin(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header(
                'Location: /event-management-system/index.php?page=login'
            );
            exit;
        }
    }

    public function myEvents(): void {
        $this->requireLogin();

        $userId = (int) $_SESSION['user_id'];

        $registeredEvents =
            $this->registrationModel->findEventsByUser($userId);

        $interestedEvents =
            $this->interestModel->findEventsByUser($userId);

        $registeredEventIds = array_map(
            'intval',
            $this->registrationModel->findEventIdsByUser($userId)
        );

        $interestedEventIds = array_map(
            'intval',
            $this->interestModel->findEventIdsByUser($userId)
        );

        require __DIR__ . '/../views/user/my-events.php';
    }

    public function profile(): void {
        $this->requireLogin();

        $userId = (int) $_SESSION['user_id'];

        $user = $this->userModel->findById($userId);

        if (!$user) {
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.php';
            exit;
        }

        $errors = [];
        $successMessage = '';

        $username = $user['username'];
        $email = $user['email'];

        $newPassword = '';
        $passwordConfirm = '';

        if (isset($_GET['updated'])) {
            $successMessage =
                'Das Profil wurde erfolgreich aktualisiert.';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');

            $newPassword = $_POST['new_password'] ?? '';
            $passwordConfirm =
                $_POST['password_confirm'] ?? '';

            if (empty($username)) {
                $errors[] =
                    'Bitte einen Benutzernamen eingeben.';
            }

            if (mb_strlen($username) > 45) {
                $errors[] =
                    'Der Benutzername darf höchstens 45 Zeichen lang sein.';
            }

            if (empty($email)) {
                $errors[] =
                    'Bitte eine E-Mail-Adresse eingeben.';
            }

            if (!empty($email) && !filter_var(
                    $email,
                    FILTER_VALIDATE_EMAIL)) {
                $errors[] ='Bitte eine gültige E-Mail-Adresse eingeben.';
            }

            if (mb_strlen($email) > 100) {
                $errors[] = 'Die E-Mail-Adresse darf höchstens 100 Zeichen lang sein.';
            }

            if (empty($errors)) {
                $existingUser = $this->userModel->findByEmail($email);

                if ($existingUser && (int) $existingUser['user_id'] !== $userId) {
                    $errors[] = 'Diese E-Mail-Adresse wird bereits verwendet.';
                }
            }

            $wantsPasswordChange =
                $newPassword !== '' ||
                $passwordConfirm !== '';

            if ($wantsPasswordChange) {
                if (empty($newPassword)) {
                    $errors[] = 'Bitte ein neues Passwort eingeben.';
                }

                if (empty($passwordConfirm)) {
                    $errors[] = 'Bitte das neue Passwort bestätigen.';
                }

                if (!empty($newPassword) &&  strlen($newPassword) < 8) {
                    $errors[] = 'Das neue Passwort muss mindestens 8 Zeichen lang sein.';
                }

                if ($newPassword !== $passwordConfirm) {
                    $errors[] = 'Die neuen Passwörter stimmen nicht überein.';
                }
            }

            if (empty($errors)) {
                $updated =
                    $this->userModel->updateProfile(
                        $userId,
                        $username,
                        $email);

                if (!$updated) {
                    $errors[] = 'Die Profildaten konnten nicht aktualisiert werden.';
                }
            }

            if (empty($errors) && $wantsPasswordChange) {
                $passwordHash = password_hash(
                    $newPassword,
                    PASSWORD_DEFAULT
                );

                $passwordUpdated =
                    $this->userModel->updatePassword(
                        $userId,
                        $passwordHash
                    );

                if (!$passwordUpdated) {
                    $errors[] = 'Das Passwort konnte nicht aktualisiert werden.';
                }
            }

            if (empty($errors)) {
                $_SESSION['username'] = $username;
                header('Location: /event-management-system/index.php?page=profile&updated=1');
                exit;
            }
        }

        require __DIR__ . '/../views/user/profile.php';
    }
}