<?php

require_once 'Auth.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $auth = new Auth();

    if ($auth->login($email, $password)) {
        header('Location: index.php');
        exit();
    } else {
        $error = "Credenciais inválidas!";
    }
}

?>




<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<style>

</style>

</head>
<body>


<!-- Login 2 - Bootstrap Brain Component -->
<div class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
        <div class="bg-white p-4 p-md-5 rounded shadow-sm">
          <div class="row">
            <div class="col-12">
              <div class="mb-5">
                <h3>Log in</h3>
              </div>
              <div>
              <?php if (isset($error)) echo "<span class='text-danger'><p>{$error}</p></span>"; ?>
            </div>
            </div>
          </div>
          <form method="post" action="login.php">
            <div class="row gy-3 gy-md-4 overflow-hidden">
              <div class="col-12">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
              </div>
              <div class="col-12">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password" id="password" value="" required>
              </div>
              <div class="col-12">
              </div>
              <div class="col-12">
                <div class="d-grid">
                  <button class="btn btn-lg btn-primary" type="submit">Entrar</button>
                </div>
              </div>
            </div>
          </form>
          <div class="row">
            <div class="col-12">
              <hr class="mt-5 mb-4 border-secondary-subtle">
              <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                <a href="register.php" class="link-secondary text-decoration-none">Criar uma nova conta.</a>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




</body>
</html>







