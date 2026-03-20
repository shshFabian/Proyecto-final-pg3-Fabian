<?php
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

function soloRol(...$roles) {
    if (!in_array($_SESSION['rol'], $roles)) {
        header("Location: index.php?page=" . rolDefault());
        exit();
    }
}

function rolDefault() {
    return match($_SESSION['rol']) {
        'admin'   => 'dashboard',
        'tecnico' => 'mantenimientos',
        'cliente' => 'equipos',
        default   => 'login'
    };
}