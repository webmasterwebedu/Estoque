<?php ob_start();
session_start();
require_once 'checa-login.php';
require_once 'conecta.php';

$vresposta = "";


if (isset($_POST['btn_update'])){
	
	$vid = $_POST['id'];
	$vuser = $_POST['user'];
	$vvpassword = $_POST['password'];
	$vpassword = md5($vvpassword);
	
	$vNomeCompleto = $_POST['NomeCompleto'];
	$vfilialCC = $_POST['filialCC'];
	$vuserOBS = $_POST['userOBS'];
	$tipo = $_POST['usuario_tipo'];
		
	$vquery = "update api_user set
	user ='$vuser',
	password = '$vpassword',
	NomeCompleto = '$vNomeCompleto',
	filialCC = '$vfilialCC',
	userOBS = '$vuserOBS', 
	tipo = '$tipo' where id_user = $vid "; 
	
//	print $vquery;
	
//	die;
	
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
<title>Edit Registro Telefonico</title>


</head>
<body>
    
<div id="corpogeral">
<h1>Edição de Registro Usuário</h1>

<?php
	
$varid = $_GET['idurl'];

if (isset($varid)){
	    echo "";
	  
	  $vconsulta= "SELECT * FROM api_user where id_user=".$varid;
	  
	  	//echo $vconsulta;

		//die;
		
	  	
	  $sql = mysqli_query($ligacao, $vconsulta);

		while($lista = mysqli_fetch_array($sql)){
		
	print"<hr />"; 	
	


	?>

<h3>Edição de dados Usuário:</h3>
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
    <input name="filialCC" value="<?php print $lista['filialCC']; ?>" size = "53" type="text"  id="filialCC">
    <br>
    <br>

	 	OBS do usuário:<br />

	<textarea name="userOBS" rows="5" cols="50"><?php print $lista['userOBS']; ?></textarea> Não Obrigatório
    <br>
    <br>
    
    
     <label for="usuario_tipo">Tipo de Usuário:</label>&nbsp;&nbsp;
        <select id="usuario_tipo" name="usuario_tipo">
            <option value="user" <?php echo ($lista['tipo'] == 'user') ? 'selected' : ''; ?>>--- User ---</option>
            <option value="admin" <?php echo ($lista['tipo'] == 'admin') ? 'selected' : ''; ?>>--- Admin ---</option>
        </select><br><br>
 
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