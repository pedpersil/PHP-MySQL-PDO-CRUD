# PHP-MySQL-PDO-CRUD
Um CRUD feito com PHP, MySQL, PDO que tem sistema de login, sistema de paginação, sistema de busca.

1 - Para instalar você precisa configurar os atributos no arquivo config.php

define('DB_HOST', 'mysql');
define('DB_NAME', 'crud_pdo');
define('DB_USER', 'root'); // Substitua pelo seu usuário
define('DB_PASS', 'rootpassword'); // Substitua pela sua senha
define('SESSION_NAME', 'user_session'); // Nome da sessão

2 - Precisa criar o banco de dados e tabelas usando esses comandos usando o PHPMyAdmin

CREATE DATABASE IF NOT EXISTS crud_pdo;
USE crud_pdo;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE users ADD FULLTEXT(name, email);

CREATE DATABASE IF NOT EXISTS crud_pdo;
USE crud_pdo;

CREATE TABLE IF NOT EXISTS login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

3 - Fazer o upload dos arquivos para o seu servidor.
