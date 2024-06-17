<?php
// Incluir o arquivo de conexão com o banco de dados
include 'config.php';

// Verifica se o CPF foi passado via GET
if (isset($_GET['cpf'])) {
    $cpf = $_GET['cpf'];

    // Consulta SQL para buscar os detalhes do funcionário com base no CPF
    $sql = "SELECT * FROM funcionarios WHERE cpf = :cpf";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $stmt->execute();
    
    // Verifica se o funcionário foi encontrado
    if ($stmt->rowCount() > 0) {
        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Se não encontrou o funcionário, redireciona de volta para o dashboard ou outra página
        header('Location: dashboard.php');
        exit;
    }
} else {
    // Se o CPF não foi passado, redireciona de volta para o dashboard ou outra página
    header('Location: dashboard.php');
    exit;
}

// Verifica se o formulário foi submetido via POST para edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se todos os campos obrigatórios foram enviados e não estão vazios
    if (!empty($_POST['cpf']) && !empty($_POST['nome']) && !empty($_POST['area']) && !empty($_POST['contato']) && !empty($_POST['idade'])) {
        // Obtém os dados do formulário
        $cpf = $_POST['cpf'];
        $nome = $_POST['nome'];
        $area = $_POST['area'];
        $contato = $_POST['contato'];
        $idade = $_POST['idade'];

        // Prepara a consulta SQL para atualizar os dados do funcionário
        $sql = "UPDATE funcionarios SET nome = :nome, area = :area, contato = :contato, idade = :idade WHERE cpf = :cpf";
        $stmt = $pdo->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':area', $area, PDO::PARAM_STR);
        $stmt->bindParam(':contato', $contato, PDO::PARAM_STR);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);

        // Executa a consulta
        try {
            $stmt->execute();
            echo '<script>alert("Funcionário editado com sucesso!"); window.location.href = "dashadm.php";</script>';
        } catch (PDOException $e) {
            echo '<script>alert("Erro ao editar funcionário: ' . $e->getMessage() . '");</script>';
        }
    } else {
        echo '<script>alert("Todos os campos são obrigatórios!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleadm.css">
    <title>Editar Funcionário</title>
</head>
<body>
    <div class="container">
        <div class="box">
            <h1 class="title">Editar Funcionário</h1>
            <br>
            <form action="#" method="post" class="form employee-form">
                <div class="form-group">
                    <label for="employee_cpf">CPF</label>
                    <input type="text" id="employee_cpf" name="cpf" class="form-control" placeholder="CPF" value="<?php echo $funcionario['cpf']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="employee_name">Nome</label>
                    <input type="text" id="employee_name" name="nome" class="form-control" placeholder="Nome" value="<?php echo $funcionario['nome']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="employee_area">Área</label>
                    <input type="text" id="employee_area" name="area" class="form-control" placeholder="Área" value="<?php echo $funcionario['area']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="employee_contact">Contato</label>
                    <input type="text" id="employee_contact" name="contato" class="form-control" placeholder="Contato" value="<?php echo $funcionario['contato']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="employee_age">Idade</label>
                    <input type="text" id="employee_age" name="idade" class="form-control" placeholder="Idade" value="<?php echo $funcionario['idade']; ?>" required>
                </div>
                <button type="submit" class="btn">Editar</button>
            </form>
        </div>
    </div>
</body>
</html>
