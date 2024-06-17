<?php 
session_start();

$url = "localhost";
$usuario = "root";
$senha = "root";
$dbname = "provalabsoft";

// Variável global para a conexão PDO
$pdo = null;

try {
    $pdo = new PDO("mysql:dbname=".$dbname.";host=".$url, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<script>alert('ERRO: ".$e->getMessage()."');</script>";
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar se a conexão com o banco de dados foi estabelecida
    if ($pdo !== null) {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // Verifica se todos os campos foram preenchidos
        if ($nome && $email && $password) {
            // Hash da senha para segurança
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $nivel = 2;  // Define o nível do usuário como 2

            // Insere os dados no banco de dados
            $sql = "INSERT INTO usuarios (nome, email, senha, nivel) VALUES (:nome, :email, :senha, :nivel)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $passwordHash);
            $stmt->bindParam(':nivel', $nivel);

            if ($stmt->execute()) {
                echo '<script>alert("colaborador cadastrado com sucesso!"); window.location.href = "dashadm.php";</script>';
            } else {
                $message = "Erro ao cadastrar. Tente novamente.";
            }
        } else {
            $message = "Preencha todos os campos!";
        }
    } else {
        $message = "Erro na conexão com o banco de dados!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylecadras.css">
    <title>Cadastro</title>
    <script>
        function showMessage(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body onload="showMessage('<?php echo $message; ?>')">
<div class="box-login">
    <h1 class="title_login"><i class="icon icon-key-1"></i> Crie seu colaborador! </h1>
    <form action="#" method="post" class="form cadastro">
        <div class="form_field">
            <label for="cadastro_nome">
                <i class="icon icon-user-1"></i>
                <span class="hidden">Nome</span>
            </label>
            <input autocomplete="off" id="cadastro_nome" type="text" name="nome" class="form_input" placeholder="Nome" required>
        </div>
        <div class="form_field">
            <label for="cadastro_email">
                <i class="icon icon-envelope"></i>
                <span class="hidden">E-mail</span>
            </label>
            <input autocomplete="off" id="cadastro_email" type="email" name="email" class="form_input" placeholder="E-mail" required>
        </div>
        <div class="form_field">
            <label for="cadastro_password">
                <i class="icon icon-lock"></i>
                <span class="hidden">Senha</span>
            </label>
            <input id="cadastro_password" type="password" name="password" class="form_input" placeholder="Senha" required>
        </div>
        <div class="form_field">
            <input type="submit" value="Cadastrar">
        </div>
    </form>
</div>
</body>
</html>
