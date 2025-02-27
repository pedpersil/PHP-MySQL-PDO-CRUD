<?php

require_once 'Auth.php';

session_start();


$errorMessage = '';
// Verificar se há um erro na URL (email já existe)
if (isset($_GET['error']) && $_GET['error'] === 'email_existente') {
    $errorMessage = 'Este e-mail já está registrado. Tente outro e-mail.';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['firstName'] . " " . $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $auth = new Auth();

    if ($auth->register($name, $email, $password)) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Erro ao registrar usuário.";
    }
}

?>


<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<style>

</style>

</head>
<body>



<!-- Registration 13 - Bootstrap Brain Component -->
<section class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="text-center mb-3">
              <h1>Registrar-se</h1>
            </div>
            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Entre com os seus dados para registrar.</h2>
            <form method="post" action="register.php">
              <div class="row gy-2 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="firstName" id="firstName" placeholder="First Name" required>
                    <label for="firstName" class="form-label">Primeiro Nome</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Last Name" required>
                    <label for="lastName" class="form-label">Ultimo Nome</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                    <?php if ($errorMessage): ?>
                    <p style="color: red;"><?php echo $errorMessage; ?></p>  
                  <?php endif; ?>
                    <label for="email" class="form-label">Email</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                    <label for="password" class="form-label">Senha</label>
                  </div>
                </div>
                <div class="col-12">
                </div>
                <div class="col-12">
                  <div class="d-grid my-3">
                    <button class="btn btn-primary btn-lg" type="submit">Registrar</button>
                  </div>
                </div>
                <div class="col-12">
                  <p class="m-0 text-secondary text-center">Já tem uma conta? <a href="login.php" class="link-primary text-decoration-none">Entrar</a></p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>

<?php if (isset($error)) echo "<p>{$error}</p>"; ?>
