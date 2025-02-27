<?php

require_once 'User.php';

require_once 'Auth.php';

session_start();

$auth = new Auth();
if (!$auth->checkLogin()) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
      .img-container {
        text-align: center;
      }
</style>
</head>
<body>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $user = new User();

    /*
    if ($user->create($name, $email)) {
        header('Location: index.php');
    } else {
        echo "Erro ao criar usuário.";
    }
    */

    if ($user->create($name, $email)) {
        // Exclusão bem-sucedida, redireciona com uma mensagem de sucesso via SweetAlert2
        echo "<script>
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Usuário criado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';  // Redireciona para a página de listagem
                    }
                });
              </script>";
    } else {
        // Caso ocorra algum erro na exclusão, redireciona com uma mensagem de erro
        echo "<script>
                Swal.fire({
                    title: 'Erro!',
                    text: 'Não foi possível criar o usuário. Tente novamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';  // Redireciona para a página de listagem
                    }
                });
              </script>";
    }
    
}
?>

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
    
  <label for="email" class="form-label">Email:<?php if (isset($_GET['error'])) echo "<span class='text-danger'><p>E-mail existente!</p></span>"; ?></label>
  <input type="email" class="form-control" name="email" id="email" placeholder="nome@exemplo.com" required/>
</div>
<button class="btn btn-primary" type="submit">Criar</button>
</form>

</body>
</html>
