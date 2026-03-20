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

    case 'register':
        require_once "controllers/AuthController.php";
        header('Content-Type: application/json');
        (new AuthController())->register();
        break;

    case 'dashboard':
        require_once "config/auth_check.php";
        soloRol('admin');
        require_once "views/dashboard.php";
        break;

    case 'equipos':
        require_once "config/auth_check.php";
        soloRol('admin', 'cliente');
        if (isset($_GET['action']) && $_GET['action'] === 'store') {
            require_once "controllers/EquipoController.php";
            header('Content-Type: application/json');
            (new EquipoController())->store();
        } else {
            require_once "views/equipos.php";
        }
        break;

    case 'mantenimientos':
        require_once "config/auth_check.php";
        soloRol('admin', 'tecnico');
        if (isset($_GET['action']) && $_GET['action'] === 'store') {
            require_once "controllers/MantenimientoController.php";
            header('Content-Type: application/json');
            (new MantenimientoController())->store();
        } elseif (isset($_GET['action']) && $_GET['action'] === 'updateEstado') {
            require_once "controllers/MantenimientoController.php";
            header('Content-Type: application/json');
            (new MantenimientoController())->updateEstado();
        } else {
            require_once "views/mantenimientos.php";
        }
        break;

        case 'usuarios':
    require_once "config/auth_check.php";
    soloRol('admin');
    if (isset($_GET['action']) && $_GET['action'] === 'store') {
        require_once "controllers/UsuarioController.php";
        header('Content-Type: application/json');
        (new UsuarioController())->store();
    } else {
        require_once "views/usuarios.php";
    }
    break;

    default:
        require_once "controllers/AuthController.php";
        $controller = new AuthController();
        $controller->login();
        break;
}