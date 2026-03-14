<?php
require_once "models/EquipoModel.php";
require_once "models/MantenimientoModel.php";

$equipoModel = new EquipoModel();
$mantenimientoModel = new MantenimientoModel();

// INSERT equipos
$equipoModel->save([
    'id_cliente'  => 3,
    'codigo'      => 'EQ-001',
    'nombre'      => 'Laptop Dell',
    'tipo'        => 'Computadora',
    'marca'       => 'Dell',
    'modelo'      => 'Inspiron 15',
    'descripcion' => 'Laptop con problema de pantalla',
    'ubicacion'   => 'Oficina Principal'
]);

$equipoModel->save([
    'id_cliente'  => 3,
    'codigo'      => 'EQ-002',
    'nombre'      => 'Impresora HP',
    'tipo'        => 'Impresora',
    'marca'       => 'HP',
    'modelo'      => 'LaserJet 1020',
    'descripcion' => 'Impresora con atasco de papel',
    'ubicacion'   => 'Sala de reuniones'
]);

echo "Equipos guardados.\n";

// INSERT mantenimientos
$mantenimientoModel->save([
    'id_equipo'   => 1,
    'id_tecnico'  => 2,
    'descripcion' => 'Revisión y cambio de pantalla',
    'estado'      => 'asignado'
]);

$mantenimientoModel->save([
    'id_equipo'   => 2,
    'id_tecnico'  => 2,
    'descripcion' => 'Limpieza y revisión de rodillos',
    'estado'      => 'pendiente'
]);

echo "Mantenimientos guardados.\n";

// PARA SELECT ambos
echo "\n--- EQUIPOS ---\n";
foreach ($equipoModel->getAll() as $e) {
    echo $e['id_equipo'] . " - " . $e['nombre'] . " - " . $e['marca'] . "\n";
}

echo "\n--- MANTENIMIENTOS ---\n";
foreach ($mantenimientoModel->getAll() as $m) {
    echo $m['id_mantenimiento'] . " - " . $m['descripcion'] . " - " . $m['estado'] . "\n";
}
