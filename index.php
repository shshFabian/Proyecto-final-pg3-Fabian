<?php
session_start();

require_once "config/Conexion.php";

$page = isset($_GET['page']) ? strip_tags($_GET['page']) : 'login';

switch ($page) {

    case 'login':
        require_once "controllers/AuthController.php";
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        require_once "controllers/AuthController.php";
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'dashboard':
        require_once "config/auth_check.php";
        echo "Bienvenido al Dashboard, " . $_SESSION['nombre'];
        break;

    case 'equipos':
        require_once "config/auth_check.php";
        echo "Sección de Equipos";
        break;

    case 'mantenimientos':
        require_once "config/auth_check.php";
        echo "Sección de Mantenimientos";
        break;

    default:
        require_once "controllers/AuthController.php";
        $controller = new AuthController();
        $controller->login();
        break;
}