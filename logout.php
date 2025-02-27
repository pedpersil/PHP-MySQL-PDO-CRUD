<?php

require_once 'Auth.php';

session_start();

$auth = new Auth();
$auth->logout();

header('Location: login.php');
exit();
?>
