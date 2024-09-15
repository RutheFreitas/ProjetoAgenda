<?php
require_once 'Database.php';

class Contato extends Database {
    public function criarTabela() {
        $sql = "CREATE TABLE IF NOT EXISTS contatos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            idade INT NOT NULL,
            email VARCHAR(100) NOT NULL,
            telefone varchar(20) not null,
            createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $this->query($sql);
        $this->execute();
    }
    public function inicializarContatos() {
        $sql = "SELECT COUNT(*) AS count FROM contatos";
        $this->query($sql);
        $count = $this->single()->count;
        if ($count == 0) {
            $sql = "INSERT INTO contatos (nome, idade, email, telefone) VALUES
                    ('Ruthe', 41, 'ruthe@hotmail.com', '85981234567'),
                    ('Freitas', 50, 'freitas@hotmail.com', '85999998877')";
            $this->query($sql);
            $this->execute();
        }
    }

    public function listarContatos() {
        $sql = "SELECT * FROM contatos";
        $this->query($sql);
        return $this->resultSet();
    }

    public function criarContato($nome, $idade, $email, $telefone) {
        $sql = "INSERT INTO contatos (nome, idade, email, telefone) VALUES (:nome, :idade, :email, :telefone)";
        $this->query($sql);
        $this->bind(':nome', $nome);
        $this->bind(':idade', $idade);
        $this->bind(':email', $email);
        $this->bind(':telefone', $telefone);
        $this->execute();
    }

    public function editarContato($id, $nome, $idade, $email, $telefone) {
        $sql = "UPDATE contatos SET nome = :nome, idade = :idade, email = :email, telefone = :telefone WHERE id = :id";
        $this->query($sql);
        $this->bind(':id', $id);
        $this->bind(':nome', $nome);
        $this->bind(':idade', $idade);
        $this->bind(':email', $email);
        $this->bind(':telefone', $telefone);
        $this->execute();
    }

    public function deletarContato($id) {
        $sql = "DELETE FROM contatos WHERE id = :id";
        $this->query($sql);
        $this->bind(':id', $id);
        $this->execute();
    }
}

