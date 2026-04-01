<?php

require_once __DIR__ . '/Database.php';

class Model 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll(string $table): array
    {
        $this->db->query("SELECT * FROM {$table}");
        $this->db->execute();
        return $this->db->results();
    }

    public function getById(string $table, int $id): array | false
    {
        $this->db->query("SELECT * FROM {$table} WHERE id=:id");
        $this->db->bind(':id', $id);
        return $this->db->result();
    }

    public function delete(string $table, int $id): void
    {
        $this->db->query("DELETE FROM {$table} WHERE id=:id");
        $this->db->bind(':id', $id);
        $this->db->execute();
    }
}