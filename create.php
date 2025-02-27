<?php

require_once 'User.php';

require_once 'Auth.php';

session_start();

$auth = new Auth();
if (!$auth->checkLogin()) {
    header('Location: login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $user = new User();
    if ($user->create($name, $email)) {
        header('Location: index.php');
    } else {
        echo "Erro ao criar usuário.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>
      .img-container {
        text-align: center;
      }
</style>
</head>
<body>
<div class="img-container">
<img src="crud.jpg" alt="CRUD">
</div>
<?php
$userInfo = $auth->getUserInfo();
echo "Bem-vindo, " . $userInfo['name'] . "! <br>";
?>
<a href="index.php">Listar</a> | 
<a href="logout.php">Sair</a>
<form method="POST">
<div class="mb-3">
  <label for="name" class="form-label">Nome:</label>
  <input type="text" class="form-control" name="name" id="name" placeholder="Digite o nome:" required/>
</div>
<div class="mb-3">
    
  <label for="email" class="form-label">Email:<?php if (isset($_GET['error'])) echo "<p>{$_GET['error']}</p>"; ?></label>
  <input type="email" class="form-control" name="email" id="email" placeholder="nome@exemplo.com" required/>
</div>
<button class="btn btn-primary" type="submit">Criar</button>
</form>

</body>
</html>