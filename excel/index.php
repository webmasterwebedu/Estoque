<?php
require_once '../checa-login.php';
?>


<!DOCTYPE html>
<html lang="pt-br">
	<head>
	    
	    
	    
	    
		<meta charset="utf-8">
		<title>Importar dados do Excel</title>
	<head>
	<body>
	    
	    <img src="../imagens/logoclear.jpg"><br/><br/>
		<h1>Upload Excel</h1>

<form method="POST" action="processa.php" enctype="multipart/form-data">
    <label>Arquivo</label>
    <input type="file" name="arquivo" accept=".csv"><br><br>
    <input type="submit" value="Enviar">
</form>


<script>
    document.querySelector("form").addEventListener("submit", function (event) {
        const fileInput = document.querySelector("input[type='file']");
        const file = fileInput.files[0];

        if (file && file.name.split('.').pop().toLowerCase() !== "csv") {
            alert("Por favor, envie apenas arquivos .csv.");
            event.preventDefault(); // Cancela o envio do formulário
        }
    });
</script>

		
	</body>
</html>