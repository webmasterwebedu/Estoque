
<?php
$servername = "localhost";
$database = "db-";
$username = "userdb";
$password = "senha-banco;

// Cria a conex達o
$ligacao = mysqli_connect($servername, $username, $password, $database);

// Verifica a conex達o
if (!$ligacao) {
    die("Connection failed: " . mysqli_connect_error());
}

// Configura a conex達o para usar UTF-8
mysqli_set_charset($ligacao, "utf8mb4");

// Teste de conex達o (opcional, pode ser removido)
// echo "Connected successfully";

?>

