<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Validator.php';

class ProfileController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // GET /profile
    public function index(): void
    {
        Auth::requireLogin();

        $usuario = $this->userModel->getUserById(Auth::getUser()['id']);

        require_once __DIR__ . '/../views/profile/edit.php';
    }

    // POST /profile
    public function update(): void
    {
        Auth::requireLogin();

        $id = Auth::getUser()['id'];
        $name = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['telefono'] ?? '');

        $emailExists = $this->userModel->getUserByEmail($email);
        $emailTaken = $emailExists && $emailExists['id'] !== $id;

        $validator = new Validator();
        $validator->required($name, 'nombre')
                        ->required($email, 'email')
                        ->email($email)
                        ->unique($emailTaken, 'email');

        if ($validator->fails()) {
            $errors = $validator->getErrors();
            $usuario = $this->userModel->getUserById($id);
            require_once __DIR__ . '/../views/profile/edit.php';
            return;
        }

        $this->userModel->updateUser($id, $name, $email, $phone);

        $_SESSION['usuario']['nombre'] = $name;
        $_SESSION['usuario']['email'] = $email;
        $_SESSION['usuario']['telefono'] = $phone;

        $_SESSION['success'] = 'Perfil actualizado correctamente.';
        header('Location: ' . BASE_URL . '/profile');
        exit;
    }

    public function updatePassword(): void
    {
        Auth::requireLogin();

        $id = Auth::getUser()['id'];
        $actual = trim($_POST['password_actual'] ?? '');
        $nueva = trim($_POST['password_nueva'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');

        $validator = new Validator();
        $validator->required($actual, 'contraseña actual')
                ->required($nueva, 'contraseña nueva')
                ->minLength($nueva, 8, 'contraseña nueva')
                ->matches($nueva, $confirm, 'contraseña nueva');

        if ($validator->fails()) {
            $passwordErrors = $validator->getErrors();
            $usuario = $this->userModel->getUserById($id);
            require_once __DIR__ . '/../views/profile/edit.php';
            return;
        }

        $usuarioActual = $this->userModel->getUserById($id);
        if (!password_verify($actual, $usuarioActual['password'])) {
            $passwordErrors = ['La contraseña actual no es correcta.'];
            $usuario = $usuarioActual;
            require_once __DIR__ . '/../views/profile/edit.php';
            return;
        }

        $this->userModel->updatePassword($id, $nueva);

        $_SESSION['success'] = 'Contraseña actualizada correctamente.';
        header('Location: ' . BASE_URL . '/profile');
        exit;
    }
}