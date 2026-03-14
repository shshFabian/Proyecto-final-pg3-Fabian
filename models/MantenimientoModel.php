<?php
require_once "config/Conexion.php";

class MantenimientoModel {

    public function save($data) {
        $sql = "INSERT INTO mantenimientos (id_equipo, id_tecnico, descripcion, estado) 
                VALUES (?, ?, ?, ?)";
        $stmt = Conexion::get()->prepare($sql);
        return $stmt->execute([
            $data['id_equipo'],
            $data['id_tecnico'],
            $data['descripcion'],
            $data['estado']
        ]);
    }

    public function getAll() {
        $sql = "SELECT * FROM mantenimientos";
        $stmt = Conexion::get()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}