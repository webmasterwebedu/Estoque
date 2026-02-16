<?php ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'checa-login.php';
require_once 'conecta.php';

$varRegistros = $_GET['registros'];
$tipo = $_GET['tipo'];
$varOrdem = $_GET['ordem'];
$varTXT = $_GET['palavra'];




if(isset($_GET['apaga_id'])){
$vconsulta = "delete from filiais  where id_filial=".$_GET['apaga_id'];
mysqli_query($ligacao, $vconsulta);
mysqli_close($ligacao);
header("Location: menu.php?pag=lista-empresas");

}


$tipo = $_GET['tipo'];// verifdica o tipo de indice para query abaixo.
$varFilial = $_GET['filial'];
$varNomeFilial = $_GET['NomeFilial'];

if($_SESSION['tipouser']!='admin'){
    print "<br /><br />Conta User acesso negado.";
    die;
}

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<title>Admin Users</title>

<script>

function confirma(objPar) {
    // Solicita a senha ao usuário
    //var senha = prompt("Add the Password:");

    // Criptografa a senha digitada
   // senha = btoa(senha);
	//alert(senha);
    // Verifica se a senha criptografada está correta
    //f (senha === "Q2xlYXJAMjAyMA==") { // Substitua "senha_correta" pela senha real criptografada
        if (confirm("Confirm delete?")) {
            window.location = "lista-empresas.php?apaga_id=" + objPar;
        }
   // } else {
      //  alert("Incorrect password. Action cancelled.");
   // }
}

</script>
</head>

<body>
<div align="center">
<div id="topogeralGrupo">
<div id="topo1">
<h2 class="hs1" align="center">	ADMIN USERS</h2>
<br /><br />
<p class="hs1" align="left">&nbsp;&nbsp;&nbsp;Powered by CCBR IT - version 1.0</p>


</div>

<br /><br /><br /><br /><br /><br /><br /><br /><br />






<div id="addproduto"><br /><br /><br />
<strong><a href="javascript:OpenUp('add-filial.php',770,550);">Add Empresa</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="menu.php?pag=lista-empresas  ">Atualizar</a> </p>
</div>
<div id="topo2">

<br />
   
   <form name="form1" method="GET">
   
  
     
Ordenar : 
<select name="tipo" id="tipo">
  <!-- <option value="">--- Selecione Aqui ---</option> -->
  <option value="id_filial">id_filial</option>
  <option value="filial">Filial</option>
</select>

<select name="ordem" id="ordem">
  <option value="ASC">--- A -> Z  ---</option>
    <option value="DESC">--- Z -> A ---</option>
</select>  
  
      <input type="hidden"  name="pag" value="<?php print$_GET['pag'];?>" />
     
   
   <input name="btnEnviar" type="submit" value="submit">&nbsp;&nbsp;&nbsp;&nbsp;<?php print $varOrdem ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
   Number of Lines:<input type="text" name="registros" size="2" value="50" /> <br /><br />
    	</form>
     
     
		<form name="form2" method="GET">Buscar :
		<input type="text" name="palavra" value="<?php print $varTXT; ?>" />
		<input name="Buscar"  value="Submit" type="submit" />
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Number of Lines :<input type="text" name="registros" size="2" value="50" /> 
    <input type="hidden"  name="pag" value="<?php print $_GET['pag'];?>" />
		</form> <br />
</div> 
</div>
<br /><br /><br /><br /><br /><br /><br /><br />


<?php

if(isset($varTXT)){
$erro = false;

// Valida a entrada
if (!preg_match('/^[a-zA-Z0-9\s]+$/', $varTXT)) {
    $erro = "A entrada contém caracteres inválidos variavel descartada !<br /><br />";
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

<table border="1" class="display" cellspacing="0" style="width:80%">
        <tr>
        <?php
    if($_SESSION['tipouser'] == 'admin') {
      print'<td  align="center" width="30" class="tdtopo"><strong>Action</strong></td>';
        } ?>
	  <td  align="center" width="30" class="tdtopo"><strong>ID</strong></td>
	  <td  align="center" width="90" class="tdtopo"><strong>Filial</strong></td> 
	   <td  align="center" width="350" class="tdtopo"><strong>Nome Filial</strong></td> 

	    		 <?php
			  if($_SESSION['tipouser']=='admin'){
			  print '<td  align="center" width="20" class="tdtopo"><strong>Delete</strong></td>';
			  } ?>
			  
	  </tr>
	  
	  <?php
	
		  if(isset($tipo)){
			  $varQuery = "SELECT *  FROM filiais  order by ".$tipo." ".$varOrdem." LIMIT ".$varRegistros;
			  
		 }else if(isset($varTXT)){
					  
		 $varQuery = "SELECT * FROM filiais where nome_filial like '%".$varTXT."%' order by id_filial asc  LIMIT ".$varRegistros;
		}else{
			
			$varQuery = "SELECT * FROM filiais  order by id_filial LIMIT 50 ";
			
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
    if($_SESSION['tipouser'] == 'admin') {
        print '<td align="center"><a href="javascript:OpenUp(\'edit-filial.php?id_filial=' . $row['id_filial'] . '\',770,550);"><img src="imagens/lapis.png" alt="editar" width="30" height="30"></a></td>';
    }
    ?>


			<td  align="center" height="35"><?php  print $row['id_filial']; ?></td>
	        <td align="center"><?php  print $row['filial']; ?></td>
	  	   <td  align="center"><?php  print $row['nome_filial']; ?></td> 

            <?php
            
			  if($_SESSION['tipouser']=='admin'){
			  print' <td align="center"><a href="javascript:confirma('. $row['id_filial'].')"><img src="imagens/apagar.jpg"></a></td>';
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