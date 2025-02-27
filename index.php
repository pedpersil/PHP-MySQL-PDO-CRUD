<?php

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
<div class="img-container">
<img src="crud.jpg" alt="CRUD">
</div>

<?php
$userInfo = $auth->getUserInfo();
echo "Bem-vindo, " . $userInfo['name'] . "! <br>";
?>

<a href="create.php">Adicionar</a> | 
<a href='logout.php'>Sair</a>
<br>
<form method="GET" action="search.php">
  <div class="form-group">
    <label for="query">Buscar:</label>
    <input type="text" class="form-control" id="query" name="query" placeholder="Buscar">
  </div>
  <button type="submit" class="btn btn-primary">Buscar</button>
</form>
<br>
<?php


// Definindo o número de itens por página
$itemsPerPage = 50; // Número de usuários por página

// Verificando a página atual (se não estiver definida, será 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage; // Definindo o deslocamento




require_once 'User.php';

$user = new User();
// Pegar os usuários com limite e offset para a paginação
$users = $user->getUsersWithPagination($itemsPerPage, $offset);


// Calcular o número total de usuários
$totalUsers = $user->getTotalUsers();
$totalPages = ceil($totalUsers / $itemsPerPage); // Calcular o total de páginas




echo "<table class='table table-striped'>
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>E-mail</th>
      <th>Ação</th>
    </tr>
  </thead>
  <tbody>";

foreach ($users as $u) {
    echo "<tr><td>";
    echo "<p>{$u['id']} </td> <td> {$u['name']}</td> <td> {$u['email']} </td>";
    echo "<td><a class='btn btn-primary' href='edit.php?id={$u['id']}'>Editar</a>   <a class='btn btn-danger' href='delete.php?id={$u['id']}' onclick='return confirmDelete(event)'>Deletar</a></td>";
}

echo "</tbody></table>";


// Navegação da página
echo "<div>";
if ($page > 1) {
    echo "<a href='index.php?page=" . ($page - 1) . "'>Anterior</a> ";
}

// Links para as páginas numeradas
for ($i = 1; $i <= $totalPages; $i++) {
    // Adicionando uma classe CSS para a página atual
    if ($i == $page) {
        echo "<strong>$i</strong> | "; // Página atual em negrito
    } else {
        echo "<a href='index.php?page=$i'>$i</a> | "; // Link para outras páginas
    }
}

if ($page < $totalPages) {
    echo "<a href='index.php?page=" . ($page + 1) . "'>Próximo</a>";
}
echo "</div>";

?>
</body>
</html>




