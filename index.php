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
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="CRUD" />
        <meta name="author" content="Pedro Silva" />
        <title>CRUD</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
        <script>
            var table = new DataTable('datatablesSimple') {
                language: {
                    url: '/pt-BR.json',
                },
            });
        </script>

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
                    confirmButtonColor: '#FF000045'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Se o usuário confirmar, redireciona para o link de exclusão
                        window.location.href = event.target.href;
                    }
                });
            }
        </script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">CRUD</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Inicio</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Listar Usuarios
                            </a>
                            <a class="nav-link" href="create.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Criar Usuario
                            </a>
                            
                    </div>
                    <div class="sb-sidenav-footer">
                        <!-- Navbar-->
                        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    <div class="small">Logado como:</div>
<?php
    $userInfo = $auth->getUserInfo();
    echo $userInfo['name'] . "<br>";
?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Lista de Usuarios
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Ação</th>
                                            
                                        </tr>
                                    </tfoot>
                                    <tbody>

<?php
// Definindo o número de itens por página
$itemsPerPage = 1000; // Número de usuários por página

// Verificando a página atual (se não estiver definida, será 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    // Se a página for menor que 1, redireciona para a página inicial
    echo "<script type='text/javascript'>
          window.location.href = 'index.php';
          </script>";
    exit();
}

$offset = ($page - 1) * $itemsPerPage; // Definindo o deslocamento

require_once 'User.php';

$user = new User();
// Pegar os usuários com limite e offset para a paginação
$users = $user->getUsersWithPagination($itemsPerPage, $offset);


// Calcular o número total de usuários
$totalUsers = $user->getTotalUsers();
$totalPages = ceil($totalUsers / $itemsPerPage); // Calcular o total de páginas


// Verificar se a página solicitada está dentro do intervalo de páginas válidas
if ($page > $totalPages) {
    // Se a página solicitada não existir, redireciona para index.php
    echo "<script type='text/javascript'>
          window.location.href = 'index.php';
          </script>";
    exit();

}


foreach ($users as $u) {
    echo "<tr><td>";
    echo "<p>{$u['id']} </td> <td> {$u['name']}</td> <td> {$u['email']} </td>";
    echo "<td><a class='btn btn-primary' href='edit.php?id={$u['id']}'>Editar</a>   <a class='btn btn-danger' href='delete.php?id={$u['id']}' onclick='return confirmDelete(event)'>Deletar</a></td>";
}
?>

                                            
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Pedro Silva 2025</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
