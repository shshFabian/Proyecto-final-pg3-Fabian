<?php
$titulo = "Usuarios";
require_once "config/auth_check.php";
soloRol('admin');
require_once "models/UsuarioModel.php";
$usuarios = (new UsuarioModel())->getAll();
require_once "views/layout.php";
?>

<div class="table-box">
    <div class="table-header">
        <h3>Lista de Usuarios</h3>
        <button class="btn btn-primary" onclick="abrirModal()">+ Nuevo Usuario</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id_usuario'] ?></td>
                <td><?= htmlspecialchars($u['nombre']) ?></td>
                <td><?= htmlspecialchars($u['correo']) ?></td>
                <td><span class="badge-estado badge-<?= $u['rol'] === 'admin' ? 'completado' : ($u['rol'] === 'tecnico' ? 'asignado' : 'pendiente') ?>"><?= $u['rol'] ?></span></td>
                <td><span class="badge-estado badge-<?= $u['estado'] ?>"><?= $u['estado'] ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODAL NUEVO USUARIO -->
<div class="modal-overlay" id="modal">
    <div class="modal">
        <h3>👤 Nuevo Usuario</h3>
        <div id="alert-usuario"></div>
        <div class="form-group">
            <label>Nombre completo</label>
            <input type="text" id="nombre" placeholder="Juan Pérez">
        </div>
        <div class="form-group">
            <label>Correo electrónico</label>
            <input type="email" id="correo" placeholder="juan@correo.com">
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" id="password" placeholder="••••••••">
        </div>
        <div class="form-group">
            <label>Rol</label>
            <select id="rol" style="width:100%; padding:10px 14px; background:#22253a; border:1px solid #2a2d3e; border-radius:6px; color:#fff; font-size:13px;">
                <option value="cliente">Cliente</option>
                <option value="tecnico">Técnico</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <div class="modal-actions">
            <button class="btn" onclick="cerrarModal()">Cancelar</button>
            <button class="btn btn-primary" onclick="guardarUsuario()">Guardar</button>
        </div>
    </div>
</div>

<script>
function abrirModal() {
    document.getElementById('modal').classList.add('active');
}

function cerrarModal() {
    document.getElementById('modal').classList.remove('active');
    document.getElementById('alert-usuario').innerHTML = '';
}

async function guardarUsuario() {
    const data = {
        nombre:   document.getElementById('nombre').value,
        correo:   document.getElementById('correo').value,
        password: document.getElementById('password').value,
        rol:      document.getElementById('rol').value
    };

    const response = await fetch('index.php?page=usuarios&action=store', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    const alerta = document.getElementById('alert-usuario');

    if (result.status) {
        alerta.innerHTML = '<div class="alert alert-success">✅ Usuario creado correctamente.</div>';
        setTimeout(() => { cerrarModal(); location.reload(); }, 1200);
    } else {
        alerta.innerHTML = '<div class="alert alert-error">❌ ' + result.message + '</div>';
    }
}
</script>

<?php require_once "views/layout_end.php"; ?>