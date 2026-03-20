<?php
require_once "models/UsuarioModel.php";

class UsuarioController {

    private $model;

    public function __construct() {
        $this->model = new UsuarioModel();
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nombre']) || empty($data['correo']) || empty($data['password']) || empty($data['rol'])) {
            echo json_encode(['status' => false, 'message' => 'Todos los campos son obligatorios.']);
            return;
        }

        $data['nombre']   = strip_tags(trim($data['nombre']));
        $data['correo']   = strip_tags(trim($data['correo']));
        $data['password'] = $data['password'];
        $data['rol']      = strip_tags(trim($data['rol']));

        $existente = $this->model->findByCorreo($data['correo']);
        if ($existente) {
            echo json_encode(['status' => false, 'message' => 'Ese correo ya está registrado.']);
            return;
        }

        $result = $this->model->save($data);
        echo json_encode([
            'status'  => $result,
            'message' => $result ? 'Usuario creado correctamente.' : 'Error al crear usuario.'
        ]);
    }
}