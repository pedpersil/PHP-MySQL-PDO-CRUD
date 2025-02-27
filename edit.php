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
</head>
<body>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $user = new User();

    /*
    if ($user->update($id, $name, $email)) {
        header('Location: index.php');
    } else {
        echo "Erro ao atualizar usuário.";
    }
    */

    // Se o usuário existe, chamar o método delete para excluí-lo
    if ($user->update($id, $name, $email)) {
        // Exclusão bem-sucedida, redireciona com uma mensagem de sucesso via SweetAlert2
        echo "<script>
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Usuário atualizado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745'
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
                    text: 'Não foi possível atualizar o usuário. Tente novamente.',
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

$id = $_GET['id'];
$user = new User();
$u = $user->getById($id);
?>


<div class="img-container">
<img src="crud.jpg" alt="CRUD">
</div>
<a href="index.php">Listar</a>

<form method="POST">
<input type="hidden" name="id" value="<?php echo $u['id']; ?>">
<div class="mb-3">
  <label for="name" class="form-label">Nome</label>
  <input type="text" class="form-control" name="name" id="name" value="<?php echo $u['name']; ?>" required>
</div>
<div class="mb-3">
  <label for="email" class="form-label">Email:</label>
  <input type="email" class="form-control" name="email" id="email" value="<?php echo $u['email']; ?>" required>
</div>
<button class="btn btn-primary" type="submit">Salvar</button>
</form>


</body>
</html>