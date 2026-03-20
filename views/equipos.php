<?php
$titulo = "Equipos";
require_once "config/auth_check.php";
require_once "models/EquipoModel.php";
require_once "views/layout.php";
$equipoModel = new EquipoModel();
$equipos = $_SESSION['rol'] === 'admin' 
    ? $equipoModel->getAll() 
    : $equipoModel->getByCliente($_SESSION['id_usuario']);
?>

<div class="table-box">
    <div class="table-header">
        <h3>Lista de Equipos</h3>
        <button class="btn btn-primary" onclick="abrirModal()">+ Nuevo Equipo</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Ubicación</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody id="tabla-equipos">
            <?php foreach ($equipos as $e): ?>
            <tr>
                <td><?= $e['id_equipo'] ?></td>
                <td><?= htmlspecialchars($e['codigo']) ?></td>
                <td><?= htmlspecialchars($e['nombre']) ?></td>
                <td><?= htmlspecialchars($e['tipo']) ?></td>
                <td><?= htmlspecialchars($e['marca']) ?></td>
                <td><?= htmlspecialchars($e['modelo']) ?></td>
                <td><?= htmlspecialchars($e['ubicacion']) ?></td>
                <td><span class="badge-estado badge-<?= $e['estado'] ?>"><?= $e['estado'] ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODAL NUEVO EQUIPO -->
<div class="modal-overlay" id="modal">
    <div class="modal">
        <h3>➕ Nuevo Equipo</h3>
        <div id="alert-equipo"></div>
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" id="nombre" placeholder="Laptop Dell">
        </div>
        <div class="form-group">
            <label>Tipo</label>
            <input type="text" id="tipo" placeholder="Computadora">
        </div>
        <div class="form-group">
            <label>Marca</label>
            <input type="text" id="marca" placeholder="Dell">
        </div>
        <div class="form-group">
            <label>Modelo</label>
            <input type="text" id="modelo" placeholder="Inspiron 15">
        </div>
        <div class="form-group">
            <label>Ubicación</label>
            <input type="text" id="ubicacion" placeholder="Oficina Principal">
        </div>
        <div class="modal-actions">
            <button class="btn" onclick="cerrarModal()">Cancelar</button>
            <button class="btn btn-primary" onclick="guardarEquipo()">Guardar</button>
        </div>
    </div>
</div>

<script>
function abrirModal() {
    document.getElementById('modal').classList.add('active');
}

function cerrarModal() {
    document.getElementById('modal').classList.remove('active');
    document.getElementById('alert-equipo').innerHTML = '';
}

async function guardarEquipo() {
    const data = {
        nombre:    document.getElementById('nombre').value,
        tipo:      document.getElementById('tipo').value,
        marca:     document.getElementById('marca').value,
        modelo:    document.getElementById('modelo').value,
        ubicacion: document.getElementById('ubicacion').value
    };

    const response = await fetch('index.php?page=equipos&action=store', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    const alert  = document.getElementById('alert-equipo');

    if (result.status) {
        alert.innerHTML = '<div class="alert alert-success">✅ Equipo guardado correctamente.</div>';
        setTimeout(() => { cerrarModal(); location.reload(); }, 1200);
    } else {
        alert.innerHTML = '<div class="alert alert-error">❌ ' + result.message + '</div>';
    }
}
</script>

<?php require_once "views/layout_end.php"; ?>