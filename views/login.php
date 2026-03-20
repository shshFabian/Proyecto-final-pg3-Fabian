<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistema de Mantenimiento</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #0f1117;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: #1a1d27;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
            border: 1px solid #2a2d3e;
        }

        h2 {
            text-align: center;
            color: #7c83fd;
            margin-bottom: 8px;
            font-size: 20px;
        }

        p.subtitle {
            text-align: center;
            color: #555;
            font-size: 13px;
            margin-bottom: 24px;
        }

        .form-group { margin-bottom: 16px; }

        label {
            display: block;
            font-size: 12px;
            color: #888;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px 14px;
            background: #22253a;
            border: 1px solid #2a2d3e;
            border-radius: 6px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: border 0.2s;
        }

        input:focus { border-color: #7c83fd; }

        button {
            width: 100%;
            padding: 12px;
            background: #7c83fd;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 8px;
            transition: all 0.2s;
        }

        button:hover { background: #6970e0; }

        .btn-secondary {
            background: transparent;
            border: 1px solid #2a2d3e;
            color: #888;
            margin-top: 8px;
        }

        .btn-secondary:hover {
            border-color: #7c83fd;
            color: #7c83fd;
            background: transparent;
        }

        .error {
            background: #e5393522;
            color: #e53935;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 16px;
            border: 1px solid #e5393544;
        }

        .success {
            background: #43a04722;
            color: #43a047;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 16px;
            border: 1px solid #43a04744;
        }

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
            max-width: 400px;
        }

        .modal h3 {
            color: #7c83fd;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .modal input {
            width: 100%;
            padding: 10px 14px;
            background: #22253a;
            border: 1px solid #2a2d3e;
            border-radius: 6px;
            color: #fff;
            font-size: 13px;
            outline: none;
            margin-bottom: 14px;
        }

        .modal input:focus { border-color: #7c83fd; }

        .modal-actions { display: flex; gap: 12px; margin-top: 8px; }
        .modal-actions button { margin-top: 0; }
        .btn-cancel { background: #22253a; color: #888; }
        .btn-cancel:hover { background: #2a2d3e; }
        #alert-register { margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>⚙️ MantenimientoApp</h2>
        <p class="subtitle">Ingresa tus credenciales para continuar</p>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=login">
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="correo" placeholder="ejemplo@correo.com" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
            <button type="button" class="btn-secondary" onclick="abrirRegistro()">
                ¿No tienes cuenta? Regístrate
            </button>
        </form>
    </div>

    <!-- MODAL REGISTRO -->
    <div class="modal-overlay" id="modal-registro">
        <div class="modal">
            <h3>👤 Crear Cuenta</h3>
            <div id="alert-register"></div>
            <input type="text" id="reg-nombre" placeholder="Nombre completo">
            <input type="email" id="reg-correo" placeholder="Correo electrónico">
            <input type="password" id="reg-password" placeholder="Contraseña">
            <div class="modal-actions">
                <button class="btn-cancel" onclick="cerrarRegistro()">Cancelar</button>
                <button onclick="registrarse()">Crear Cuenta</button>
            </div>
        </div>
    </div>

    <script>
    function abrirRegistro() {
        document.getElementById('modal-registro').classList.add('active');
    }

    function cerrarRegistro() {
        document.getElementById('modal-registro').classList.remove('active');
        document.getElementById('alert-register').innerHTML = '';
    }

    async function registrarse() {
        const data = {
            nombre:   document.getElementById('reg-nombre').value,
            correo:   document.getElementById('reg-correo').value,
            password: document.getElementById('reg-password').value
        };

        const response = await fetch('index.php?page=register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        const alerta = document.getElementById('alert-register');

        if (result.status) {
            alerta.innerHTML = '<div class="success">✅ ' + result.message + ' Ya puedes iniciar sesión.</div>';
            setTimeout(() => cerrarRegistro(), 2000);
        } else {
            alerta.innerHTML = '<div class="error">❌ ' + result.message + '</div>';
        }
    }
    </script>
</body>
</html>