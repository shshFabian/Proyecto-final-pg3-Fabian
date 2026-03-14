<?php
require_once "config/Conexion.php";
require_once "models/UsuarioModel.php";

$model = new UsuarioModel();
$usuario = $model->findByCorreo('admin@empresa.com');

echo "Usuario encontrado: " . $usuario['nombre'] . "<br>";
echo "Hash en BD: " . $usuario['password'] . "<br>";
echo "Verificacion: ";
var_dump(password_verify('123456', $usuario['password']));