<?php
ob_start();
session_start();

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

*/

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



require_once 'checa-login.php';
require_once 'conecta.php';

if(isset($_GET['apaga_id'])){
    
// ID do estoque já existente (pode ser passado via GET, POST, ou ser fixo para testes)
$idEstoque = $_GET['apaga_id']; // Substitua com o ID do registro que você quer consultar

// Consulta o registro na tabela `estoque`
$sqlConsulta = "SELECT * FROM estoque WHERE id_estoque = $idEstoque";

$resultConsulta = $ligacao->query($sqlConsulta);

if ($resultConsulta && $resultConsulta->num_rows > 0) {
    // Recupera os dados do registro encontrado
    $row = $resultConsulta->fetch_assoc();

    $idEstoque = $row['id_estoque'];
    $filial = $row['filial'];
    $produto = $row['produto'];
    $descricao = $row['descricao'];
    $quantidade = $row['quantidade'];
    $operador = $row['operador'];
    $ultimaAtualizacao = $row['ultima_atualizacao'];
    $tipo_operacao ='Exclusão do cadastro';
    $usuarioC = $_SESSION['username'];
    $obs = 'Excluído pelo usuário';

    // Insere os dados em outra tabela (por exemplo, `estoque_historico`)
    //$sqlInsert = "INSERT INTO estoque_historico (id_estoque, filial, produto, descricao, quantidade, operador, ultima_atualizacao)
                 // VALUES ('$idEstoque', '$filial', '$produto', '$descricao', '$quantidade', '$operador', '$ultimaAtualizaca            // Consulta para registrar a mudança no histórico
     
     
     //$sqlInsert = "INSERT INTO entra_sai (filial, produto, quantidade, tipo_operacao, obs, data_movimentacao) 
       //                  VALUES ('$filial', '$produto', '$quantidade', '$tipo_operacao', '$usuarioC' ,   CURRENT_TIMESTAMP)";
                         
      $sqlInsert = "INSERT INTO entra_sai (filial, produto, quantidade, obs, tipo_operacao,  usuario, data_movimentacao) 
                           VALUES ('$filial', '$produto', '$quantidade', '$obs', '$tipo_operacao', '$usuarioC', CURRENT_TIMESTAMP)";
                  
        //print $insert_sql;
        //die;

    if ($ligacao->query($sqlInsert) === TRUE) {
        echo "Dados inseridos na tabela `estoque_historico` com sucesso!";
    } else {
        echo "Erro ao inserir na tabela `estoque_historico`: " . $conn->error;
    }
} else {
    echo "Registro não encontrado na tabela `estoque`.";
}

// Você pode continuar usando a mesma conexão ou fechá-la aqui se não precisar de mais nada
  
  //echo "Parou aqui !!!";
    //die;
    
$vconsulta = "delete from estoque  where id_estoque=".$_GET['apaga_id'];
mysqli_query($ligacao, $vconsulta);
mysqli_close($ligacao);
header("Location: menu.php?pag=estoque");





}

$tipo = $_GET['tipo'];// verifdica o tipo de indice para query abaixo.
$varOrdem = $_GET['ordem'];
$varTXT = $_GET['palavra'];
$vatFilial= $_GET['FilialBusca'];
$varRegistros = $_GET['registros'];
$_SESSION['linhas']= $_GET['linhas'];
$filial = $_GET['filial'];
$FilialBusca = $GET['FilialBusca'];

// Verifica se o valor 'filial' foi passado via GET
$filial_selecionada = isset($_GET['filial']) ? $_GET['filial'] : '';


?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<title>Lista Estoque</title>

<script>

function confirma(objPar) {
    if (confirm("Confirm delete?")) {
        window.location = "lista_estoque.php?apaga_id=" + objPar;
    }
}

</script>
</head>

<body>
<div align="center">
<div id="topogeralGrupo">
<div id="topo1">
<h2 class="hs1" align="center">LISTA ESTOQUE</h2>
<br />
<p class="hs1" align="left">&nbsp;&nbsp;&nbsp;Powered by CCBR IT - version 1.0</p>

</div>

<br /><br /><br /><br /><br /><br /><br /><br /><br />
<div id="addproduto">
    <br /> <br />
     <strong></strong><a href="javascript:OpenUp('add_produto.php',770,550);">Add Produto</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="menu.php?pag=estoque">Atualizar</a></p>
<!-- <strong>Add Produto:</strong><a href="javascript:OpenUp('add_produto.php',770,550);"><img src="imagens/add.jpg" width="30" height="29" alt="add"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="menu.php?pag=estoque"><img src="imagens/atualizaP.png" /></a>-->  


    <form method="GET" action="">
        
