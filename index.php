<?php

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/AdminController.php';

$userModel = new User($pdo);

$authController = new AuthController($userModel);
$adminController = new AdminController($userModel);

$page = $_GET['page'] ?? 'home';

switch ($page) {

    case 'register':
        $authController->register();
        break;

    case 'home':
        require __DIR__ . '/views/home.php';
        break;
    
    case 'login':
        $authController->login();
        break;

    case 'events':
        require __DIR__ . '/views/events/list.php';
        break;

    case 'admin':
        $adminController->dashboard();
        break;

    case 'admin-users':
        $adminController->users();
        break;

    case 'admin-update-user':
        $adminController->updateUser();
        break;

    case 'logout':
        $authController->logout();
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/views/errors/404.php';
        break;
}