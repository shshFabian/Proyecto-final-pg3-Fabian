<?php
require_once "models/EquipoModel.php";

class EquipoController {

    private $model;

    public function __construct() {
        $this->model = new EquipoModel();
    }

    public function store() {
        // Leer JSON que viene del Fetch
        $data = json_decode(file_get_contents("php://input"), true);
        //Generar código único
        $data['codigo'] = $this->model->generarCodigo();

        // Validar campos obligatorios
        if (empty($data['codigo']) || empty($data['nombre'])) {
            echo json_encode(['status' => false, 'message' => 'Código y nombre son obligatorios.']);
            return;
        }

        // Sanitizar
        $data['codigo']    = strip_tags(trim($data['codigo']));
        $data['nombre']    = strip_tags(trim($data['nombre']));
        $data['tipo']      = strip_tags(trim($data['tipo'] ?? ''));
        $data['marca']     = strip_tags(trim($data['marca'] ?? ''));
        $data['modelo']    = strip_tags(trim($data['modelo'] ?? ''));
        $data['ubicacion'] = strip_tags(trim($data['ubicacion'] ?? ''));
        $data['descripcion'] = strip_tags(trim($data['descripcion'] ?? ''));
        $data['id_cliente'] = $_SESSION['id_usuario'];

        // Guardar
        $result = $this->model->save($data);

        echo json_encode([
            'status'  => $result,
            'message' => $result ? 'Equipo guardado.' : 'Error al guardar.'
        ]);
    }
}