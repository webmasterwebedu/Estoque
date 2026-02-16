<?php ob_start();
session_start();
require_once 'checa-login.php';
require_once 'conecta.php';

$vresposta = "";


if (isset($_POST['btn_update'])){
	
	$vid = $_POST['id'];
	$vfilial = $_POST['filial'];
	$vnome_filial = $_POST['nome_filial'];

		
	$vquery = "update filiais set filial = '$vfilial', nome_filial = '$vnome_filial'  where id_filial = $vid "; 
	
	//print $vquery;
	
	// die;
	
if (mysqli_query($ligacao, $vquery)) {
    $vresposta = "<p align=\"left\">	Registro Atualizado : - )  &nbsp;&nbsp;|&nbsp;&nbsp; <a href=\"javascript:close();\">
	<img src=\"imagens/exit.jpg\" width=\"30\" height=\"32\" alt=\"voltar\"></a>
	<br /><br /><br />Powered by TI CCBR - version 1.0</p>";
} else {
    $vresposta = "Erro " . mysqli_error($ligacao);
}
//mysqli_close($ligacao);
}

?>


<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<title>Lista de Filiais</title>


</head>
<body>
    
<div id="corpogeral">
<h1>Edição de Filiais</h1>

<?php
	
$varid = $_GET['id_filial'];

if (isset($varid)){
	    echo "";
	  
	  $vconsulta= "SELECT * FROM filiais where id_filial=".$varid;
	  
	  	//echo $vconsulta;

		//die;
		
	  	
	  $sql = mysqli_query($ligacao, $vconsulta);

		while($lista = mysqli_fetch_array($sql)){
		
	print"<hr />"; 	
	


	?>

<h3>Edição de Filial:</h3>
<form  action="" name="formulario2" method="post" id="formulario2">

<input type="hidden" name="id" value="<?php print $lista['id_filial']; ?>">
  <p>

    <br>
	    Filial:
      <input name="filial" value="<?php echo $lista['filial']; ?>" size = "45" type="text"  id="user">
    <br>
    <br>

  
    <p>
        nome Completo Filial:
      <input name="nome_filial" value="<?php echo $lista['nome_filial']; ?>" size = "54" type="text"  id="nome_filial">
      <br>
      <br>
<br><br>
 
    <input name="btn_update" type="submit" value="Atualizar Registro"> 
    &nbsp;&nbsp;&nbsp;&nbsp;
	
	<!-- ou
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Deletar Registro 
    <a href="javascript:confirma(<?php print $lista['id']?>)"><img src="imagens/apagar.jpg" width="16" height="16" alt="Apagar"></a></p>
-->

</form>

 

<p>
<?php
	// Fecha o  While
    }
	
		}
		
	mysqli_close($ligacao);
	
	

   echo $vresposta;

	?>



</div></body>
</html>





