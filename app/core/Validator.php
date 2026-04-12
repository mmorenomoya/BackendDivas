<?php

class Validator {
    private array $errors = [];

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function reset(): void
    {
        $this->errors = [];    
    }

    // ---- REGLAS DE VALIDACIÓN ----
    public function required(string $value, string $field): self
    {
        if (empty($value)) {
            $this->errors[] = "El campo {$field} es obligatorio.";
        }

        return $this;
    }
    
    public function email(string $value): self
    {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "El formato del email no es válido.";
        }

        return $this;
    }

    public function maxLength(string $value, int $max, string $field): self
    {
        if (!empty($value) && strlen($value) > $max) {
            $this->errors[] = "El campo {$field} debe tener un máximo de {$max} caracteres.";
        }

        return $this;
    }

    public function minLength(string $value, int $min, string $field): self
    {
        if (!empty($value) && strlen($value) < $min) {
            $this->errors[] = "El campo {$field} debe tener un mínimo de {$min} caracteres.";
        }

        return $this;
    }

    public function matches(string $value, string $confirm, string $field): self
    {
        if ($value !== $confirm) {
            $this->errors[] = "El campo {$field} no coincide.";
        }

        return $this;
    }

    public function unique(bool $exists, string $field): self
    {
        if ($exists) {
            $this->errors[] = "El {$field} ya está registrado.";
        }

        return $this;
    }
}