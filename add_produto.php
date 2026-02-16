<?php ob_start();
session_start();
require_once  'conecta.php'; // Inclui a conexão com o banco de dados
require_once 'checa-login.php';
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $filial = mysqli_real_escape_string($ligacao, $_POST['filial']);
    $produto = mysqli_real_escape_string($ligacao, $_POST['produto']);
    $descricao = mysqli_real_escape_string($ligacao, $_POST['descricao']);
    $quantidade = (int)$_POST['quantidade']; // Garantir que quantidade seja um número

    // Monta a query para inserção
    $sql = "INSERT INTO estoque (id_estoque, filial, produto, descricao, quantidade, ultima_atualizacao) 
            VALUES (NULL, '$filial', '$produto', '$descricao', '$quantidade', CURRENT_TIMESTAMP)";

    // Executa a query e verifica se foi bem-sucedida
    if (mysqli_query($ligacao, $sql)) {
        echo "Novo registro inserido com sucesso!";
        echo "<script>javascript:window.close();</script>";
    } else {
        echo "Erro: " . mysqli_error($ligacao);
    }

    // Fecha a conexão
    mysqli_close($ligacao);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <title>Inserir Produto no Estoque</title>
</head>
<body>
    <div id="corpogeralpop">
    <h1>Inserir Produto no Estoque</h1>
    
    <form method="POST" action="">
    
        <strong><label for="filial">Filial:</strong></label> <br >
    <!--    <select name="filial" required>
	  <option value="" selected>Selecione</option>
  <option value="CCBRSP">São Paulo</option>
  <option value="CCBRDF">Brasilia</option>
  <option value="CCBRVT">Vitória</option>
  <option value="CCBRRJ">Rio de Janeiro</option>
  <option value="CCBRCP">Campinas</option>
    <option value="CCBRPA">Porto Alegre</option>
	  <option value="CCBRCB">Curitiba</option>
</select> -->
<?php

// Sua query para buscar os dados das filiais
$query = "SELECT * FROM filiais";

$result = mysqli_query($ligacao, $query);

if ($result):
?>
    <!-- Começa o elemento select -->
    <select name="filial" required>
        <option value="">Selecione</option>

        <?php
        // Loop pelo resultado da query para gerar as opções
        while ($row = mysqli_fetch_assoc($result)): 
        ?>
            <option value="<?php echo $row['filial']; ?>">
                <?php echo $row['nome_filial']; ?>
            </option>
        <?php endwhile; ?>
    </select>
<?php
else:
    echo "Erro na consulta: " . mysqli_error($ligacao);
endif;

// Fecha a conexão com o banco de dados
mysqli_close($ligacao);

?>

<br /><br /><br />



       <strong><label for="produto">Nome do Produto:</label></strong><br>
        <input type="text" size="70" id="produto" name="produto" required><br><br>

        <strong><label for="descricao">Descrição:</label></strong><br>
        <textarea id="descricao" rows="10" cols="70" name="descricao" required></textarea><br><br>

        <strong><label for="quantidade">Quantidade: sempre inicia automaticamente  com "  0 "</label></strong><br><br>


        <input type="submit" value="Inserir Produto">
        </form><br /><br /><br />
    </div>
</body>
</html>