<!--
<select name="filial" required>
    <option value="0" <?php echo ($filial_selecionada == '') ? 'selected' : ''; ?>>--- Todas ---</option>
    <option value="CCBRSP" <?php echo ($filial_selecionada == 'CCBRSP') ? 'selected' : ''; ?>>São Paulo</option>
    <option value="CCBRDF" <?php echo ($filial_selecionada == 'CCBRDF') ? 'selected' : ''; ?>>Brasilia</option>
    <option value="CCBRVT" <?php echo ($filial_selecionada == 'CCBRVT') ? 'selected' : ''; ?>>Vitória</option>
    <option value="CCBRRJ" <?php echo ($filial_selecionada == 'CCBRRJ') ? 'selected' : ''; ?>>Rio de Janeiro</option>
    <option value="CCBRCP" <?php echo ($filial_selecionada == 'CCBRCP') ? 'selected' : ''; ?>>Campinas</option>
    <option value="CCBRPA" <?php echo ($filial_selecionada == 'CCBRPA') ? 'selected' : ''; ?>>Porto Alegre</option>
    <option value="CCBRCB" <?php echo ($filial_selecionada == 'CCBRCB') ? 'selected' : ''; ?>>Curitiba</option>
</select>-->
<br />
<table width="900" ><tr><td width="150"> <strong><label for="filial">Lista de Estoque:</label></strong></td>

<td width="150">
<?php

// Sua query para buscar os dados das filiais
$query = "SELECT * FROM filiais";

$result = mysqli_query($ligacao, $query);

if ($result):
?>
    <!-- Começa o elemento select -->
    <select name="filial">
        <option value="0"<?php echo ($filial_selecionada == '') ? 'selected' : ''; ?>>Todos</option>

        <?php
        // Loop pelo resultado da query para gerar as opções
        while ($row = mysqli_fetch_assoc($result)): 
        ?>
          <option value="<?php echo $row['filial']; ?>" <?php echo ($filial_selecionada == $row['filial']) ? 'selected' : ''; ?>>

                <?php echo $row['nome_filial']; ?>
            </option>
        <?php endwhile; ?>
    </select>
<?php
else:
    echo "Erro na consulta: " . mysqli_error($ligacao);
endif;

// Fecha a conexão com o banco de dados
//mysqli_close($ligacao);
?>

    
    
    
    
</td>
    
    <td><input type="hidden" name="pag" value="estoque"><input name="" value="Listar Estoque" type="submit"></td>
<td width="300"><!--<a href="menu.php?pag=estoque"><img src="imagens/atualizaP.png" /></a>--></td></tr></table>



</form>

</div>

<div id="topo2">

<br />
   <form name="form1"  method="GET">
Ordenar : 
<select name="tipo" id="tipo">
  <!-- <option value="">--- Selecione Aqui ---</option> -->
  <option value="id_estoque">id</option>
  <option value="produto">Produto</option>
</select>

<select name="ordem" id="ordem">
    <option value="DESC">--- Z -> A ---</option>
    <option value="ASC">--- A -> Z  ---</option>

</select>  
   <input type="hidden" name="pag" value="estoque">
 
   <input name="btnEnviar" type="submit" value="submit">&nbsp;&nbsp;&nbsp;&nbsp;<?php print $tipo;?>&nbsp;&nbsp;Lines:<input type="text" name="registros" size="2" value="50" /> <br /><br />
    	
    	</form>
		<form name="form2" method="GET">
	<strong><label for="FilialBusca">Estoque:</strong>
<select name="FilialBusca">
    <option value="000" <?php echo ($vatFilial == '') ? 'selected' : ''; ?>> Todos</option>
    <option value="CCBRSP" <?php echo ($vatFilial == 'CCBRSP') ? 'selected' : ''; ?>>São Paulo</option>
    <option value="CCBRDF" <?php echo ($vatFilial == 'CCBRDF') ? 'selected' : ''; ?>>Brasilia</option>
    <option value="CCBRVT" <?php echo ($vatFilial== 'CCBRVT') ? 'selected' : ''; ?>>Vitória</option>
    <option value="CCBRRJ" <?php echo ($vatFilial == 'CCBRRJ') ? 'selected' : ''; ?>>Rio de Janeiro</option>
    <option value="CCBRCP" <?php echo ($vatFilial == 'CCBRCP') ? 'selected' : ''; ?>>Campinas</option>
    <option value="CCBRPA" <?php echo ($vatFilial == 'CCBRPA') ? 'selected' : ''; ?>>Porto Alegre</option>
    <option value="CCBRCB" <?php echo ($vatFilial == 'CCBRCB') ? 'selected' : ''; ?>>Curitiba</option>
</select>
&nbsp;
		<input type="text" name="palavra" value="<?php print $varTXT; ?>" />
		 <input type="hidden" name="pag" value="estoque">
		

		<input name="Buscar"  value="<-- Buscar Produto" type="submit" />
Lines :<input type="text" name="registros" size="2" value="40" /><br /><br /><br /><br />

		</form> 
	<br />
</div> 
</div>


<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<?php

