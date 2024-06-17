<?php
// Incluir o arquivo de conexão com o banco de dados
include 'config.php';

// Verifica se o formulário foi submetido via POST para exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_cpf'])) {
    $cpf = $_POST['delete_cpf'];

    // Prepara a consulta SQL para deletar o funcionário
    $sql = "DELETE FROM funcionarios WHERE cpf = :cpf";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);

    try {
        $stmt->execute();
        echo '<script>alert("Funcionário excluído com sucesso!"); window.location.href = "dashadm.php";</script>';
    } catch (PDOException $e) {
        echo '<script>alert("Erro ao excluir funcionário: ' . $e->getMessage() . '");</script>';
    }
}

// Verifica se o formulário foi submetido via POST para cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se todos os campos obrigatórios foram enviados e não estão vazios
    if (!empty($_POST['cpf']) && !empty($_POST['nome']) && !empty($_POST['area']) && !empty($_POST['contato']) && !empty($_POST['idade'])) {
        // Obtém os dados do formulário
        $cpf = $_POST['cpf'];
        $nome = $_POST['nome'];
        $area = $_POST['area'];
        $contato = $_POST['contato'];
        $idade = $_POST['idade'];

        // Prepara a consulta SQL para inserir um novo funcionário
        $sql = "INSERT INTO funcionarios (cpf, nome, area, contato, idade) VALUES (:cpf, :nome, :area, :contato, :idade)";
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
            echo '<script>alert("Funcionário cadastrado com sucesso!"); window.location.href = "dashadm.php";</script>';
        } catch (PDOException $e) {
            echo '<script>alert("Erro ao cadastrar funcionário: ' . $e->getMessage() . '");</script>';
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
    <title>Dashboard de Administração</title>
    <script>
        function confirmarSaida() {
            if (confirm("Tem certeza que deseja sair da plataforma?")) {
                window.location.href = "logout.php"; // Redireciona para o logout.php se confirmado
            }
        }

        function irParaCadastro() {
            window.location.href = "cadastro.php"; // Redireciona para cadastro.php
        }

        function editarFuncionario(cpf) {
            window.location.href = "editar.php?cpf=" + cpf; // Redireciona para a página de edição com o CPF do funcionário
        }

        function mostrarTodos() {
            window.location.href = "dashadm.php"; // Redireciona para dashadm.php para mostrar todos os funcionários
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="box">
            <h1 class="title">Cadastro de Funcionário</h1>
            <div class="button-group">
                <button class="btn-action" onclick="confirmarSaida()">Sair da Plataforma</button>
                <button class="btn-action" onclick="irParaCadastro()">Cadastrar Colaborador</button>
            </div>
            <br>
            <form action="#" method="post" class="form employee-form">
                <div class="form-group">
                    <label for="employee_cpf">CPF</label>
                    <input type="text" id="employee_cpf" name="cpf" class="form-control" placeholder="CPF" required>
                </div>
                <div class="form-group">
                    <label for="employee_name">Nome</label>
                    <input type="text" id="employee_name" name="nome" class="form-control" placeholder="Nome" required>
                </div>
                <div class="form-group">
                    <label for="employee_area">Área</label>
                    <input type="text" id="employee_area" name="area" class="form-control" placeholder="Área" required>
                </div>
                <div class="form-group">
                    <label for="employee_contact">Contato</label>
                    <input type="text" id="employee_contact" name="contato" class="form-control" placeholder="Contato" required>
                </div>
                <div class="form-group">
                    <label for="employee_age">Idade</label>
                    <input type="text" id="employee_age" name="idade" class="form-control" placeholder="Idade" required>
                </div>
                <button type="submit" class="btn">Cadastrar Funcionário</button>
            </form>
        </div>
        <div class="box">
            <h2 class="title">Funcionários Cadastrados</h2>
            <form action="#" method="get" class="form search-form">
                <div class="search-group">
                    <input type="text" id="search_query" name="query" class="form-control" placeholder="Buscar funcionários...">
                    <button type="submit" class="btn-search">Buscar</button>
                    <button type="button" class="btn-search" onclick="mostrarTodos()">Todos</button>
                </div>
            </form>
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Área</th>
                        <th>Contato</th>
                        <th>Idade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Listagem dos funcionários cadastrados -->
                    <?php
                    // Verifica se há um termo de pesquisa
                    $query = isset($_GET['query']) ? $_GET['query'] : '';

                    // Consulta SQL para buscar funcionários com base no termo de pesquisa
                    if ($query) {
                        $sql = "SELECT * FROM funcionarios WHERE cpf LIKE :query OR nome LIKE :query OR area LIKE :query OR contato LIKE :query OR idade LIKE :query";
                        $stmt = $pdo->prepare($sql);
                        $searchTerm = '%' . $query . '%';
                        $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
                    } else {
                        $sql = "SELECT * FROM funcionarios";
                        $stmt = $pdo->query($sql);
                    }

                    // Executa a consulta
                    $stmt->execute();

                    // Loop através dos resultados da consulta
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>{$row['cpf']}</td>";
                        echo "<td>{$row['nome']}</td>";
                        echo "<td>{$row['area']}</td>";
                        echo "<td>{$row['contato']}</td>";
                        echo "<td>{$row['idade']}</td>";
                        echo '<td class="action-buttons">';
                        echo '<button class="btn-action" onclick="editarFuncionario(\'' . $row['cpf'] . '\')">Editar</button>';
                        echo '<form action="#" method="post" class="form-delete">';
                        echo '<input type="hidden" name="delete_cpf" value="' . $row['cpf'] . '">';
                        echo '<button type="submit" class="btn-action">Excluir</button>';
                        echo '</form>';
                        echo '</td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
