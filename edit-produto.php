<?php ob_start();
session_start();
require_once 'conecta.php';
require_once 'checa-login.php';


$quantidadeatual = $_POST['quantidadeatual'];

$operacao = $_POST['tipo_operacao'];

 $quantidade = (int)$_POST['quantidade'];
 
 $obs = $_POST['obs'];

 
if ($quantidade < 0) {
    echo 'O Valor não pode ser menor que 0. <a href="javascript:history.back()">voltar</a>';
    die;
}




if($operacao =='Entrada'){
    
    $valoroperacao = $quantidadeatual + $quantidade;
}else{
    
     $valoroperacao = $quantidadeatual - $quantidade;
}



// Verifica se o ID do produto a ser editado foi passado na URL
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Consulta para obter os dados do produto com o ID fornecido
    $sql = "SELECT * FROM estoque WHERE id_estoque = $id";
    $result = mysqli_query($ligacao, $sql);

    if (!$result) {
        die("Erro na consulta SQL: " . mysqli_error($ligacao));
    }

    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("Produto não encontrado.");
    }

    // Atualiza os dados se o formulário for enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $filial = mysqli_real_escape_string($ligacao, $_POST['filial']);
        $produto = mysqli_real_escape_string($ligacao, $_POST['produto']);
        $descricao = mysqli_real_escape_string($ligacao, $_POST['descricao']);

        $tipo_operacao =$_POST['tipo_operacao'];

        // Consulta para atualizar o registro
        $update_sql = "UPDATE estoque SET 
                        filial = '$filial',
                        produto = '$produto',
                        descricao = '$descricao',
                        quantidade = '$valoroperacao',
                        ultima_atualizacao = CURRENT_TIMESTAMP
                        WHERE id_estoque = $id";

        if (mysqli_query($ligacao, $update_sql)) {
            // Aqui entra o INSERT INTO após o UPDATE bem-sucedido
            
            $usuario = $_SESSION['username']; // Exemplo de usuário que fez a mudança (pode vir de uma sessão, por exemplo)
            
           
         
            
            // Consulta para registrar a mudança no histórico
            $insert_sql = "INSERT INTO entra_sai (filial, produto, quantidade, obs, tipo_operacao,  usuario, data_movimentacao) 
                           VALUES ('$filial', '$produto', '$quantidade', '$obs', '$tipo_operacao', '$usuario', CURRENT_TIMESTAMP)";
                           
             //print $insert_sql;
            //die ;

            if (mysqli_query($ligacao, $insert_sql)) {
                echo "<br /><br /><br /><br /><p align=\"left\">	Registro Atualizado : - )  &nbsp;&nbsp;|&nbsp;&nbsp; <a href=\"javascript:close();\">
	<img src=\"imagens/exit.jpg\" width=\"30\" height=\"32\" alt=\"voltar\"></a>
	<br /><br /><br />Powered by TI CCBR - version 1.0</p><script>javascript:close();</script>";
            } else {
                echo "Erro ao registrar a movimentação: " . mysqli_error($ligacao);
            }

            // Redireciona para a mesma página após o update, para carregar os novos dados
         //   header("Location: edit-produto.php?id=$id");
            exit(); // Importante para parar a execução do script
        } else {
            echo "Erro: " . mysqli_error($ligacao);
        }
    }

    mysqli_close($ligacao);
} else {
    die("ID do produto não fornecido.");
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <title>Editar Produto no Estoque</title>
</head>
<body>
    <div id="corpogeralpop">
    <h1>EditarProduto no Estoque</h1>
    
    <h2>Quantidade atual: <?php echo htmlspecialchars($row['quantidade']); ?></h2>
    
    
    <form method="POST" action="">
        <label for="filial">Filial:</label><input type="text" id="filial" name="filial" value="<?php echo htmlspecialchars($row['filial']); ?>" readonly>
        
        
                  <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo de Operação</label>&nbsp;
        <select name="tipo_operacao">
            <option value="Entrada">Entrada</option>
            <option value="Saida">Saida</option>
            
        </select>
        
        <br>
        
        
        
        
        
        <br>

        <label for="produto">Nome do Produto:</label><br>
        <input type="text" size="70" id="produto" name="produto" value="<?php echo htmlspecialchars($row['produto']); ?>" readonly><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao" rows="5" cols="70" readonly><?php echo htmlspecialchars($row['descricao']); ?></textarea><br><br>

        <label for="quantidade">Quantidade:</label><input type="number" size="4" id="quantidade"  name="quantidade" value="" required><br><br>
        
        <label for="obs">OBS: </label><input type="text" size="50" id="obs" name="obs" value="" required>
        <br><br>
        
        
        
        <input type="hidden" name="quantidadeatual" value="<?php echo htmlspecialchars($row['quantidade']); ?>" />
        <br />    <br />

        <input type="submit" value="Atualizar Produto">
    </form>
    <br />
    
    </div>
</body>
</html>
