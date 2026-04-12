<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - ReparaYA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/auth.css">
</head>
<body>

    <?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div class="auth-wrapper">
        <div class="auth-header">
            <span class="auth-logo">ReparaYA</span>
            <h1>Crear cuenta</h1>
            <p>Reístrate para solicitar servicios técnicos.</p>
        </div>

        <div class="auth-card">
            <?php if(!empty($errors)): ?>
                <ul class="alert-error">
                    <?php foreach($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
            <form action="<?= BASE_URL ?>/register" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre <span class="required">*</span></label>
                        <input type="text" id="nombre" name="nombre" 
                               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                               placeholder="Tu nombre"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono <span class="optional">(opcional)</span></label>
                        <input type="text" id="telefono" name="telefono" 
                               value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>"
                               placeholder="600 000 000">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" 
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           placeholder="tu@email.com"
                           required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Contraseña <span class="required">*</span></label>
                        <input type="password" id="password" name="password"
                               placeholder="••••••••">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar  <span class="required">*</span></label>
                        <input type="password" id="confirm_password" name="confirm_password"
                               placeholder="••••••••">
                    </div>
                </div>   
        
                <button type="submit" class="btn-primary">Registrarse</button>

            </form>
        </div>

        <p class="auth-footer">
            ¿Ya tienes cuenta? <a href="<?= BASE_URL ?>/login">Inicia sesión</a>
        </p>
    </div>

    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

    <script src="<?= BASE_URL ?>/assets/js/register.js"></script>
</body>
</html>