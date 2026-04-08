<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Validator.php';

class ProfileController
{
    private User $userModel;
    private Validator $validator;

    public function __construct()
    {
        $this->userModel = new User();
        $this->validator = new Validator();
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

        $this->validator->required($name, 'nombre')
                        ->required($email, 'email')
                        ->email($email)
                        ->unique($emailTaken, 'email');

        if ($this->validator->fails()) {
            $passwordErrors = $this->validator->getErrors();
            $usuario = $this->userModel->getUserById($id);
            require_once __DIR__ . '/../views/profile/edit.php';
            return;
        }

        $this->userModel->updateUser($id, $name, $email, $phone);

        $_SESSION['usuario']['nombre'] = $name;
        $_SESSION['usuario']['email'] = $email;
        $_SESSION['usuario']['telefono'] = $telefono;

        $_SESSION['success'] = 'Perfil actualizado correctamente.';
        header('Location: ' . BASE_URL . '/profile');
        exit;
    }
}