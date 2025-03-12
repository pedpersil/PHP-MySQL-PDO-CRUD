# PHP-MySQL-PDO-CRUD
## Um CRUD feito com PHP, MySQL, PDO que tem sistema de login, sistema de paginação, sistema de busca.

# Demo on-line <a href="http://areadeteste.42web.io/crud/">Click Aqui</a>

# Telas

Página de Login
<img src="http://areadeteste.42web.io/crud/crud-img/login.jpg" alt="Página de Login"><br><br>
Página de registro
<img src="http://areadeteste.42web.io/crud/crud-img/register.jpg" alt="Página de registro"><br><br>
Lista todos os registros
<img src="http://areadeteste.42web.io/crud/crud-img/listar.jpg" alt="Lista todos os registros"><br><br>
Cria novo registro
<img src="http://areadeteste.42web.io/crud/crud-img/create.jpg" alt="Criar novo registro"><br><br>
Editar registro
<img src="http://areadeteste.42web.io/crud/crud-img/editar.jpg" alt="Editar registro"><br><br>

# Requisitos
Servidor Web como Apache ou o Nginx, O php 8+, Mysql, PHPMyAdmin.

## 1 - Para instalar você precisa configurar os atributos no arquivo config.php

define('DB_HOST', 'mysql');<br/>
define('DB_NAME', 'crud_pdo');<br/>
define('DB_USER', 'root'); // Substitua pelo seu usuário<br/>
define('DB_PASS', 'rootpassword'); // Substitua pela sua senha<br/>
define('SESSION_NAME', 'user_session'); // Nome da sessão<br/>

## 2 - Precisa criar o banco de dados e tabelas usando esses comandos usando o PHPMyAdmin

CREATE TABLE IF NOT EXISTS users (<br/>
    id INT AUTO_INCREMENT PRIMARY KEY,<br/>
    name VARCHAR(255) NOT NULL,<br/>
    email VARCHAR(255) NOT NULL UNIQUE,<br/>
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP<br/>
);<br/>

ALTER TABLE users ADD FULLTEXT(name, email);<br/>

CREATE TABLE IF NOT EXISTS login (<br/>
    id INT AUTO_INCREMENT PRIMARY KEY,<br/>
    name VARCHAR(255) NOT NULL,<br/>
    email VARCHAR(255) NOT NULL UNIQUE,<br/>
    password VARCHAR(255) NOT NULL,<br/>
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP<br/>
);<br/>

## 3 - Fazer o upload dos arquivos para o seu servidor.


