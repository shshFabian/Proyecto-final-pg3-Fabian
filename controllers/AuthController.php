<?php
require_once "models/UsuarioModel.php";

class AuthController {

    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Sanitizar inputs
            $correo   = strip_tags(trim($_POST['correo']));
            $password = strip_tags(trim($_POST['password']));

            // 2. Validar que no estén vacíos
            if (empty($correo) || empty($password)) {
                $error = "Todos los campos son obligatorios.";
                require_once "views/login.php";
                return;
            }

            // 3. Buscar usuario en la BD
            $usuario = $this->usuarioModel->findByCorreo($correo);

            // 4. Verificar contraseña
            if ($usuario && password_verify($password, $usuario['password'])) {

                // 5. Iniciar sesión y guardar datos

                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre']     = $usuario['nombre'];
                $_SESSION['rol']        = $usuario['rol'];

                
                // 6. Redirigir según rol
                if ($usuario['rol'] === 'admin') {
                    header("Location: index.php?page=dashboard");
                } elseif ($usuario['rol'] === 'tecnico') {
                    header("Location: index.php?page=mantenimientos");
                } else {
                    header("Location: index.php?page=equipos");
                }
                exit();

            } else {
                $error = "Correo o contraseña incorrectos.";
                require_once "views/login.php";
                return;
            }
        } else {
            require_once "views/login.php";
        }
    }

public function logout() {
    session_destroy();
    header("Location: index.php");
    exit();
}
}