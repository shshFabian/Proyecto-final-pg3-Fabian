<?php
require_once "models/UsuarioModel.php";

$model = new UsuarioModel();

// INSERT - guardar usuario de prueba
$model->save([
    'nombre'   => 'Juan Pérez',
    'correo'   => 'juan@gmail.com',
    'password' => '12345',
    'rol'      => 'cliente'
]);

echo "Usuario guardado.\n";

// SELECT - listar todos
$usuarios = $model->getAll();
foreach ($usuarios as $u) {
    echo $u['id_usuario'] . " - " . $u['nombre'] . " - " . $u['rol'] . "\n";
}