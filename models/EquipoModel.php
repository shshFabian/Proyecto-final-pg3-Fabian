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
}