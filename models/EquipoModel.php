<?php
require_once "config/Conexion.php";

class EquipoModel {

    public function save($data) {
        $sql = "INSERT INTO equipos (id_cliente, codigo, nombre, tipo, marca, modelo, descripcion, ubicacion) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = Conexion::get()->prepare($sql);
        return $stmt->execute([
            $data['id_cliente'],
            $data['codigo'],
            $data['nombre'],
            $data['tipo'],
            $data['marca'],
            $data['modelo'],
            $data['descripcion'],
            $data['ubicacion']
        ]);
    }

    public function getAll() {
        $sql = "SELECT * FROM equipos";
        $stmt = Conexion::get()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function generarCodigo() {
    $sql = "SELECT COUNT(*) as total FROM equipos";
    $stmt = Conexion::get()->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $numero = str_pad($result['total'] + 1, 3, '0', STR_PAD_LEFT);
    return "EQ-" . $numero;
}

public function getByCliente($id_cliente) {
    $sql = "SELECT * FROM equipos WHERE id_cliente = ?";
    $stmt = Conexion::get()->prepare($sql);
    $stmt->execute([$id_cliente]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}