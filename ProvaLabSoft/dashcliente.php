<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylecliente.css">
    <title>Visualização de Funcionários</title>
    <script>
        // Função para confirmar saída da plataforma
        function confirmarSaida() {
            if (confirm("Tem certeza que deseja sair da plataforma?")) {
                window.location.href = "logout.php"; // Redireciona para o logout.php se confirmado
            }
        }

        // Função para mostrar todos os funcionários
        function mostrarTodos() {
            window.location.href = "dashcliente.php"; // Redireciona para a página sem parâmetro de busca
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="box">
            <h1 class="title">Funcionários</h1>
            <div class="button-group">
                <button class="btn-action" onclick="confirmarSaida()">Sair da Plataforma</button>
            </div>
           
            <form action="#" method="get" class="form search-form">
                <div class="form-group">
                    <input type="text" id="search_query" name="query" class="form-control" placeholder="Buscar funcionários...">
                </div>
                <button type="submit" class="btn-search">Buscar</button>
                <button type="button" class="btn-search" onclick="mostrarTodos()">Todos</button>
            </form>
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Área</th>
                        <th>Contato</th>
                        <th>Idade</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP para listar os funcionários -->
                    <?php
                    // Incluir o arquivo de conexão com o banco de dados
                    include 'config.php';

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
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
