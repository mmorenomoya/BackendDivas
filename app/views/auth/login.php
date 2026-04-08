<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Iniciar sesión - ReparaYA</title>
    </head>
    <body>
        <h1>Iniciar sesión</h1>

        <?php  if(!empty($errors)): ?>
            <ul>
                <?php foreach($errors as $error):  ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>
            <p><?= htmlspecialchars($_SESSION['success']) ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form action="<?=  BASE_URL ?>/login" method="POST">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br><br>

            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password"><br><br>

            <button type="submit">Entrar</button>
        </form>

        <p>¿No tienes cuenta? <a href="<?= BASE_URL ?>/register">Regístrate</a></p>

    </body>
</html>