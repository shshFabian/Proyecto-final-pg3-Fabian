<?php
require_once "models/MantenimientoModel.php";

class MantenimientoController {

    private $model;

    public function __construct() {
        $this->model = new MantenimientoModel();
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['id_equipo']) || empty($data['descripcion'])) {
            echo json_encode(['status' => false, 'message' => 'Equipo y descripción son obligatorios.']);
            return;
        }

        $data['id_equipo']   = (int) $data['id_equipo'];
        $data['id_tecnico']  = !empty($data['id_tecnico']) ? (int) $data['id_tecnico'] : null;
        $data['descripcion'] = strip_tags(trim($data['descripcion']));
        $data['estado']      = strip_tags(trim($data['estado'] ?? 'pendiente'));

        $result = $this->model->save($data);

        echo json_encode([
            'status'  => $result,
            'message' => $result ? 'Mantenimiento guardado.' : 'Error al guardar.'
        ]);
    }

    public function updateEstado() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['id_mantenimiento']) || empty($data['estado'])) {
            echo json_encode(['status' => false, 'message' => 'Datos incompletos.']);
            return;
        }

        $id     = (int) $data['id_mantenimiento'];
        $estado = strip_tags(trim($data['estado']));

        $result = $this->model->updateEstado($id, $estado);

        echo json_encode([
            'status'  => $result,
            'message' => $result ? 'Estado actualizado.' : 'Error al actualizar.'
        ]);
    }
}