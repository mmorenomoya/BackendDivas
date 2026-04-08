<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Helpers.php';
require_once __DIR__ . '/../core/Validator.php';

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }


    // GET
    public function index(): void
    {
        if(Auth::isLoggedIn()) {
            $this->redirectByRole();
        } else {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    // GET /login
    public function loginForm(): void 
    {
        if (Auth::isLoggedIn()) {
            $this->redirectByRole();
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    // POST /login
    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        
        $validator = new Validator();
        $validator->required($email, 'email')
                        ->email($email)
                        ->required($password, 'contraseña');

        if ($validator->fails()) {
            $errors = $validator->getErrors();
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }       

        $usuario = $this->userModel->getUserByEmail($email);

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            $errors = ['Email o contraseña incorrectos.'];
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }

        Auth::login($usuario);
        $this->redirectByRole();
    }

    // GET /logout
    public function logout(): void
    {
        Auth::logout();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    // GET /register
    public function registerForm(): void
    {
        if(Auth::isLoggedIn()) {
            $this->redirectByRole();
        }

        require_once __DIR__ . '/../views/auth/register.php';
    }

    //POST /register
    public function register(): void
    {
        $name = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');
        $phone = trim($_POST['telefono'] ?? '');
        
        $validator = new Validator();
        $validator->required($name, 'nombre')
                        ->required($email, 'email')
                        ->email($email)
                        ->unique((bool)$this->userModel->getUserByEmail($email), 'email')
                        ->required($password, 'contraseña')
                        ->minLength($password, 8, 'contraseña')
                        ->matches($password, $confirm, 'contraseña');
        
        if ($validator->fails()) {
            $errors = $validator->getErrors();
            require_once __DIR__ . '/../views/auth/register.php';
            return;
        }

        $this->userModel->addUser($name, $email, $password, Role::Client, $phone);

        $_SESSION['success'] = 'Cuenta creada correctamente. Ya puedes iniciar sesión.';
        header('Location: ' . BASE_URL . '/login');
        exit;    
    }

    private function redirectByRole(): void
    {
        $role = Auth::getRole();

        match($role) {
            Role::Admin->value => header('Location: ' . BASE_URL . '/admin'),
            Role::Technician->value => header('Location: ' . BASE_URL . '/technician'),
            Role::Client->value => header ('Location: ' . BASE_URL . '/client'),
            default => header ('Location: ' . BASE_URL . '/login')
        };
        exit;
    }
}