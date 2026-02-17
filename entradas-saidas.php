<?php ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'checa-login.php';
require_once 'conecta.php';

if(isset($_GET['apaga_id'])){
$vconsulta = "delete from entra_sai where id_ea=".$_GET['apaga_id'];
mysqli_query($ligacao, $vconsulta);
mysqli_close($ligacao);
header("Location: menu.php?pag=entrada-saida");

//print "<script>close();</script>";


}

$tipo = $_GET['tipo'];// verifdica o tipo de indice para query abaixo.
$varOrdem = $_GET['ordem'];
$varTXT = $_GET['palavra'];
$varRegistros = $_GET['registros'];
$_SESSION['dataI'] = $_GET['dataI'];
$_SESSION['dataF'] = $_GET['dataF'];
$_SESSION['linhas'] = $_GET['linhas'];


if (empty($_GET['dataI'])) {
    $dataatual = date('Y-m-d');
    $datamenos20 = date('Y-m-d', strtotime('-20 days'));
}

if(isset($_GET['filial'])){
    
    if($_GET['filial'] == '000'){  // Condição corrigida
        // Faça algo se filial for igual a '000'
    } else {
        $vfilial = "AND filial = '" . $_GET['filial'] ."'" ;  // Adicionar aspas simples para comparar string no SQL
    }

}





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
        window.location = "entradas-saidas.php?apaga_id=" + objPar;
    }
}

</script>
</head>

<body>
<div align="center">
<div id="topogeralGrupo">
<div id="topo1">
<h2 class="hs1" align="center">ENTRADAS E SAIDAS</h2>
<br /><br />
<p class="hs1" align="left">&nbsp;&nbsp;&nbsp;Powered by CCBR IT - version 1.0</p>


</div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><!--
<strong>Add Movimentação:</strong><a href="javascript:OpenUp('edit-produto.php',770,550);"><img src="imagens/add.jpg" width="45" height="39" alt="add"></a> </p> -->
<div id="topo2">
<br />
   
   <form name="form1" action=""  method="GET">
<a href="menu.php?pag=entrada-saida">Atualizar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Ordenar : 
<select name="tipo" id="tipo">
  <!-- <option value="">--- Selecione Aqui ---</option> -->
  <option value="id_ea">id</option>
  <option value="produto">Produto</option>
</select>

<select name="ordem" id="ordem">
    <option value="DESC">--- Z -> A ---</option>
  <option value="ASC">--- A -> Z  ---</option>

</select>  
   <input type="hidden" name="pag" value="entrada-saida">
   <input name="btnEnviar" type="submit" value="submit">&nbsp;&nbsp;&nbsp;Index type:&nbsp;<?php print $tipo;?>&nbsp;&nbsp;Order:&nbsp;<?php print $varOrdem ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lines:<input type="text" name="registros" size="2" value="50" /> &nbsp;&nbsp;
    	</form><br />
		<form name="form2" method="GET">
<?php
// Verifica se 'filial' foi passado como parâmetro
$selected_filial = isset($_GET['filial']) ? $_GET['filial'] : '000';
?>

Filial: 
<select name="filial"> 
    <option value="000" <?php if ($selected_filial == '000') echo 'selected="selected"'; ?>>Selecione</option>
    <option value="CCBRSP" <?php if ($selected_filial == 'CCBRSP') echo 'selected="selected"'; ?>>São Paulo</option>
    <option value="CCBRDF" <?php if ($selected_filial == 'CCBRDF') echo 'selected="selected"'; ?>>Brasilia</option>
    <option value="CCBRVT" <?php if ($selected_filial == 'CCBRVT') echo 'selected="selected"'; ?>>Vitória</option>
    <option value="CCBRRJ" <?php if ($selected_filial == 'CCBRRJ') echo 'selected="selected"'; ?>>Rio de Janeiro</option>
    <option value="CCBRCP" <?php if ($selected_filial == 'CCBRCP') echo 'selected="selected"'; ?>>Campinas</option>
    <option value="CCBRPA" <?php if ($selected_filial == 'CCBRPA') echo 'selected="selected"'; ?>>Porto Alegre</option>
    <option value="CCBRCB" <?php if ($selected_filial == 'CCBRCB') echo 'selected="selected"'; ?>>Curitiba</option>
