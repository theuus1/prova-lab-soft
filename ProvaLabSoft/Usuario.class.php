<?php
class Usuario {
    public function login($login, $senha) {
        global $pdo;

        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":email", $login);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $dado = $stmt->fetch();
            $senhaArmazenada = $dado['senha'];

            // Verifica se a senha fornecida corresponde ao hash armazenado
            if (password_verify($senha, $senhaArmazenada)) {
                $_SESSION['idUser'] = $dado['id'];
                $_SESSION['userNivel'] = $dado['nivel'];
                return true;
            }
        }

        return false;
    }
}
?>
