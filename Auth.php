<?php

require_once 'database.php';

class Auth {
    private PDO $conn;
    private string $table = 'login';

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    // Verificar se o usuário está logado
    public function checkLogin(): bool {
        return isset($_SESSION[SESSION_NAME]);
    }


    public function register(string $name, string $email, string $password, string $confirmPassword): bool {
        // Verificar se o e-mail já está registrado
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $emailExists = $stmt->fetchColumn() > 0;
    
        // Se o e-mail já estiver registrado, redirecionar para a página de registro com mensagem de erro
        if ($emailExists) {
            header('Location: register.php?error=email_existente');
            exit();
        }
        
        if ($password != $confirmPassword) {
            header('Location: register.php?error=password_diferentes');
            exit();
        }

        // Se o e-mail não existir, proceder com o registro
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Criptografando a senha
        $sql = "INSERT INTO {$this->table} (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }
    
    /*
    // Registrar um novo usuário (senha criptografada)
    public function register(string $name, string $email, string $password): bool {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO {$this->table} (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }
    */

    // Fazer login de um usuário
    public function login(string $email, string $password): bool {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION[SESSION_NAME] = $user['id'];
            return true;
        }

        return false;
    }

    // Logout (destruir sessão)
    public function logout(): void {
        session_unset();
        session_destroy();
    }

    // Obter informações do usuário logado
    public function getUserInfo(): ?array {
        if ($this->checkLogin()) {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $_SESSION[SESSION_NAME]]);
            return $stmt->fetch();
        }
        return null;
    }
}
