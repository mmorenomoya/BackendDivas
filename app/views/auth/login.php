<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciar sesión - ReparaYA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/auth.css">
</head>
<body>

    <?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div class="auth-wrapper">
        <div class="auth-header">
            <span class="auth-logo">ReparaYA</span>
            <h1>Iniciar sesión</h1>
            <p>Accede a tu cuenta para gestionar tus avisos.</p>
        </div>

        <div class="auth-card">

            <?php  if(!empty($errors)): ?>
                <ul class="alert-error">
                    <?php foreach($errors as $error):  ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form action="<?=  BASE_URL ?>/login" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           placeholder="tu@email.com">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password"
                           placeholder="••••••••">
                </div>

                <button type="submit" class="btn-primary">Entrar</button>
            </form>
        </div>

        <p class="auth-footer">
            ¿No tienes cuenta? <a href="<?= BASE_URL ?>/register">Regístrate</a>
        </p>
    </div>

    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

    <script src="<?= BASE_URL ?>/assets/js/login.js"></script>
</body>
</html>