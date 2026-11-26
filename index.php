<?php

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';

require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Event.php';
require_once __DIR__ . '/models/Interest.php';
require_once __DIR__ . '/models/EventRegistration.php';

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/EventController.php';

$userModel = new User($pdo);
$eventModel = new Event($pdo);
$interestModel = new Interest($pdo);
$registrationModel = new EventRegistration($pdo);

$authController = new AuthController($userModel);
$adminController = new AdminController($userModel);
$eventController = new EventController(
    $eventModel,
    $interestModel,
    $registrationModel
);

$page = $_GET['page'] ?? 'home';

switch ($page) {

    case 'home':
        require __DIR__ . '/views/home.php';
        break;

# not logged in
    case 'register':
        $authController->register();
        break;
    
    case 'login':
        $authController->login();
        break;

# logged in
    case 'logout':
        $authController->logout();
        break;

    case 'profile':
        require __DIR__ . '/views/user/profile.php';
        break;

# events        
    case 'events':
        $eventController->list();
        break;

    case 'event-create':
        $eventController->create();
        break;

    case 'event-details':
        $eventController->details();
        break;
    
    case 'event-edit':
        $eventController->edit();
        break;

    # interests

    case 'event-interest-add':
        $eventController->addInterest();
        break;

    case 'event-interest-remove':
        $eventController->removeInterest();
        break;

    # registration

    case 'event-register':
        $eventController->registerForEvent();
        break;

    case 'event-registration-cancel':
        $eventController->cancelRegistration();
        break;

# admin control        
    case 'admin':
        $adminController->dashboard();
        break;

    case 'admin-users':
        $adminController->users();
        break;

    case 'admin-update-user':
        $adminController->updateUser();
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/views/errors/404.php';
        break;
}