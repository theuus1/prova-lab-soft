<?php
session_start();

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Se necessário, também destrua a sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finaliza a sessão
session_destroy();

// Redireciona para a página de login com mensagem de sucesso
header("Location: index.php?logout=1");
exit();
?>
