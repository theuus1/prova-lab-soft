<?php



// Verifica se há um parâmetro 'logout' na URL
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    echo "<script>alert('Você saiu da plataforma com sucesso.');</script>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
<div class="box-login">

<h1 class="title_login"><i class="icon icon-key-1"></i> Bem vindo!! </h1>

<form action="logar.php" method="post" class="form login">

    <div class="form_field">
        <label for="login_username">
            <i class="icon icon-user-1"></i>
            <span class="hidden">E-mail</span>
        </label>
        <input autocomplete="off" id="login_username" type="text" name="email" class="form_input" placeholder="E-mail" required>
    </div>

    <div class="form_field">
        <label for="login_password">
            <i class="icon icon-lock"></i>
            <span class="hidden">Senha</span>
        </label>
        <input id="login_password" type="password" name="password" class="form_input" placeholder="Senha" required>
    </div>

    <div class="form_field">
        <input type="submit" value="Entrar">
    </div>

</form>

</div>
</body>
</html>
