<?php
require_once "models/UsuarioModel.php";

class AuthController {

    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $correo   = strip_tags(trim($_POST['correo']));
            $password = strip_tags(trim($_POST['password']));

            if (empty($correo) || empty($password)) {
                $error = "Todos los campos son obligatorios.";
                require_once "views/login.php";
                return;
            }

            $usuario = $this->usuarioModel->findByCorreo($correo);

            if ($usuario && password_verify($password, $usuario['password'])) {

                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre']     = $usuario['nombre'];
                $_SESSION['rol']        = $usuario['rol'];

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

    public function register() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nombre']) || empty($data['correo']) || empty($data['password'])) {
            echo json_encode(['status' => false, 'message' => 'Todos los campos son obligatorios.']);
            return;
        }

        $data['nombre']   = strip_tags(trim($data['nombre']));
        $data['correo']   = strip_tags(trim($data['correo']));
        $data['password'] = $data['password'];
        $data['rol']      = 'cliente';

        $existente = $this->usuarioModel->findByCorreo($data['correo']);
        if ($existente) {
            echo json_encode(['status' => false, 'message' => 'Ese correo ya está registrado.']);
            return;
        }

        $result = $this->usuarioModel->save($data);
        echo json_encode([
            'status'  => $result,
            'message' => $result ? 'Cuenta creada exitosamente.' : 'Error al registrar.'
        ]);
    }
}