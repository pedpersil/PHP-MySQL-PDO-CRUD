<?php

require_once 'database.php';

class User {
    private PDO $conn;
    private string $table = 'users';

    public function __construct() {
        $this->conn = (new Database())->connect();
    }


    public function create(string $name, string $email): bool {
        // Verificar se o e-mail já existe
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $emailExists = $stmt->fetchColumn() > 0;
    
        // Se o e-mail já existir, redirecionar para a página de criação com mensagem de erro
        if ($emailExists) {
            /*
            header('Location: create.php?error=email_existente');
            exit();
            */
            echo "<script>
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'E-mail de usuário existente!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'create.php?error=email_existente';  // Redireciona para a página de listagem
                        }
                    });
                </script>";
                exit();
        }
    
        // Se o e-mail não existir, proceder com a criação do usuário
        $sql = "INSERT INTO {$this->table} (name, email) VALUES (:name, :email)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['name' => $name, 'email' => $email]);
    }
    
    /*
    public function create(string $name, string $email): bool {
        $sql = "INSERT INTO {$this->table} (name, email) VALUES (:name, :email)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['name' => $name, 'email' => $email]);
    }
    */
    public function getAll(): array {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function update(int $id, string $name, string $email): bool {
        // Verificar se o e-mail já existe para outro usuário
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = :email AND id != :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email, 'id' => $id]);
        $emailExists = $stmt->fetchColumn() > 0;
    
        // Se o e-mail já existir para outro usuário, retornar falso
        if ($emailExists) {
            return false;
        }
    
        // Se o e-mail não existir, proceder com a atualização do usuário
        $sql = "UPDATE {$this->table} SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);
    }
    
    /*
    public function update(int $id, string $name, string $email): bool {
        $sql = "UPDATE {$this->table} SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);
    }
    */
    public function delete(int $id): bool {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getUsersWithPagination(int $limit, int $offset): array {
        $sql = "SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalUsers(): int {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchColumn();
    }
    

    public function search(string $query): array {
        // Primeiro, vamos verificar se o query é um e-mail, e usar LIKE caso seja
        $isEmail = filter_var($query, FILTER_VALIDATE_EMAIL); // Verifica se o query é um e-mail válido
    
        if ($isEmail) {
            // Se for um e-mail, usamos LIKE
            $sql = "SELECT * FROM {$this->table} WHERE email LIKE :query";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['query' => "%$query%"]);
        } else {
            // Caso contrário, usa MATCH para buscar por nome e email com o texto da consulta
            $sql = "
                SELECT * FROM {$this->table}
                WHERE MATCH(name, email) AGAINST (:query IN BOOLEAN MODE)
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['query' => $query]);
        }
        
        return $stmt->fetchAll();
    }
    

    /*
    public function search(string $query): array {
        $sql = "
            SELECT * FROM {$this->table}
            WHERE MATCH(name, email) AGAINST (:query IN BOOLEAN MODE)
        ";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['query' => $query]);
        
        return $stmt->fetchAll();
    }
    */
    
}
