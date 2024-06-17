<?php
session_start();

$url = "localhost";
$usuario = "root";
$senha = "root";
$dbname = "provalabsoft";

try {
    $pdo = new PDO("mysql:dbname=".$dbname.";host=".$url, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: ".$e->getMessage();
    exit;
}
?>
