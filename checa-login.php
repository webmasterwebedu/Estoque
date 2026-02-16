<?php
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se a sessão está definida e não vazia
if (!isset($_SESSION['username']) || $_SESSION['username'] === '') {
    header("Location: index.php?erro=1");
    exit(); // <- Importante para interromper o script após redirecionamento
}
?>