
<?php
ob_start();
session_start();

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

*/

require_once 'conecta.php';
require_once 'checa-login.php';

$vresposta = "";


if (isset($_POST['btn_add'])){
	
	$vid = $_POST['id'];
	$vuser = $_POST['user'];
	$vvpassword = $_POST['password'];
	$vpassword = md5($vvpassword);
	
	$vNomeCompleto = $_POST['NomeCompleto'];
	$vfilialCC = $_POST['filial'];
	$vuserOBS = $_POST['userOBS'];
	$tipo = $_POST['usuario_tipo'];
			
			
			//Comando SQL INSERT INTO
$vquery = "INSERT INTO api_user (user, password, NomeCompleto, filialCC, userOBS, tipo)
        VALUES ('$vuser', '$vpassword', '$vNomeCompleto', '$vfilialCC', '$vuserOBS', '$tipo')";

	
	//print $vquery;
	
	//die;
	
if (mysqli_query($ligacao, $vquery)) {
    $vresposta = "<p align=\"left\">	Registro adicionado   &nbsp;&nbsp;|&nbsp;&nbsp; <a href=\"javascript:close();\">
	<img src=\"imagens/exit.jpg\" width=\"30\" height=\"32\" alt=\"voltar\"></a>
	<br /><br /><br />Powered by TI CCBR - version 1.0</p>";
} else {
    $vresposta = "Erro " . mysqli_error($ligacao);
}
mysqli_close($ligacao);
}



?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<title>ADD USER IOT</title>


</head>
<body>
    
<div id="corpogeralpop">
<!--<span class="margemE"><a href="menu.php?pag=users"><img src="imagens/voltar.jpg" width="45" height="39" alt="voltar"></a></span> -->
<h1>Adição de Registro Usuário</h1>
</p>


<form  action="" name="formulario2" method="post" id="formulario2">

<input type="hidden" name="id" value="<?php print $lista['id_user']; ?>">
  <p>

    <br>
	    User:
      <input name="user" value="<?php echo $lista['user']; ?>" size = "45" type="text"  id="user">
    <br>
    <br>
	    Password:
      <input name="password" value="" size = "45" type="password"  id="password"> <!-- Senha Atual: <?php //echo $lista['password']; ?> -->
    <br>
    <br>
  
    <p>Nome Completo:
      <input name="NomeCompleto" value="<?php echo $lista['NomeCompleto']; ?>" size = "54" type="text"  id="NomeCompleto">
      <br>
      <br>
    Filial Clear Channel:
    <!--<input name="filialCC" value="<?php print $lista['filialCC']; ?>" size = "53" type="text"  id="filialCC">-->
    
    <select name="filial" required>
	  <option value="" selected>Selecione</option>
  <option value="CCBRSP">São Paulo</option>
  <option value="CCBRDF">Brasilia</option>
  <option value="CCBRVT">Vitória</option>
  <option value="CCBRRJ">Rio de Janeiro</option>
  <option value="CCBRCP">Campinas</option>
    <option value="CCBRPA">Porto Alegre</option>
	  <option value="CCBRCB">Curitiba</option>
</select> 
    <br>
    <br>

	 	OBS do usuário:<br />

	<textarea name="userOBS" rows="5" cols="50"><?php print $lista['userOBS']; ?></textarea> Não Obrigatório
    <br>
    <br>

       <label for="usuario_tipo">Tipo de Usuário:</label><br>
        <select id="usuario_tipo" name="usuario_tipo">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>
 
    <input name="btn_add" type="submit" value="ADD Registro"> 
    &nbsp;&nbsp;&nbsp;&nbsp;
	
	<!-- ou
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Deletar Registro 
    <a href="javascript:confirma(<?php print $lista['id']?>)"><img src="imagens/apagar.jpg" width="16" height="16" alt="Apagar"></a></p>
-->

</form>

 

<p>
<?php
	// Fecha o  While
    
	

		
//	mysqli_close($ligacao);
	
	

   echo $vresposta;

	?>



</div></body>
</html>