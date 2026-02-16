<?php ob_start();
session_start();
require_once 'checa-login.php';
require_once 'conecta.php';

$vresposta = "";

// Exibe todos os erros
error_reporting(E_ALL);

// Ativa a exibição dos erros
ini_set('display_errors', 1);

// Opcional: Ativa a exibição de startup errors (erros que ocorrem durante a inicialização do PHP)
ini_set('display_startup_errors', 1);




if (isset($_POST['btn_add'])){
	
		$vfilial = $_POST['filial'];
   $vnome_filial = $_POST['nome_filial'];

	
				//Comando SQL INSERT INTO
$vquery = "INSERT INTO filiais (filial, nome_filial) VALUES ('$vfilial', '$vnome_filial')";

	// print $vquery;
		// die;
		
		
		if(mysqli_query($ligacao, $vquery)) {
    
        echo "Novo registro inserido com sucesso!";
        echo "<script>javascript:window.close();</script>";
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
<h1>Adição de Empresa - CCBR </h1>
</p>


<form  action="" name="formulario2" method="post" id="formulario2">


  <p>

    <br>
	    Filial:
      <input name="filial" value="" size = "45" type="text"  id="filial">
    <br>
    <br>
	    Nome Filial:
      <input name="nome_filial" value="" size = "45" type="text"  id="nome_filial">
    <br>
    <br>
  
 
    <input name="btn_add" type="submit" value="ADD Registro"> 
    &nbsp;&nbsp;&nbsp;&nbsp;
	

</form>

 

<p>
<?php
	// Fecha o  While
    
	

		
//	mysqli_close($ligacao);
	
	

   echo $vresposta;

	?>



</div></body>
</html>
			