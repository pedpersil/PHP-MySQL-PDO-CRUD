<?php

require_once 'User.php';

require_once 'Auth.php';

session_start();

$auth = new Auth();
if (!$auth->checkLogin()) {
    header('Location: login.php');
    exit();
}

// Verifique se o ID foi passado e se ele é um número válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Se o ID não for válido, redireciona para index.php
    header('Location: index.php');
    exit();
}


$id = $_GET['id'];
$user = new User();

// Verifique se o usuário com esse ID existe no banco de dados
if (!$user->getById($id)) {
    // Se não encontrar o usuário, redireciona para index.php
    header('Location: index.php');
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


<script type="text/javascript">
    function confirmDelete() {
        // Exibe a caixa de confirmação
        var result = confirm("Tem certeza que deseja excluir este usuário?");
        if (result) {
            // Se o usuário confirmar, a ação prossegue
            return true;
        } else {
            // Se o usuário cancelar, a ação é interrompida
            return false;
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function confirmDelete(event) {
        event.preventDefault();  // Previne o redirecionamento imediato

        Swal.fire({
            title: 'Você tem certeza?',
            text: "Essa ação não pode ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                // Se o usuário confirmar, redireciona para o link de exclusão
                window.location.href = event.target.href;
            }
        });
    }
</script>


</head>
<body>

<?php

// Se o usuário existe, chamar o método delete para excluí-lo
if ($user->delete($id)) {
    // Exclusão bem-sucedida, redireciona com uma mensagem de sucesso via SweetAlert2
    echo "<script>
            Swal.fire({
                title: 'Sucesso!',
                text: 'Usuário excluído com sucesso!',
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
                text: 'Não foi possível excluir o usuário. Tente novamente.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';  // Redireciona para a página de listagem
                }
            });
          </script>";
}

/*
if ($user->delete($id)) {
    header('Location: index.php');
} else {
    echo "Erro ao deletar usuário.";
}
*/
?>

</body>
</html>