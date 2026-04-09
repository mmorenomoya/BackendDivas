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
        if (Auth::isLoggedIn()) {
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

        $exists = $this->userModel->getUserByEmail($email);
        
        $validator = new Validator();
        $validator->required($name, 'nombre')
                        ->required($email, 'email')
                        ->email($email)
                        ->unique($exists !== false, 'email')
                        ->required($password, 'contraseña')
                        ->minLength($password, 8, 'contraseña')
                        ->matches($password, $confirm, 'contraseña');
        
        if ($validator->fails()) {
            $errors = $validator->getErrors();
            require_once __DIR__ . '/../views/auth/register.php';
            return;
        }

        $result = $this->userModel->addUser($name, $email, $password, Role::Client, $phone);

        if (!$result) {
            $errors = ['El email ya está registrado'];
            require_once __DIR__ . '/../views/auth/register.php';
            return;
        }


        $_SESSION['success'] = 'Cuenta creada correctamente. Ya puedes iniciar sesión.';
        header('Location: ' . BASE_URL . '/login');
        exit;    
    }

    // GET /admin/register
    // TODO: 1) terminar el flujo de registro y login del rol admin. 2) añadir rol para el registro de tecnicos (pending_technician)
    public function registerAdminForm(): void
    {
        if(!Auth::isLoggedIn() || Auth::getRole() !== Role::Admin->value) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        require_once __DIR__ . '/../views/admin/register.php';
    }

    // POST /admin/register
    public function registerAdmin(): void
    {
        if (!Auth::isLoggedIn() || Auth::getRole() !== Role::Admin->value) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $name = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');

        $exists = $this->userModel->getUserByEmail($email);
        
        $validator = new Validator();
        $validator->required($name, 'nombre')
                ->required($email, 'email')
                ->email($email)
                ->unique($exists !== false, 'email')
                ->required($password, 'contraseña')
                ->minLength($password, 8, 'contraseña')
                ->matches($password, $confirm, 'contraseña');

        if ($validator->fails()) {
            $errors = $validator->getErrors();
            require_once __DIR__ . '/../views/auth/register.php';
            return;
        }

         $result = $this->userModel->addUser($name, $email, $password, Role::Admin, $phone);

        if (!$result) {
            $errors = ['El email ya está registrado'];
            require_once __DIR__ . '/../views/admin/register.php';
            return;
        }


        $_SESSION['success'] = 'Administrador creado correctamente.';
        header('Location: ' . BASE_URL . '/admin');
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