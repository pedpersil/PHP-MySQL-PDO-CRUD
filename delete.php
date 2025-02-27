<?php

require_once 'User.php';

require_once 'Auth.php';

session_start();

$auth = new Auth();
if (!$auth->checkLogin()) {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$user = new User();
if ($user->delete($id)) {
    header('Location: index.php');
} else {
    echo "Erro ao deletar usuário.";
}
?>
