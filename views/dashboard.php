<?php
$titulo = "Dashboard";
require_once "config/auth_check.php";
require_once "models/UsuarioModel.php";
require_once "models/EquipoModel.php";
require_once "models/MantenimientoModel.php";

$usuarios       = (new UsuarioModel())->getAll();
$equipos        = (new EquipoModel())->getAll();
$mantenimientos = (new MantenimientoModel())->getAll();

$pendientes  = count(array_filter($mantenimientos, fn($m) => $m['estado'] === 'pendiente'));
$completados = count(array_filter($mantenimientos, fn($m) => $m['estado'] === 'completado'));

require_once "views/layout.php";
?>

<div class="cards-grid">
    <div class="card purple">
        <div class="card-label">Usuarios</div>
        <div class="card-value"><?= count($usuarios) ?></div>
        <div class="card-sub">Registrados en el sistema</div>
    </div>
    <div class="card green">
        <div class="card-label">Equipos</div>
        <div class="card-value"><?= count($equipos) ?></div>
        <div class="card-sub">Equipos activos</div>
    </div>
    <div class="card orange">
        <div class="card-label">Pendientes</div>
        <div class="card-value"><?= $pendientes ?></div>
        <div class="card-sub">Mantenimientos por atender</div>
    </div>
    <div class="card red">
        <div class="card-label">Completados</div>
        <div class="card-value"><?= $completados ?></div>
        <div class="card-sub">Mantenimientos finalizados</div>
    </div>
</div>

<div class="table-box">
    <div class="table-header">
        <h3>Últimos Mantenimientos</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Equipo</th>
                <th>Descripción</th>
                <th>Fecha Solicitud</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mantenimientos as $m): ?>
            <tr>
                <td><?= $m['id_mantenimiento'] ?></td>
                <td><?= $m['id_equipo'] ?></td>
                <td><?= htmlspecialchars($m['descripcion']) ?></td>
                <td><?= $m['fecha_solicitud'] ?></td>
                <td><span class="badge-estado badge-<?= $m['estado'] ?>"><?= $m['estado'] ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once "views/layout_end.php"; ?>