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
    $sql = "SELECT m.*, 
                   e.nombre AS nombre_equipo,
                   u.nombre AS nombre_tecnico
            FROM mantenimientos m
            LEFT JOIN equipos e ON m.id_equipo = e.id_equipo
            LEFT JOIN usuarios u ON m.id_tecnico = u.id_usuario";
    $stmt = Conexion::get()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateEstado($id, $estado) {
    $sql = "UPDATE mantenimientos SET estado = ? WHERE id_mantenimiento = ?";
    $stmt = Conexion::get()->prepare($sql);
    return $stmt->execute([$estado, $id]);
}
}