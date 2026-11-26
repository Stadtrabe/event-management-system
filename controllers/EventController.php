<?php

declare(strict_types=1);

class EventController
{
    private Event $eventModel;
    private Interest $interestModel;
    private EventRegistration $registrationModel;


    public function __construct(
        Event $eventModel,
        Interest $interestModel,
        EventRegistration $registrationModel
    ) {
        $this->eventModel = $eventModel;
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

    public function list(): void {
        $this->requireLogin();

        $events = $this->eventModel->findAll();

        $userId = (int) $_SESSION['user_id'];

        $interestedEventIds = $this->interestModel->findEventIdsByUser($userId);
        $registeredEventIds = array_map('intval', $this->registrationModel->findEventIdsByUser($userId));

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

        $userId = (int) $_SESSION['user_id'];

        $isInterested = $this->interestModel->exists(
            $userId,
            $eventId
        );

        $isRegistered = $this->registrationModel->exists(
            $userId,
            $eventId
        );

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

    private function redirectToEventContext(
        string $returnTo,
        int $eventId
    ): void {
        if (!in_array(
            $returnTo,
            ['list', 'details'],
            true
        )) {
            $returnTo = 'details';
        }

        if ($returnTo === 'list') {
            header(
                'Location: /event-management-system/index.php?page=events'
            );
            exit;
        }

        header(
            'Location: /event-management-system/index.php?page=event-details&id='
            . $eventId
        );

        exit;
    }

# INTERESTS    

    public function addInterest(): void {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            require __DIR__ . '/../views/errors/400.php';
            exit;
        }

        $eventId = filter_input(
            INPUT_POST,
            'event_id',
            FILTER_VALIDATE_INT
        );

        if ($eventId === false || $eventId === null) {
            http_response_code(400);
            require __DIR__ . '/../views/errors/400.php';
            exit;
        }

        $returnTo = $_POST['return_to'] ?? 'details';

        if (!in_array(
            $returnTo,
            ['list', 'details'],
            true)) {
            $returnTo = 'details';
        }

        $event = $this->eventModel->findById($eventId);

        if (!$event) {
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.php';
            exit;
        }

        $userId = (int) $_SESSION['user_id'];

        if (!$this->interestModel->exists($userId, $eventId)) {
            $this->interestModel->add(
                $userId,
                $eventId
            );
        }

        $this->redirectToEventContext(
            $returnTo,
            $eventId
        );
    }

    public function removeInterest(): void {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            require __DIR__ . '/../views/errors/400.php';
            exit;
        }

        $eventId = filter_input(
            INPUT_POST,
            'event_id',
            FILTER_VALIDATE_INT
        );

        if ($eventId === false || $eventId === null) {
            http_response_code(400);
            require __DIR__ . '/../views/errors/400.php';
            exit;
        }

        $returnTo = $_POST['return_to'] ?? 'details';

        if (!in_array(
            $returnTo,
            ['list', 'details'],
            true
        )) {
            $returnTo = 'details';
        }

        $userId = (int) $_SESSION['user_id'];

        $this->interestModel->remove(
            $userId,
            $eventId
        );

        $this->redirectToEventContext(
            $returnTo,
            $eventId
        );
    }

# ANMELDUNGEN
    public function registerForEvent(): void {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            require __DIR__ . '/../views/errors/400.php';
            exit;
        }

        $eventId = filter_input(
            INPUT_POST,
            'event_id',
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

        $userId = (int) $_SESSION['user_id'];

        if (!$this->registrationModel->exists($userId, $eventId)) {

            $registered = $this->registrationModel->add(
                $userId,
                $eventId
            );

            if (!$registered) {
                http_response_code(500);
                exit('Die Anmeldung konnte nicht gespeichert werden.');
            }
        }

        $returnTo = $_POST['return_to'] ?? 'details';

        $this->redirectToEventContext(
            $returnTo,
            $eventId
        );
    }

    public function cancelRegistration(): void {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            require __DIR__ . '/../views/errors/400.php';
            exit;
        }

        $eventId = filter_input(
            INPUT_POST,
            'event_id',
            FILTER_VALIDATE_INT
        );

        if ($eventId === false || $eventId === null) {
            http_response_code(400);
            require __DIR__ . '/../views/errors/400.php';
            exit;
        }

        $userId = (int) $_SESSION['user_id'];

        $this->registrationModel->remove(
            $userId,
            $eventId
        );

        $returnTo = $_POST['return_to'] ?? 'details';

        $this->redirectToEventContext(
            $returnTo,
            $eventId
        );
    }
}