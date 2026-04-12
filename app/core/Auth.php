<?php

require_once __DIR__ . '/Helpers.php';

class Auth
{
    // Guardar usuario en la sesión después del login
    public static function login(array $usuario): void
    {
        $_SESSION['usuario'] = $usuario;
    }

    // Cerrar sesión
    public static function logout(): void
    {
        session_destroy();
    }

    // Comprobar si hay alguien logueado
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['usuario']);
    }

    // Obtener el usuario de la sesión
    public static function getUser(): ?array 
    {
        return $_SESSION['usuario'] ?? null;
    }

    // Obtener el rol del usuario actual
    public static function getRole(): ?string
    {
        return $_SESSION['usuario']['rol'] ?? null;
    }

    // Comprobar si el usuario tiene un rol concreto
    public static function hasRole(Role $role): bool
    {
        return self::getRole() === $role->value;
    }

    // Redirigir si no está logueado
    public static function requireLogin(): void
    {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    // Redirigir si no tiene el rol adecuado
    public static function requireRole(Role $role): void
    {
        self::requireLogin();

        if (!self::hasRole($role)) {
            header('Location: ' . BASE_URL . '/403');
            exit;
        }
    }
}