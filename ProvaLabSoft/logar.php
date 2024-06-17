<?php
session_start();
require 'config.php';
require 'Usuario.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
    $login = $_POST['email'];
    $senha = $_POST['password'];

    $usuario = new Usuario();
    if ($usuario->login($login, $senha)) {
        if (isset($_SESSION['idUser'], $_SESSION['userNivel'])) {
            if ($_SESSION['userNivel'] == 1) {
                header('Location: dashadm.php');
                exit();
            } else if ($_SESSION['userNivel'] == 2) {
                header('Location: dashcliente.php');
                exit();
            }
        } else {
            header('Location: index.php');
            exit();
        }
    } else {
        echo "<script>alert('Login ou senha incorretos!'); window.location.href='index.php';</script>";
    }
} else {
    header('Location: login.php');
    exit();
}
?>
