if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file_tmp = $_FILES['csv_file']['tmp_name'];
    $file_name = $_FILES['csv_file']['name'];

    // Verificar se o arquivo é CSV
    if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv') {
        echo "Por favor, envie um arquivo CSV.";
        exit;
    }

    // Mover o arquivo para um diretório no servidor
    move_uploaded_file($file_tmp, "uploads/$file_name");
    echo "Arquivo enviado com sucesso!";
}
?>

<form action="" method="POST" enctype="multipart/form-data">
    Selecione o arquivo CSV: <input type="file" name="csv_file">
    <input type="submit" value="Enviar">
</form>


