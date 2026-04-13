<?php
    require_once __DIR__ . '/../../core/Auth.php';
    require_once __DIR__ . '/../../core/Helpers.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ReparaYa</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css">
</head>
<body>
    <header class="site-header">
        <div class="site-header__inner">
            <div class="site-header__brand">
                <a href="<?= BASE_URL ?>/" class="site-header__logo">ReparaYa</a>
                <span class="site-header__tagline">Gestión de reparaciones domésticas</span>
            </div>

            <nav class="site-header__nav">
                <?php if(Auth::isLoggedIn()): ?>
                    <?php if(Auth::hasRole(Role::Admin)): ?>
                        <a href="<?= BASE_URL ?>/admin">Panel de adminsitrador</a>
                    <?php elseif(Auth::hasRole(Role::Technician)): ?>
                        <a href="<?= BASE_URL ?>/technician">Mi agenda</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/client">Mis avisos</a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/profile">Mi perfil</a>
                    <a href="<?= BASE_URL ?>/logout" class="btn-primary">Cerrar sesión</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/">Inicio</a>
                    <a href="<?= BASE_URL ?>/services">Servicios</a>
                    <a href="<?= BASE_URL ?>/login" class="btn-primary">Login</a>
                <?php endif; ?>
            </nav>
        </div>
        <script src="<?= BASE_URL ?>/assets/js/header.js"></script>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/footer.css">
    </header>