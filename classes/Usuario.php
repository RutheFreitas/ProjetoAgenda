<?php
require_once 'Database.php';

class Usuario extends Database {
    public function criarTabela() {
        $sql = "CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            senha VARCHAR(255) NOT NULL,
            nivel ENUM('admin', 'usuario') NOT NULL,
            createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $this->query($sql);
        $this->execute();
    }

    public function inicializarUsuarios() {
        $sql = "SELECT COUNT(*) AS count FROM usuarios";
        $this->query($sql);
        $count = $this->single()->count;
        if ($count == 0) {
            $sql = "INSERT INTO usuarios (usuario, email, senha, nivel) VALUES
                    ('Ruthe', 'ruthe@gmail.com', :senha1, 'admin'),
                    ('Freitas', 'freitas@gmail.com', :senha2, 'usuario')";
            $this->query($sql);
            $this->bind(':senha1', password_hash('1234', PASSWORD_DEFAULT));
            $this->bind(':senha2', password_hash('5678', PASSWORD_DEFAULT));
            $this->execute();
        }
    }

    public function autenticar($email, $senha) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $this->query($sql);
        $this->bind(':email', $email);
        $usuario = $this->single();
        if ($usuario && password_verify($senha, $usuario->senha)) {
            return $usuario;
        } else {
            return false;
        }
    }

    // Método para listar todos os usuários
    public function listarUsuarios() {
        $sql = "SELECT * FROM usuarios";
        $this->query($sql);
        return $this->resultSet();
    }

    // Método para criar um novo usuário
    public function criarUsuario($usuario, $email, $senha, $nivel) {
        $sql = "INSERT INTO usuarios (usuario, email, senha, nivel) 
                VALUES (:usuario, :email, :senha, :nivel)";
        $this->query($sql);
        $this->bind(':usuario', $usuario);
        $this->bind(':email', $email);
        $this->bind(':senha', password_hash($senha, PASSWORD_DEFAULT));
        $this->bind(':nivel', $nivel);
        return $this->execute();
    }
    // Método para editar um usuário
    public function editarUsuario($id, $usuario, $email, $senha, $nivel) {
        if (!empty($senha)) {
            $sql = "UPDATE usuarios SET usuario = :usuario, email = :email, senha = :senha, nivel = :nivel WHERE id = :id";
            $this->query($sql);
            $this->bind(':senha', password_hash($senha, PASSWORD_DEFAULT));
        } else {
            $sql = "UPDATE usuarios SET usuario = :usuario, email = :email, nivel = :nivel WHERE id = :id";
            $this->query($sql);
        }
        $this->bind(':id', $id);
        $this->bind(':usuario', $usuario);
        $this->bind(':email', $email);
        $this->bind(':nivel', $nivel);
        $this->execute();
    }
        
    // Método para deletar um usuário
    public function deletarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $this->query($sql);
        $this->bind(':id', $id);
        return $this->execute();
    }
}
