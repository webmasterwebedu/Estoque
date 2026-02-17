<?php ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'checa-login.php';
require_once 'conecta.php';

if(isset($_GET['apaga_id'])){
$vconsulta = "delete from api_user  where id_user=".$_GET['apaga_id'];
mysqli_query($ligacao, $vconsulta);
mysqli_close($ligacao);
header("Location: menu.php?pag=users");

//print "<script>close();</script>";

}

if($_SESSION['tipouser']!='admin'){
    print "<br /><br />Conta User acesso negado.";
    die;
}
    

$tipo = $_GET['tipo'];// verifdica o tipo de indice para query abaixo.
$varOrdem = $_GET['ordem'];
$varTXT = $_GET['palavra'];
$varRegistros = $_GET['registros'];
$_SESSION['linhas']== $_GET['linhas'];

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<title>Admin Users</title>

<script>

function confirma(objPar) {
    if (confirm("Confirm delete?")) {
        window.location = "admin_users.php?apaga_id=" + objPar;
    }
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
<div id="addproduto"><br />
<strong></strong><a href="javascript:OpenUp('add-user.php',770,550);">Add User</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="menu-user.php?pag=users">Atualizar</a></p>
</div>
<div id="topo2">

<br />
   
   <form name="form1" action="" method="GET">
Ordenar : 
<select name="tipo" id="tipo">
  <!-- <option value="">--- Selecione Aqui ---</option> -->
  <option value="id_user">id_user</option>
  <option value="user">User</option>
</select>

<select name="ordem" id="ordem">
  <option value="ASC">--- A -> Z  ---</option>
    <option value="DESC">--- Z -> A ---</option>
</select>  
<input type="hidden" name="pag" value="users">
   <input name="btnEnviar" type="submit" value="submit">&nbsp;&nbsp;&nbsp;Index type:&nbsp;<?php print $tipo;?>&nbsp;&nbsp;Order:&nbsp;<?php print $varOrdem ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Number of Lines:<input type="text" name="registros" size="2" value="50" /> 
    	</form><br />
		<form name="form2" method="GET">Buscar :
		<input type="text" name="palavra" value="<?php print $varTXT; ?>" />
		<input type="hidden" name="pag" value="users">
		<input name="Buscar"  value="Submit" type="submit" />
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Number of Lines :<input type="text" name="registros" size="2" value="50" /> 
		</form> <br />
</div> 
</div>
<br /><br /><br /><br /><br /><br /><br /><br />
<table border="1" class="display" cellspacing="0" style="width:80%">
        <tr>
        <?php
    if($_SESSION['tipouser'] == 'admin') {
      print'<td  align="center" width="30" class="tdtopo"><strong>Action</strong></td>';
        } ?>
	  <td  align="center" width="30" class="tdtopo"><strong>ID</strong></td>
	  <td  align="center" width="90" class="tdtopo"><strong>Usuário</strong></td> 
	   <td  align="center" width="350" class="tdtopo"><strong>Nome Completo</strong></td> 
	    <td  align="center" width="130" class="tdtopo"><strong>Filial CC</strong></td> 
	    <td  align="center" width="130" class="tdtopo"><strong>Tipo</strong></td>
	    		 <?php
			  if($_SESSION['tipouser']=='admin'){
			  print '<td  align="center" width="20" class="tdtopo"><strong>Delete</strong></td>';
			  } ?>
			  
	  </tr>
	  
	  <?php
	
		  if(isset($tipo)){
			  $varQuery = "SELECT *  FROM api_user  order by ".$tipo." ".$varOrdem." LIMIT ".$varRegistros;
			  
		 }else if(isset($varTXT)){
					  
		 $varQuery = "SELECT * FROM api_user where user like '%".$varTXT."%' order by id_user asc  LIMIT ".$varRegistros;
		}else{
			
			$varQuery = "SELECT * FROM api_user order by id_user LIMIT 50 ";
			
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
        print '<td align="center"><a href="javascript:OpenUp(\'edit-user.php?idurl=' . $row['id_user'] . '\',770,550);"><img src="imagens/lapis.png" alt="editar" width="30" height="30"></a></td>';
    }
    ?>


			<td  align="center" height="35"><?php  print $row['id_user']; ?></td>
	  <td><?php  print $row['user']; ?></td>
	  	   <td  align="center"><?php  print $row['NomeCompleto']; ?></td> 
	    <td  align="center"><?php  print $row['filialCC']; ?></td> 
	     <td  align="center"><?php  print $row['tipo']; ?></td> 
            
            <?php
            
			  if($_SESSION['tipouser']=='admin'){
			  print' <td align="center"><a href="javascript:confirma('. $row['id_user'].')"><img src="imagens/apagar.jpg"></a></td>';
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