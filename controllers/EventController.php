<?php

declare(strict_types=1);

class EventController
{
    private Event $eventModel;

    public function __construct(Event $eventModel) {
        $this->eventModel = $eventModel;
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

    public function list(): void {
        $this->requireLogin();

        $events = $this->eventModel->findAll();

        require __DIR__ . '/../views/events/list.php';
    }

    private function requireOrganizer(): void {
        $this->requireLogin();

        if (
            !isset($_SESSION['role']) ||
            !in_array(
                $_SESSION['role'],
                ['organizer', 'admin'],
                true
            )
        ) {
            http_response_code(403);

            require __DIR__ . '/../views/errors/403.php';

            exit;
        }
    }

    public function create(): void {
        $this->requireOrganizer();

        $errors = [];

        $title = '';
        $location = '';
        $description = '';
        $eventStart = '';
        $eventEnd = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = trim($_POST['title'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $eventStart = $_POST['event_start'] ?? '';
            $eventEnd = $_POST['event_end'] ?? '';

            if (empty($title)) {
                $errors[] = 'Bitte einen Titel eingeben.';
            }

            if (empty($eventStart)) {
                $errors[] = 'Bitte den Beginn der Veranstaltung angeben.';
            }

            if (empty($eventEnd)) {
                $errors[] = 'Bitte das Ende der Veranstaltung angeben.';
            }

            if (
                !empty($eventStart) &&
                !empty($eventEnd) &&
                strtotime($eventEnd) <= strtotime($eventStart)
            ) {
                $errors[] =
                    'Das Ende der Veranstaltung muss nach dem Beginn liegen.';
            }

            if (empty($errors)) {

                $created = $this->eventModel->create(
                    $title,
                    $location !== '' ? $location : null,
                    $description !== '' ? $description : null,
                    $eventStart,
                    $eventEnd,
                    (int) $_SESSION['user_id']
                );

                if ($created) {
                    header(
                        'Location: /event-management-system/index.php?page=events&created=1'
                    );
                    exit;
                }

                $errors[] =
                    'Die Veranstaltung konnte nicht erstellt werden.';
            }
        }
        $isEdit = false;
        $eventId = null;
        require __DIR__ . '/../views/events/form.php';
    }

    public function details(): void {
        $this->requireLogin();

        $eventId = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if ($eventId === false || $eventId === null) {
            http_response_code(400);
            require __DIR__ . '/../views/errors/400.php';
            exit;
        }

        $event = $this->eventModel->findById($eventId);

        if (!$event) {
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.php';
            exit;
        }

        require __DIR__ . '/../views/events/details.php';
    }

    public function edit(): void {
        $this->requireLogin();

        $eventId = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if ($eventId === false || $eventId === null) {
            http_response_code(400);
            require __DIR__ . '/../views/errors/400.php';
            exit;
        }

        $event = $this->eventModel->findById($eventId);

        if (!$event) {
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.php';
            exit;
        }

        $isAdmin =
            isset($_SESSION['role']) &&
            $_SESSION['role'] === 'admin';

        $isOwner =
            isset($_SESSION['role'], $_SESSION['user_id']) &&
            $_SESSION['role'] === 'organizer' &&
            (int) $_SESSION['user_id'] === (int) $event['organizer_id'];

        if (!$isAdmin && !$isOwner) {
            http_response_code(403);
            require __DIR__ . '/../views/errors/403.php';
            exit;
        }

        $errors = [];

        $title = $event['title'];
        $location = $event['location'] ?? '';
        $description = $event['description'] ?? '';

        $eventStart = date(
            'Y-m-d\TH:i',
            strtotime($event['event_start'])
        );

        $eventEnd = date(
            'Y-m-d\TH:i',
            strtotime($event['event_end'])
        );

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = trim($_POST['title'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $eventStart = $_POST['event_start'] ?? '';
            $eventEnd = $_POST['event_end'] ?? '';

            if (empty($title)) {
                $errors[] = 'Bitte einen Titel eingeben.';
            }

            if (empty($eventStart)) {
                $errors[] =
                    'Bitte den Beginn der Veranstaltung angeben.';
            }

            if (empty($eventEnd)) {
                $errors[] =
                    'Bitte das Ende der Veranstaltung angeben.';
            }

            if (
                !empty($eventStart) &&
                !empty($eventEnd) &&
                strtotime($eventEnd) <= strtotime($eventStart)
            ) {
                $errors[] =
                    'Das Ende der Veranstaltung muss nach dem Beginn liegen.';
            }

            if (empty($errors)) {

                $updated = $this->eventModel->update(
                    $eventId,
                    $title,
                    $location !== '' ? $location : null,
                    $description !== '' ? $description : null,
                    $eventStart,
                    $eventEnd
                );

                if ($updated) {
                    header(
                        'Location: /event-management-system/index.php?page=event-details&id='
                        . $eventId
                        . '&updated=1'
                    );

                    exit;
                }

                $errors[] =
                    'Die Veranstaltung konnte nicht aktualisiert werden.';
            }
        }
    $isEdit = true;
    require __DIR__ . '/../views/events/form.php';
    }    
}