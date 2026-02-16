<?php


// Conexão com o banco de dados
$servername = "localhost";
$username = "user";
$password = "senha";
$dbname = "db-name";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}



?>
