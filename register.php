<?php

require_once 'Auth.php';

session_start();


$errorMessage = '';
// Verificar se há um erro na URL (email já existe)
if (isset($_GET['error']) && $_GET['error'] === 'email_existente') {
    $errorMessage = 'Este e-mail já está registrado. Tente outro e-mail.';
} elseif (isset($_GET['error']) && $_GET['error'] === 'password_diferentes') {
    $errorMessage = 'As senhas são diferentes.';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['firstName'] . " " . $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $auth = new Auth();

    if ($auth->register($name, $email, $password, $confirmPassword)) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Erro ao registrar usuário.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - CRUD</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                      <h3 class="text-center font-weight-light my-4">Criar conta</h3><br>
                                      <?php if (isset($error)) echo "<span class='text-danger'><p>{$error}</p></span>"; ?>
                                      <?php if ($errorMessage) { echo "<span class='text-danger'><p>$errorMessage</p></span>"; } ?>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="register.php">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="firstName" id="firstName" type="text" placeholder="Entre com o seu primeiro nome:" required/>
                                                        <label for="firstName">Primeiro Nome</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="lastName" id="lastName" type="text" placeholder="Entre com o seu ultimo nome:" required/>
                                                        <label for="lastName">Ultimo Nome</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="email" id="email" type="email" placeholder="nome@exemplo.com" required/>
                                                <label for="email">Email </label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="password" id="password" type="password" placeholder="Criar Senha" required/>
                                                        <label for="password">Senha</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="confirmPassword" id="confirmPassword" type="password" placeholder="Confirme a Senha" required/>
                                                        <label for="confirmPassword">Confirme a Senha</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button type="submit" class="btn btn-primary">Criar Conta</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Já tem uma conta? Vá para login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; <a href="https://github.com/pedpersil">Pedro Silva</a> 2025</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>