if(isset($varTXT)){
$erro = false;

// Valida a entrada
if (!preg_match('/^[a-zA-Z0-9\s]+$/', $varTXT)) {
    $erro = "A entrada contém caracteres inválidos Variavel descartada  !  ";
    $varTXT = ""; // Reseta a variável
}

    // Exibe o erro, se houver
    if ($erro) {
    echo "<span style='color:red;'>$erro</span>";
    } else {
    // Continua com o processamento normal
    echo "Palavra chave pesquisada: " . htmlspecialchars($varTXT);
}

}
?>
<br /><br />
<table border="1" class="display" cellspacing="0" style="width:80%">
    <tr>
        <?php
            if($_SESSION['tipouser']=='admin'){
        print' <td align="center" width="30" class="tdtopo"><strong>Action</strong></td>';
            }?>
	  <td  align="center" width="30" class="tdtopo"><strong>ID</strong></td>
	  <td  align="center" width="90" class="tdtopo"><strong>Filial</strong></td> 
	   <td  align="center" width="150" class="tdtopo"><strong>Nome do Produto</strong></td>
	    <td  align="center" width="250" class="tdtopo"><strong>Descrição</strong></td> 
<td align="center" width="10" class="tdtopo"><strong>Quantidade<strong></td> 
			 <?php
			  if($_SESSION['tipouser']=='admin'){
			 print' <td  align="center" width="20" class="tdtopo"><strong>Delete</strong></td>'; 
			 } ?>
			  
	  </tr>
	  
	  <?php
	
		  if(isset($tipo)){
			  $varQuery = "SELECT *  FROM estoque  order by ".$tipo." ".$varOrdem." LIMIT ".$varRegistros;
			  
			  
		  }else if(isset($varTXT) and ($vatFilial == '000')){
					  
		 //$varQuery = "SELECT * FROM estoque where produto like '%".$varTXT."%' order by id_estoque asc  LIMIT ".$varRegistros;
		 
		 $varQuery = "SELECT * FROM estoque WHERE produto LIKE '%".$varTXT."%' or filial = '$vatFilial' ORDER BY id_estoque ASC LIMIT ".$varRegistros;
         
         //print $varQuery;
		 //die;
      
		  }else if(isset($varTXT)){
					  
		 //$varQuery = "SELECT * FROM estoque where produto like '%".$varTXT."%' order by id_estoque asc  LIMIT ".$varRegistros;
		 
		 $varQuery = "SELECT * FROM estoque WHERE descricao LIKE '%".$varTXT."%' AND filial = '$vatFilial' ORDER BY id_estoque ASC LIMIT ".$varRegistros;

            	 
         //print $varQuery;
		 //die;
		 
		 }else if(isset($filial)){
		     
		            if($filial == '0'){ 	$varQuery = "SELECT * FROM estoque order by id_estoque LIMIT 50 "; 
		                
		            }else {
		                                $varQuery = "SELECT * FROM estoque where filial ='".$filial."' order by id_estoque LIMIT 50 ";
		            }
		
		 
		 //print $varQuery;
		 // die;
		 
		}else{
			
			$varQuery = "SELECT * FROM estoque order by id_estoque DESC LIMIT 50 ";
			
		}
			
	    
		//print $consulta;
		//print $varQuery;
	  
			$vconsulta= $varQuery;
	  


		//die;
	  	
	  $sql = mysqli_query($ligacao, $vconsulta);
													$contador = 0;
		while($row = mysqli_fetch_array($sql)){
					
					 // Inicializa um contador
					$corDaLinha = ($contador % 2 == 0) ? 'cor1' : 'cor2'; // Alterna entre as classes cor1 e cor2
    

	  ?>
	        <tr class="<?php echo $corDaLinha;?>">
						    <?php
            if($_SESSION['tipouser']=='admin'){
			print '<td  align="center"><a href="javascript:OpenUp(\'edit-produto.php?id='. $row['id_estoque'].'\',770,550);"><img src="imagens/lapis.png" alt="editar" width="30" height="30"></a></td> ';
			   } ?></td>
			<td  align="center" height="35"><?php  print $row['id_estoque']; ?>
			<td  align="center"><?php  print $row['filial']; ?></td> 
	        <td  align="center"><?php  print $row['produto']; ?></td>
	  	   <td  align="center"><?php  print $row['descricao']; ?></td>
	  	   <td align="center"><?php  print $row['quantidade']; ?></td> 
	    
            <?php
            
            if($_SESSION['tipouser']=='admin'){
			  print ' <td align="center"><a href="javascript:confirma('.$row['id_estoque'].')"><img src="imagens/apagar.jpg"></a></td> ';
            }

	  $contador++;
	     
		 }
		 
		   
			 
		  mysqli_close($ligacao);
	  ?>
</tr>

</table><br />


<br /><br /><br /><br />


</div>



</body>
</html>
