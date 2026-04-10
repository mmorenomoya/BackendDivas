<?php

require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Helpers.php';

/**
 * @property Database db
 */
class User extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllUsers(): array
    {
        return $this->getAll('usuarios');
    }

    public function getUserById(int $id): array | false
    {
        return $this->getById('usuarios', $id);
    }

    public function getUserByEmail(string $email): array | false 
    {
        $this->db->query("SELECT * FROM usuarios WHERE email = :email");
        $this->db->bind(':email', $email);
        $this->db->execute();
        return $this->db->result();
    }

    public function addUser(string $name, string $mail, string $pass, Role $role, string $phone): bool 
    {
        try {
            $this->db->query("INSERT INTO usuarios (nombre, email, password, rol, telefono) VALUES (:name, :mail, :pass, :role, :phone)");
            $this->db->bind(':name', $name);
            $this->db->bind(':mail', $mail);
            $this->db->bind(':pass', password_hash($pass, PASSWORD_BCRYPT));
            $this->db->bind(':role', $role->value);
            $this->db->bind(':phone', $phone);
            return $this->db->execute();
        } catch (PDOException $e) {
            return false;
        }
       
    }

    public function updateUser(int $id, string $name, string $mail, string $phone): bool
    {
        $this->db->query("UPDATE usuarios SET nombre = :name, email = :mail, telefono = :phone WHERE id = :id");
        $this->db->bind(':name', $name);
        $this->db->bind(':mail', $mail);
        $this->db->bind(':phone', $phone);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function updatePassword(int $id, string $pass): bool
    {
        $this->db->query("UPDATE usuarios SET password = :pass WHERE id = :id");
        $this->db->bind(':pass', password_hash($pass, PASSWORD_BCRYPT));
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function deleteUser(int $id): bool
    {
        return $this->delete('usuarios', $id);
    }

    public function getAllClients(): array // Obtiene todos los usuarios con rol de cliente particular
    {
        $this->db->query("SELECT id, nombre FROM usuarios WHERE rol = 'particular' ORDER BY nombre ASC");
        $this->db->execute();
        return $this->db->results();
    }
}

?>