<?php

// Inicio de sesión. Tiene que ir primero siempre.
session_start();

// Cargar la configuración.
require_once __DIR__ . '/../config/Config.php';

// Cargar las clases del core
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Auth.php';
require_once __DIR__ . '/../app/core/Helpers.php';
require_once __DIR__ . '/../app/core/Router.php';

// -------- RUTAS -----------
$router = new Router();

// Auth
$router->get('/', 'AuthController', 'index');
$router->get('/login', 'AuthController', 'loginForm');
$router->post('/login', 'AuthController', 'login');
$router->get('/register', 'AuthController', 'registerForm');
$router->post('/register', 'AuthController', 'register');
$router->get('/logout', 'AuthController', 'logout');
$router->get('/admin/register', 'AuthController', 'registerAdminForm');
$router->post('/admin/register', 'AuthController', 'registerAdmin');
$router->get('/admin/create', 'AdminController', 'createForm');
$router->post('/admin/create', 'AdminController', 'store');
$router->get('/admin/edit', 'AdminController', 'editForm');
$router->post('/admin/edit', 'AdminController', 'update');
$router->get('/admin/calendar', 'AdminController', 'calendar');

// Profile
$router->get('/profile', 'ProfileController', 'index');
$router->post('/profile', 'ProfileController', 'update');
$router->post('/profile/password', 'ProfileController', 'updatePassword');

// Admin
$router->get('/admin', 'AdminController', 'index');
$router->get('/admin/users', 'AdminController', 'users');
$router->get('/admin/cancel', 'AdminController', 'cancel');
$router->get('/admin/assign', 'AdminController', 'assignForm');
$router->post('/admin/assign', 'AdminController', 'assign');

// Client
$router->get('/client', 'ClientController', 'index');

//Technician
$router->get('/technician', 'TechnicianController', 'index');

$router->dispatch();
