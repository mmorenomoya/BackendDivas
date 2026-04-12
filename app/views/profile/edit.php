<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi perfil - ReparaYA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/profile.css">
</head>
<body>

    <?php require_once __DIR__ . '/../layouts/header.php'; ?>
    <?php require_once __DIR__ . '/../layouts/menu.php'; ?>

    <div class="profile-wrapper">
        <div class="profile-header">
            <h1>Mi perfil</h1>
            <p>Gestiona tu información personal.</p>
        </div>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="profile-content">
            <div class="profile-card">
                <h2>Datos personales</h2>
    
                <?php  if(!empty($errors)): ?>
                    <ul class="alert-error">
                        <?php foreach($errors as $error):  ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
    
                <form action="<?= BASE_URL ?>/profile" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">Nombre <span class="required">*</span></label>
                            <input type="text" id="nombre" name="nombre" 
                                   value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>"
                                   required>
                        </div>
    
                        <div class="form-group">
                            <label for="telefono">Teléfono <span class="optional">(opcional)</span></label>
                            <input type="text" id="telefono" name="telefono" 
                                   value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>"
                                   placeholder="600 000 000">
                        </div>
                    </div>
    
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" 
                                value="<?= htmlspecialchars($usuario['email'] ?? '') ?>"
                                required>
                    </div>    
    
                    <button type="submit" class="btn-primary">Guardar cambios</button>
            
                </form>
            </div>

            <div class="profile-card">
                <h2>Cambiar contraseña</h2>
    
                <?php  if(!empty($passwordErrors)): ?>
                    <ul>
                        <?php foreach($passwordErrors as $error):  ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
    
                <form action="<?= BASE_URL ?>/profile/password" method="POST">
                    <div class="form-group">
                        <label for="password_actual">Contraseña actual <span class="required">*</span></label>
                        <input type="password" id="password_actual" name="password_actual"
                               placeholder="••••••••" required>
                    </div>
    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password_nueva">Nueva contraseña <span class="required">*</span></label>
                            <input type="password" id="password_nueva" name="password_nueva"
                                   placeholder="••••••••" required>
                        </div>
    
                        <div class="form-group">                        
                            <label for="confirm_password">Confirmar <span class="required">*</span></label>
                            <input type="password" id="confirm_password" name="confirm_password"
                                   placeholder="••••••••" required>
                        </div>
                    </div>
            
                    <button type="submit" class="btn-primary">Cambiar contraseña</button>
                </form>
        </div>


            <div class="profile-footer">
                <a href="<?= BASE_URL ?>/logout">Cerrar sesión</a>
            </div>
        
        </div>
    </div>

    <?php require_once __DIR__ . '/../layouts/footer.php' ?>

<script src="<?= BASE_URL ?>/assets/js/profile.js"></script>
    
</body>
</html>