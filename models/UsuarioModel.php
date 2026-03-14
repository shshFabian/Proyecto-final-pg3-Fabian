<?php
require_once "config/Conexion.php";

class UsuarioModel {

    public function save($data) {
        $sql = "INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = Conexion::get()->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['correo'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['rol']
        ]);
    }

    public function getAll() {
        $sql = "SELECT * FROM usuarios";
        $stmt = Conexion::get()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findByCorreo($correo) {
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = Conexion::get()->prepare($sql);
    $stmt->execute([$correo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}