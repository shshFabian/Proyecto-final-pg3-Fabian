<?php
$titulo = "Mantenimientos";
require_once "config/auth_check.php";
require_once "models/MantenimientoModel.php";
require_once "models/EquipoModel.php";
require_once "models/UsuarioModel.php";

$mantenimientos = (new MantenimientoModel())->getAll();
$equipos        = (new EquipoModel())->getAll();
$usuarios       = (new UsuarioModel())->getAll();
$tecnicos       = array_filter($usuarios, fn($u) => $u['rol'] === 'tecnico');

require_once "views/layout.php";
?>

<div class="table-box">
    <div class="table-header">
        <h3>Lista de Mantenimientos</h3>
        <button class="btn btn-primary" onclick="abrirModal()">+ Nuevo Mantenimiento</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Equipo</th>
                <th>Técnico</th>
                <th>Descripción</th>
                <th>Fecha Solicitud</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mantenimientos as $m): ?>
            <tr>
                <td><?= $m['id_mantenimiento'] ?></td>
                <td><?= htmlspecialchars($m['nombre_equipo']) ?></td>
                <td><?= $m['nombre_tecnico'] ?? 'Sin asignar' ?></td>
                <td><?= htmlspecialchars($m['descripcion']) ?></td>
                <td><?= $m['fecha_solicitud'] ?></td>
                <td><span class="badge-estado badge-<?= $m['estado'] ?>"><?= $m['estado'] ?></span></td>
                <td>
                    <select onchange="cambiarEstado(<?= $m['id_mantenimiento'] ?>, this.value)"
                            style="background:#22253a; color:#fff; border:1px solid #2a2d3e; padding:4px 8px; border-radius:6px; font-size:12px;">
                        <option value="pendiente"  <?= $m['estado']==='pendiente'  ? 'selected':'' ?>>Pendiente</option>
                        <option value="asignado"   <?= $m['estado']==='asignado'   ? 'selected':'' ?>>Asignado</option>
                        <option value="en_proceso" <?= $m['estado']==='en_proceso' ? 'selected':'' ?>>En Proceso</option>
                        <option value="completado" <?= $m['estado']==='completado' ? 'selected':'' ?>>Completado</option>
                        <option value="cancelado"  <?= $m['estado']==='cancelado'  ? 'selected':'' ?>>Cancelado</option>
                    </select>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODAL NUEVO MANTENIMIENTO -->
<div class="modal-overlay" id="modal">
    <div class="modal">
        <h3>🔧 Nuevo Mantenimiento</h3>
        <div id="alert-mant"></div>
        <div class="form-group">
            <label>Equipo</label>
            <select id="id_equipo">
                <option value="">Seleccionar equipo</option>
                <?php foreach ($equipos as $e): ?>
                <option value="<?= $e['id_equipo'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Técnico</label>
            <select id="id_tecnico">
                <option value="">Sin asignar</option>
                <?php foreach ($tecnicos as $t): ?>
                <option value="<?= $t['id_usuario'] ?>"><?= htmlspecialchars($t['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Descripción</label>
            <textarea id="descripcion" rows="3" placeholder="Describe el problema..."></textarea>
        </div>
        <div class="form-group">
            <label>Estado</label>
            <select id="estado">
                <option value="pendiente">Pendiente</option>
                <option value="asignado">Asignado</option>
            </select>
        </div>
        <div class="modal-actions">
            <button class="btn" onclick="cerrarModal()">Cancelar</button>
            <button class="btn btn-primary" onclick="guardarMantenimiento()">Guardar</button>
        </div>
    </div>
</div>

<script>
function abrirModal() {
    document.getElementById('modal').classList.add('active');
}

function cerrarModal() {
    document.getElementById('modal').classList.remove('active');
    document.getElementById('alert-mant').innerHTML = '';
}

async function guardarMantenimiento() {
    const data = {
        id_equipo:   document.getElementById('id_equipo').value,
        id_tecnico:  document.getElementById('id_tecnico').value,
        descripcion: document.getElementById('descripcion').value,
        estado:      document.getElementById('estado').value
    };

    const response = await fetch('index.php?page=mantenimientos&action=store', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    const alert  = document.getElementById('alert-mant');

    if (result.status) {
        alert.innerHTML = '<div class="alert alert-success">✅ Mantenimiento guardado correctamente.</div>';
        setTimeout(() => { cerrarModal(); location.reload(); }, 1200);
    } else {
        alert.innerHTML = '<div class="alert alert-error">❌ ' + result.message + '</div>';
    }
}

async function cambiarEstado(id, estado) {
    const response = await fetch('index.php?page=mantenimientos&action=updateEstado', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_mantenimiento: id, estado: estado })
    });

    const result = await response.json();
    if (result.status) {
        location.reload();
    } else {
        alert('Error al actualizar el estado.');
    }
}
</script>

<?php require_once "views/layout_end.php"; ?>