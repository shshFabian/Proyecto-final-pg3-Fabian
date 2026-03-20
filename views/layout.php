<?php if (!isset($_SESSION['id_usuario'])) die(header("Location: index.php")); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Mantenimiento</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f1117;
            color: #e0e0e0;
            display: flex;
            height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #1a1d27;
            display: flex;
            flex-direction: column;
            padding: 24px 0;
            border-right: 1px solid #2a2d3e;
            flex-shrink: 0;
        }

        .sidebar-logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid #2a2d3e;
            margin-bottom: 16px;
        }

        .sidebar-logo h2 {
            font-size: 15px;
            color: #7c83fd;
            font-weight: 600;
        }

        .sidebar-logo p {
            font-size: 11px;
            color: #666;
            margin-top: 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: #888;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover, .nav-item.active {
            color: #fff;
            background: #22253a;
            border-left-color: #7c83fd;
        }

        .nav-item span.icon { font-size: 16px; }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 24px;
            border-top: 1px solid #2a2d3e;
        }

        .sidebar-footer p {
            font-size: 11px;
            color: #555;
            margin-bottom: 8px;
        }

        .sidebar-footer strong {
            color: #aaa;
            font-size: 12px;
        }

        .btn-logout {
            display: block;
            width: 100%;
            padding: 8px;
            background: #2a2d3e;
            color: #888;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            margin-top: 8px;
            transition: all 0.2s;
        }

        .btn-logout:hover { background: #e53935; color: white; }

        /* MAIN */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            background: #1a1d27;
            padding: 16px 32px;
            border-bottom: 1px solid #2a2d3e;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar h1 {
            font-size: 18px;
            font-weight: 600;
            color: #fff;
        }

        .topbar .badge {
            background: #7c83fd22;
            color: #7c83fd;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            border: 1px solid #7c83fd44;
        }

        .content {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
        }

        /* CARDS */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .card {
            background: #1a1d27;
            border: 1px solid #2a2d3e;
            border-radius: 12px;
            padding: 24px;
        }

        .card-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .card-value {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
        }

        .card-sub {
            font-size: 11px;
            color: #555;
            margin-top: 4px;
        }

        .card.purple { border-top: 3px solid #7c83fd; }
        .card.green  { border-top: 3px solid #43a047; }
        .card.orange { border-top: 3px solid #fb8c00; }
        .card.red    { border-top: 3px solid #e53935; }

        /* TABLE */
        .table-box {
            background: #1a1d27;
            border: 1px solid #2a2d3e;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-header {
            padding: 16px 24px;
            border-bottom: 1px solid #2a2d3e;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 { font-size: 14px; color: #fff; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #22253a;
            padding: 12px 20px;
            text-align: left;
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 14px 20px;
            font-size: 13px;
            border-bottom: 1px solid #1e2130;
            color: #ccc;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #22253a; }

        /* BADGES DE ESTADO */
        .badge-estado {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-pendiente  { background: #fb8c0022; color: #fb8c00; border: 1px solid #fb8c0044; }
        .badge-asignado   { background: #7c83fd22; color: #7c83fd; border: 1px solid #7c83fd44; }
        .badge-en_proceso { background: #0288d122; color: #0288d1; border: 1px solid #0288d144; }
        .badge-completado { background: #43a04722; color: #43a047; border: 1px solid #43a04744; }
        .badge-cancelado  { background: #e5393522; color: #e53935; border: 1px solid #e5393544; }
        .badge-activo     { background: #43a04722; color: #43a047; border: 1px solid #43a04744; }
        .badge-inactivo   { background: #e5393522; color: #e53935; border: 1px solid #e5393544; }

        /* BOTONES */
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary { background: #7c83fd; color: white; }
        .btn-primary:hover { background: #6970e0; }
        .btn-danger  { background: #e5393522; color: #e53935; border: 1px solid #e5393544; }
        .btn-danger:hover { background: #e53935; color: white; }

        /* FORM */
        .form-group { margin-bottom: 16px; }

        .form-group label {
            display: block;
            font-size: 12px;
            color: #888;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            background: #22253a;
            border: 1px solid #2a2d3e;
            border-radius: 6px;
            color: #fff;
            font-size: 13px;
            outline: none;
            transition: border 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #7c83fd;
        }

        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: #00000088;
            z-index: 100;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.active { display: flex; }

        .modal {
            background: #1a1d27;
            border: 1px solid #2a2d3e;
            border-radius: 12px;
            padding: 32px;
            width: 100%;
            max-width: 480px;
        }

        .modal h3 {
            font-size: 16px;
            color: #fff;
            margin-bottom: 20px;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        /* ALERT */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .alert-success { background: #43a04722; color: #43a047; border: 1px solid #43a04744; }
        .alert-error   { background: #e5393522; color: #e53935; border: 1px solid #e5393544; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <h2>⚙️ MantenimientoApp</h2>
            <p>Sistema de Gestión Técnica</p>
        </div>

        <nav>
            <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="index.php?page=dashboard" class="nav-item <?= $page === 'dashboard' ? 'active' : '' ?>">
                    <span class="icon">📊</span> Dashboard
                </a>
                <a href="index.php?page=usuarios" class="nav-item <?= $page === 'usuarios' ? 'active' : '' ?>">
                    <span class="icon">👥</span> Usuarios
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'tecnico'): ?>
                <a href="index.php?page=mantenimientos" class="nav-item <?= $page === 'mantenimientos' ? 'active' : '' ?>">
                    <span class="icon">🔧</span> Mantenimientos
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'cliente'): ?>
                <a href="index.php?page=equipos" class="nav-item <?= $page === 'equipos' ? 'active' : '' ?>">
                    <span class="icon">💻</span> Equipos
                </a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-footer">
            <p>Sesión activa</p>
            <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>
            <br>
            <small style="color:#555"><?= $_SESSION['rol'] ?></small>
            <a href="index.php?page=logout" class="btn-logout">Cerrar Sesión</a>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <h1><?= $titulo ?? 'Panel' ?></h1>
            <span class="badge"><?= strtoupper($_SESSION['rol']) ?></span>
        </div>
        <div class="content">