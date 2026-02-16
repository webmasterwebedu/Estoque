
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Estoque</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>
    <h1>Listagem de Estoque</h1>
    <?php
include 'conecta.php'; // Inclui a conexão com o banco de dados

// Consulta para listar o estoque
$sql = "SELECT id, filial, nome_produto, descricao, quantidade, ultima_atualizacao FROM estoque";

// Executa a consulta e verifica se houve erro
$result = mysqli_query($ligacao, $sql);

if (!$result) {
    // Exibe o erro da consulta, caso haja
    die("Erro na consulta SQL: " . mysqli_error($ligacao));
}

if (mysqli_num_rows($result) > 0) {
    // Exibe os dados em uma tabela
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Filial</th>
                <th>Nome do Produto</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Última Atualização</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['filial']}</td>
                <td>{$row['nome_produto']}</td>
                <td>{$row['descricao']}</td>
                <td>{$row['quantidade']}</td>
                <td>{$row['ultima_atualizacao']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum registro encontrado.</p>";
}

// Fecha a conexão com o banco de dados
mysqli_close($ligacao);
?>
</body>
</html>
