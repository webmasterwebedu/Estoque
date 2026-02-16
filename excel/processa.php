<?php
include_once("conecta-iv.php");

// Verifica se um arquivo foi enviado
if (!empty($_FILES['arquivo']['tmp_name'])) {
    $arquivoTemp = $_FILES['arquivo']['tmp_name'];
    
    // Lê o conteúdo do arquivo e converte para UTF-8
    $dados_arquivo = file_get_contents($arquivoTemp); // Lê todo o conteúdo do arquivo
    $dados_arquivo = mb_convert_encoding($dados_arquivo, "UTF-8", "ISO-8859-1"); // Converte para UTF-8

    // Salva o conteúdo convertido em um arquivo temporário
    $arquivoTempConvertido = tempnam(sys_get_temp_dir(), 'csv');
    file_put_contents($arquivoTempConvertido, $dados_arquivo);

    // Abre o arquivo convertido para leitura
    if (($handle = fopen($arquivoTempConvertido, "r")) !== false) {
        $linha_atual = 0; // Controle de linhas iniciando na 0

        // Percorre cada linha do arquivo
        while (($dados = fgetcsv($handle, 1000, ";")) !== false) { // Usando ";" como delimitador
            $linha_atual++;

            // Ignora a primeira linha (cabeçalho)
            if ($linha_atual === 1) {
                continue;
            }

            // Lê os dados de cada coluna
            $serial = mysqli_real_escape_string($ligacao, $dados[0]);
            $hostname = mysqli_real_escape_string($ligacao, $dados[1]);
            $assignment = mysqli_real_escape_string($ligacao, $dados[2]);
            $type = mysqli_real_escape_string($ligacao, $dados[3]);
            $bu = mysqli_real_escape_string($ligacao, $dados[4]);
            $office = mysqli_real_escape_string($ligacao, $dados[5]);
            $project = mysqli_real_escape_string($ligacao, $dados[6]);
            $status = mysqli_real_escape_string($ligacao, $dados[7]);
            $costcenter = mysqli_real_escape_string($ligacao, $dados[8]);
            $purchaseorder = mysqli_real_escape_string($ligacao, $dados[9]);
            $purchasedate = mysqli_real_escape_string($ligacao, $dados[10]);
            $InvoiceNumber = mysqli_real_escape_string($ligacao, $dados[11]);
            $InvoiceSupplier = mysqli_real_escape_string($ligacao, $dados[12]);
            $manufacturer = mysqli_real_escape_string($ligacao, $dados[13]);
            $model = mysqli_real_escape_string($ligacao, $dados[14]);
            $modelcommonname = mysqli_real_escape_string($ligacao, $dados[15]);
            $plataform = mysqli_real_escape_string($ligacao, $dados[16]);
            $osversion = mysqli_real_escape_string($ligacao, $dados[17]);
            $osbiuld = mysqli_real_escape_string($ligacao, $dados[18]);
            $ip= mysqli_real_escape_string($ligacao, $dados[19]);
            $ip2 = mysqli_real_escape_string($ligacao, $dados[20]);
            $domain = mysqli_real_escape_string($ligacao, $dados[21]);
            $macaddress = mysqli_real_escape_string($ligacao, $dados[22]);
            $macaddress2 = mysqli_real_escape_string($ligacao, $dados[23]);
            $aux = mysqli_real_escape_string($ligacao, $dados[24]);
            $aux2 = mysqli_real_escape_string($ligacao, $dados[25]);
            
            
            // Exibe os dados (apenas para depuração)
            echo "Serial: $serial <br>";
            echo "Hostname: $hostname <br>";
            echo "assingment: $assignment <br>";
            echo "Type: $type <br>";
            echo "BU: $bu <br>";
            echo "Office: $office <br>";
            echo "Project: $project <br>";
            echo "Status: $status <br>";
            echo "Cost Center: $costcenter <br>";
            echo "Purchase order: $purchaseorder <br>";
            echo "Purchasedate:  $purchasedate <br>";
            echo "InvoiceNumber: $InvoiceNumber <br>";
            echo "Manufacturer: $manufacturer <br>";
            echo "Model: $model <br>";
            echo "Modelcommonname: $modelcommonname <br>";
            echo "Plataform: $plataform <br>";
            echo "Osversion: $osversion <br>";
            echo "Osbiuld: $osbiuld <br>";
            echo "IP: $ip <br>";
            echo "IP2: $ip2 <br>";
            echo "Domain: $domain <br>";
            echo "macaddress: $macaddress  <br>";
            echo "macaddress2: $macaddress2  <br>";
            echo "aux: $aux:  <br>";
            echo "aux2: $aux2:  <br>";
            
            echo "<hr>";

            // Insere os dados na tabela do banco de dados
            //$sql = "INSERT INTO registros (serial, hostname, assignment , type, bu, office, project, status, costcenter, costcenter , purchaseorder, purchasedate,  manufacturer, InvoiceNumber, InvoiceSupplier,  plataform, manufacturer,  model, modelcommonname , plataform , osversion , osbiuld , ip , ip2 , domain, macaddress , macaddress2 , aux, aux2) 
            //        VALUES ('$serial', '$hostname' ,'$assignment' , '$type', '$bu', '$office', '$project', '$status', '$costcenter','$purchaseorder' , '$purchasedate', '$manufacturer', '	$InvoiceNumber' , '$InvoiceSupplier', '$modelcommonname', '$plataform' , '$manufacturer', '$model', '$modelcommonname', '$plataform', '$osversion', '$osbiuld', '$ip', '$ip2', '$domain', '$macaddress', '$macaddress2', '$aux', '$aux2')";
             $sql = "INSERT INTO registros (serial, hostname, assignment, type, bu, office, project, status, costcenter, purchaseorder, purchasedate, manufacturer, InvoiceNumber, InvoiceSupplier, plataform, model, modelcommonname, osversion, osbiuld, ip, ip2, domain, macaddress, macaddress2, aux, aux2) 
        VALUES ('$serial', '$hostname', '$assignment', '$type', '$bu', '$office', '$project', '$status', '$costcenter', '$purchaseorder', '$purchasedate', '$manufacturer', '$InvoiceNumber', '$InvoiceSupplier', '$plataform', '$model', '$modelcommonname', '$osversion', '$osbiuld', '$ip', '$ip2', '$domain', '$macaddress', '$macaddress2', '$aux', '$aux2')";
      
                    //print $sql;

            $resultado = mysqli_query($ligacao, $sql);

            if (!$resultado) {
                echo "Erro ao inserir registro: " . mysqli_error($ligacao) . "<br>";
            }
        }

        // Fecha o arquivo
        fclose($handle);

        // Remove o arquivo temporário
        unlink($arquivoTempConvertido);

        echo "Importação concluída!";
    } else {
        echo "Erro ao abrir o arquivo.";
    }
} else {
    echo "Nenhum arquivo foi enviado.";
}
?>