</select>

		    
		    
		    
		    Buscar :
		<input type="text" name="palavra" value="<?php print $varTXT; ?>" />Data Inicio: <input name="dataI" type="date" class="tx" id="dataI" value="<?php echo $datamenos20.$_GET['dataI'];?>" size="35" maxlength="45">&nbsp;&nbsp; Data Fim: <input name="dataF" type="date" class="tx" id="dataF" value="<?php echo $dataatual.$_GET['dataF'];?>" size="35" maxlength="45">
		   <input type="hidden" name="pag" value="entrada-saida">

		   
		   
		<input name="Buscar"  value="Submit" type="submit" />
Lines :<input type="text" name="registros" size="2" value="50" /> &nbsp;&nbsp;
		</form> 
	<br />
</div> 
</div>
<br /><br /><br /><br /><br /><br /><br /><br />
<?php

$varTXT = trim($varTXT); // Remove espaços extras

if ($varTXT === '') {
    // Não faz nada se estiver em branco
} else if (!preg_match('/^[a-zA-Z0-9\s]+$/', $varTXT)) {
    $erro = "A entrada contém caracteres inválidos!";
    $varTXT = ""; // Reseta a variável
    echo "<span style='color:red;'>$erro</span>";
} else {
    echo "Palavra chave pesquisada : " . htmlspecialchars($varTXT);
}

?>
<br /><br />
<table border="1" class="display" cellspacing="0" style="width:90%">

      <tr><!--<td  align="center" width="30" class="tdtopo"><strong>Action</strong></td>-->
	  <td  align="center" width="30" class="tdtopo"><strong>ID</strong></td>
	  <td  align="center" width="300" class="tdtopo"><strong>Produto</strong></td> 
	  	 <td  align="center" width="100"  class="tdtopo"><strong>Filial</strong></td>
	 <td  align="center" width="100"  class="tdtopo"><strong>Quantidade</strong></td>
	 <td  align="center" width="200"  class="tdtopo"><strong>Tipo Operação</strong></td> 
    <td align="center" width="100" class="tdtopo"><strong>usuário<strong></td>
     <td align="center" width="300" class="tdtopo"><strong>OBS<strong></td> 
        <td align="center" width="100" class="tdtopo"><strong>Data Movimentação<strong></td> 
    
        <?php  if($_SESSION['tipouser']=='admin'){
    //print '<td  align="center" width="20" class="tdtopo"><strong>Delete</strong></td>';
			  } ?>
	  </tr>
	  
	  <?php
	
		  if(isset($tipo)){
			  $varQuery = "SELECT *  FROM entra_sai  order by ".$tipo." ".$varOrdem." LIMIT ".$varRegistros;
			  
			 
			   
		 }else if(isset($varTXT)){
					  
		        $varQuery = "SELECT * FROM entra_sai  where produto  like '%".$varTXT."%' and DATE(data_movimentacao)   BETWEEN '".$_SESSION['dataI']."' AND '".$_SESSION['dataF']."' ".$vfilial."  order by id_ea ASC  LIMIT ".$varRegistros;
		        
		         // print $varQuery;
	            // die;
		 
		}else{
			
			    $varQuery = "SELECT * FROM entra_sai order by id_ea DESC LIMIT 50 ";
			
		}
			
	    
		// print $consulta;
		// print $varQuery;
	    // die;
		
			$vconsulta= $varQuery;
	  
	//print $vconsulta;
	//die;

	  	
	  $sql = mysqli_query($ligacao, $vconsulta);
													$contador = 0;
		while($row = mysqli_fetch_array($sql)){
					
					 // Inicializa um contador
					$corDaLinha = ($contador % 2 == 0) ? 'cor1' : 'cor2'; // Alterna entre as classes cor1 e cor2
    

	  ?>
	        <tr class="<?php echo $corDaLinha;?>">
			<!--<td  align="center" >
			<a href="javascript:OpenUp('edit-produto.php?id=<?php  print $row['id_ea']; ?>',770,550);"><img src="imagens/lapis.png" alt="editar" width="30" height="30"></a></td>-->
			<td  align="center" height ="30"><?php  print $row['id_ea']; ?></td> 
			<td  align="center"><?php  print $row['produto']; ?></td> 
				<td  align="center"><?php  print $row['filial']; ?></td> 
	        <td  align="center"><?php  print $row['quantidade']; ?></td>
	  	   <td  align="center"><?php  print $row['tipo_operacao']; ?></td>
	  	   <td align="center"><?php  print $row['usuario']; ?></td>
	  	   <td align="center"><?php  print $row['obs']; ?></td> 
	  	   <td align="center"><?php  print $row['data_movimentacao']; ?></td> 

	    <?php  if($_SESSION['tipouser']=='admin2'){
			  // print'<td align="center"><a href="javascript:confirma('.$row['id_ea'].')"><img src="imagens/apagar.jpg"></a></td>';
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