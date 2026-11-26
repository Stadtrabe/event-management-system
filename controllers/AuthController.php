<?php

declare(strict_types=1);

class AuthController
{
    private User $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    public function register(): void {
        $errors = [];
        $username = '';
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if (empty($username)) {
                $errors[] = 'Bitte einen Benutzernamen eingeben.';
            }

            if (empty($email)) {
                $errors[] = 'Bitte eine E-Mail-Adresse eingeben.';
            }

            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Bitte eine gültige E-Mail-Adresse einzugeben.';
            }

            if (empty($password)) {
                $errors[] = 'Bitte ein Passwort eingeben.';
            }

            if ($password !== $passwordConfirm) {
                $errors[] = 'Die Passwörter stimmen nicht überein.';
            }

            if (!empty($password) && strlen($password) < 8) {
                $errors[] = 'Das Passwort muss mindestens 8 Zeichen lang sein.';
            }

            if (empty($errors)) {
                $existingUser = $this->userModel->findByEmail($email);

                if ($existingUser) {
                    $errors[] = 'Diese E-Mail-Adresse ist bereits registriert.';
                }
            }

            if (empty($errors)) {
                $passwordHash = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $created = $this->userModel->create(
                    $username,
                    $email,
                    $passwordHash
                );

                if ($created) {
                    header(
                        'Location: /event-management-system/index.php?page=login&registered=1'
                    );
                    exit;
                }

                $errors[] = 'Die Registrierung konnte nicht abgeschlossen werden.';
            }
        }
        
    require __DIR__ . '/../views/auth/register.php';
    }

    public function login(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $errors = [];
        $email = '';
        $successMessage = '';
        $user = false;

        if (isset($_GET['registered'])) {
            $successMessage =
                'Die Registrierung war erfolgreich. Bitte melden Sie sich an.';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email)) {
                $errors[] = 'Bitte eine E-Mail-Adresse eingeben.';
            }

            if (
                !empty($email) &&
                !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Bitte eine gültige E-Mail-Adresse eingeben.';
            }

            if (empty($password)) {
                $errors[] = 'Bitte ein Passwort eingeben.';
            }

            if (empty($errors)) {
                $user = $this->userModel->findByEmail($email);

                if (!$user) {
                    $errors[] =
                        'Kein Benutzer mit dieser E-Mail-Adresse gefunden.';
                }
            }

            if (empty($errors) && $user !== false) {
                if (!password_verify(
                    $password,
                    $user['password_hash']
                )) {
                    $errors[] = 'Falsches Passwort.';
                }
            }

            if (empty($errors) && $user !== false) {
                $_SESSION['user_id'] = 
                    $user['user_id'];
                $_SESSION['username'] = 
                    $user['username'];
                $_SESSION['role'] = 
                    $user['role'];

                if ($user['role'] === 'admin') {
                    header(
                        'Location: /event-management-system/index.php?page=admin'
                    );
                    exit;
                }

                header(
                    'Location: /event-management-system/index.php?page=events'
                );
                exit;
            }
        }

    require __DIR__ . '/../views/auth/login.php';
    }

    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header(
            'Location: /event-management-system/index.php?page=login'
        );

        exit;
    }
}