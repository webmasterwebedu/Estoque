<?php
ob_start();
session_start();
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

require_once 'conecta.php';

/*
if( isset($_POST['bt_login'])) {
         $username = $_POST['username'];
         $password = $_POST['password'];
		 
	if(($username=='user') and ($password =='senha')){
		$_SESSION['username'] = $username;
			
	}else {
	header('location: index.php?erro=2');	
	}
	
	
}

*/

if (isset($_POST['bt_login'])) {
    //$username = $_POST['username'];
    //$passwordStr = $_POST['password'];
    
    $username = mysqli_real_escape_string($ligacao, $_POST['username']);
    
    $passwordStr = mysqli_real_escape_string($ligacao, $_POST['password']);
    
    
	
	$password = md5($passwordStr);

    // Preparar a consulta
    $query = "SELECT * FROM api_user WHERE user = '$username'  AND password = '$password'";
	
  // print $query;
  // die;
	
$resultado = mysqli_query($ligacao, $query);

    // Verificar se as credenciais são válidas
    if (mysqli_num_rows($resultado) > 0) {
        $_SESSION['username'] = $username;
        
		
		    $row = mysqli_fetch_assoc($resultado);
    $id_user = $row['id_user'];
    $tipouser = $row['tipo'];

    // Armazenar o ID do usuário na sessão
    $_SESSION['id_user'] = $id_user;
    $_SESSION['tipouser']=  $tipouser;
		
        header('location: menuprincipal.php'); // Página após o login bem-sucedido
        exit;
    } else {
        header('location: index.php?erro=2');
        exit;
    }
}

		//mysqli_close($ligacao); // Fechar a conexão com o banco de dados
		//    ===========mais nao usar aqui =========


require_once 'checa-login.php';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<title>CLEAR CHANNEL - Estoque</title>
<script language="javascript" type="text/javascript" src="janela.js"></script> 

</head>
<body>

<div align="center"><img src="imagens/logoclear.jpg" width="453" height="55" alt="Clear Channel" class="imagem-com-sombra">&nbsp;&nbsp;&nbsp; <strong>Usu&aacute;rio :  <?php  print $_SESSION['tipouser']; ?>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <a href="javascript:OpenUp('/estoque/trocar_senha.php',770,550);"> Alterar senha </a><strong>
<br /><br /><br /><br />
<table width="100%"  border="1" class="tdtopotab">
  <tr>
    <td width="100" align="center"><a href="menu-user.php?pag=users"><h4>Admin de </h4></a><?php // print $_SESSION['tipouser']; ?></td>
    <td width="100" align="center"><a href="menu.php?pag=estoque"><h4>Estoque</h4></a></td>
	<!--	<td width="100" align="center"><a href="menu-iventario.php?pag=iventario"><h4>Inventário</h4></a></td> -->
	<td width="100" align="center"><a href="/estoque"><h4></h4><img src="imagens/exit.jpg" width="64" height="60" alt=""></a> 
	<!--
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="ajuda"><a href="javascript:alert('If you have a problem, question, or suggestion, please raise a ticket at: \n\n techservicedesk@clearchannel.com.br');"><img src="/imagens/ajuda.png" width="30" height="30" alt="Ajuda"></a></span>
	 -->
	 
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="mostrarDivLink"><img src="imagens/ajuda.png" width="30" height="30" alt="Ajuda"></a>
	

    <div id="minhaDiv">
	<img src="imagens/clear-logo.jpg"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="fecharDivLink"><img src="imagens/apagar.jpg"></a><br />
			<br />
			&nbsp;&nbsp;If you have a problem or question, please raise a ticket:
				<br /><br /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="mailto:techservicedesk@clearchannel.com.br">
			<img src="imagens/ajuda.png"></a><br /><br />
			    
			
    </div>

    
    </div>
<script>
    // Obtém os elementos do DOM
    var mostrarDivLink = document.getElementById("mostrarDivLink");
    var fecharDivLink = document.getElementById("fecharDivLink");
    var minhaDiv = document.getElementById("minhaDiv");

    // Adiciona um evento de clique para mostrar a div
    mostrarDivLink.addEventListener("click", function() {
        minhaDiv.style.display = "block";
        event.preventDefault(); // Impede o link de navegar para outra página
    });

    // Adiciona um evento de clique para fechar a div
    fecharDivLink.addEventListener("click", function() {
        minhaDiv.style.display = "none";
        event.preventDefault(); // Impede o link de navegar para outra página
    });

    // Adiciona um evento de escuta para a tecla "Esc" para fechar a div
    document.addEventListener("keydown", function(event) {
        if (event.key === "Escape" && minhaDiv.style.display === "block") {
            minhaDiv.style.display = "none";
        }
    });
</script>

  </td></tr>
  <!--
    <tr>
    <td width="100"><h3 align="center">&nbsp;Admin Users</h3></a></td>
	  <td width="100"><h3 align="center">&nbsp;Lista de estoque</h3></a></td>
	    <td width="100"><h3 align="center">&nbsp;Lista de Empresas</h3></a></td>
    <td width="100"><h3 align="center">&nbsp;Entradas e Saidas</h3></a></td>
    <td width="100"><h3 align="center">&nbsp;Iventário</h3></a></td>
	<td width="100"> <h3 align="center"> <?php print "&nbsp;User: ".$_SESSION['username']; ?></h3></strong></a></td>

    </tr> -->
	<table>
	
	</table>
		<tr>
	<td colspan="5">&nbsp; <td>
	</tr>
	<tr>
	<td colspan="5">   
	
	<?php
	
if (isset($_GET['pag'])) {
    $pagPHP = $_GET['pag'];

    switch ($pagPHP) {
        case 'users':
            include 'admin_users.php';
            break;

        case 'mac':
            include 'admin_mac.php';
            break;

	     case 'estoque';
	        include'lista_estoque.php';
	        break;
	
	        case 'entrada-saida';
	        include'entradas-saidas.php';
	        break;
	        
	        case 'lista-empresas';
            include'lista-empresas.php';
            break;
            
            case 'iventario';
            include'iv.php';
            break;
            
            include 'admin_users.php';
            default:
    }
}// else {
//    include 'admin_users.php'; // Se 'pag' não estiver definido, inclua o arquivo padrão
//}
?>
	</td>
	</tr>

</table>


<br /><br />
<?php
//print "senha:   <strong>".$password." </strong> <br /><br /> Senha em  MD5 : <strong>".md5($password)."</strong>  <br />";
?>
</div>
</body>
</html>
