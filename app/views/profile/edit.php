<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi perfil - ReparaYA</title>
</head>
<body>

    <h1>Mi perfil</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <p><?= htmlspecialchars($_SESSION['success']) ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <h2>Datos personales</h2>

    <?php  if(!empty($errors)): ?>
        <ul>
            <?php foreach($errors as $error):  ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/profile" method="POST">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email']) ?? '' ?>"><br><br>
        
        <label for="telefono">Teléfono:</label><br>
        <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($_POST['telefono']) ?? '' ?>"><br><br>

        <button type="submit">Guardar cambios</button>
    </form>

     <h2>Cambiar contraseña</h2>

    <?php  if(!empty($passwordErrors)): ?>
        <ul>
            <?php foreach($passwordErrors as $error):  ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/profile/password" method="POST">
        <label for="password_actual">Contraseña actual:</label><br>
        <input type="password" id="password_actual" name="password_actual"><br><br>

        <label for="password_nueva">Nueva contraseña:</label><br>
        <input type="password" id="password_nueva" name="password_nueva"><br><br>
        
        <label for="confirm_password">Confirmar nueva contraseña:</label><br>
        <input type="password" id="confirm_password" name="confirm_password"><br><br>

        <button type="submit">Cambiar contraseña</button>
    </form>

    <a href="<?= BASE_URL ?>/logout">Cerrar sesión</a>
    
</body>
</html>