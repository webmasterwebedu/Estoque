<?php 
ob_start();
session_start();
require_once 'excel/conecta-iv.php'; // Inclui a conexão com o banco de dados
require_once 'checa-login.php';


// Verifica se o ID foi passado via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Busca o registro no banco de dados
    $query = "SELECT * FROM registros WHERE id = $id";
    $result = mysqli_query($ligacao, $query);

    // Se o ID existir, carrega os dados
    if ($row = mysqli_fetch_assoc($result)) {
        $serial = $row['serial'];
        $hostname = $row['hostname'];
        $assignment = $row['assignment'];
        $type = $row['type'];
        $bu = $row['bu'];
        $office = $row['office'];
        $project = $row['project'];
        $status = $row['status'];
        $costcenter = $row['costcenter'];
        $purchaseorder = $row['purchaseorder'];
        $purchasedate = $row['purchasedate'];
        $InvoiceNumber = $row['InvoiceNumber'];
        $InvoiceSupplier = $row['1InvoiceSupplier'];
        $manufacturer = $row['manufacturer'];
        $model = $row['model'];
        $modelcommonname = $row['modelcommonname'];
        $plataform = $row['plataform'];
        $osversion = $row['osversion'];
        $osbiuld = $row['osbiuld'];
        $ip = $row['ip'];
        $ip2 = $row['ip2'];
        $domain = $row['domain'];
        $macaddress = $row['2macaddress'];
        $macaddress2 = $row['macaddress2'];
        $aux = $row['aux'];
        $aux2 = $row['aux2'];
    } else {
        echo "Registro não encontrado.";
        exit;
    }
} else {
    echo "ID inválido.";
    exit;
}

// Se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $serial = $_POST['serial'];
    $hostname = $_POST['hostname'];
    $assignment = $_POST['assignment'];
    $type = $_POST['type'];
    $bu = $_POST['bu'];
    $office = $_POST['office'];
    $project = $_POST['project'];
    $status = $_POST['status'];
    $costcenter = $_POST['costcenter'];
    $purchaseorder = $_POST['purchaseorder'];
    $purchasedate = $_POST['purchasedate'];
    $InvoiceNumber = $_POST['InvoiceNumber'];
    $InvoiceSupplier = $_POST['InvoiceSupplier'];
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];
    $modelcommonname = $_POST['modelcommonname'];
    $plataform = $_POST['plataform'];
    $osversion = $_POST['osversion'];
    $osbiuld = $_POST['osbiuld'];
    $ip = $_POST['ip'];
    $ip2 = $_POST['ip2'];
    $domain = $_POST['domain'];
    $macaddress = $_POST['macaddress'];
    $macaddress2 = $_POST['macaddress2'];
    $aux = $_POST['aux'];
    $aux2 = $_POST['aux2'];

    // Atualiza o registro no banco de dados

        
        $update = "UPDATE registros SET 
    serial='$serial', hostname='$hostname', assignment='$assignment', type='$type',
    bu='$bu', office='$office', project='$project', status='$status', costcenter='$costcenter',
    purchaseorder='$purchaseorder', purchasedate='$purchasedate', InvoiceNumber='$InvoiceNumber',
    `InvoiceSupplier`='$InvoiceSupplier', manufacturer='$manufacturer', model='$model',
    modelcommonname='$modelcommonname', plataform='$plataform', osversion='$osversion',
    osbiuld='$osbiuld', ip='$ip', ip2='$ip2', domain='$domain', 
    `macaddress`='$macaddress', macaddress2='$macaddress2', aux='$aux', aux2='$aux2'
    WHERE id = $id";


    if (mysqli_query($ligacao, $update)) {
       $aviso = "<strong>Registro Atualizado com sucesso</strong>";
    } else {
        echo "Erro ao atualizar: " . mysqli_error($ligacao);
    }
}

mysqli_close($ligacao);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
</head>
<body>
        <h2>Editar Registro de Ativo</h2>
        
        
    <form method="POST">
        
<table>
        <tr>
            <th>Serial</th>
            <td><input type="text" name="serial" value="<?= $serial ?>" required></td>

            <th>Hostname</th>
            <td><input type="text" name="hostname" value="<?= $hostname ?>" required></td>

            <th>Assignment</th>
            <td><input type="text" name="assignment" value="<?= $assignment ?>"></td>
        </tr>
        <tr>
            <th>Type</th>
            <td><input type="text" name="type" value="<?= $type ?>"></td>

            <th>BU</th>
            <td><input type="text" name="bu" value="<?= $bu ?>"></td>

            <th>Office</th>
            <td><input type="text" name="office" value="<?= $office ?>"></td>
        </tr>
        <tr>
            <th>Project</th>
            <td><input type="text" name="project" value="<?= $project ?>"></td>

            <th>Status</th>
            <td><input type="text" name="status" value="<?= $status ?>"></td>

            <th>Cost Center</th>
            <td><input type="text" name="costcenter" value="<?= $costcenter ?>"></td>
        </tr>
        <tr>
            <th>Model Name </th>
            <td><input type="text" name="modelcommonname" value="<?= $modelcommonname ?>"></td>

            <th>Platform</th>
            <td><input type="text" name="plataform" value="<?= $plataform ?>"></td>

            <th>OS Version</th>
            <td><input type="text" name="osversion" value="<?= $osversion ?>"></td>
        </tr>
        <tr>
            <th>Model</th>
            <td><input type="text" name="model" value="<?= $model ?>"></td>

            <th>Purchase Order</th>
            <td><input type="text" name="purchaseorder" value="<?= $purchaseorder ?>"></td>

            <th>Purchase Date</th>
            <td><input type="text" name="purchasedate" value="<?= $purchasedate ?>"></td>
        </tr>
        <tr>
            <th>Invoice Number</th>
            <td><input type="text" name="InvoiceNumber" value="<?= $InvoiceNumber ?>"></td>

            <th>OS Build</th>
            <td><input type="text" name="osbiuld" value="<?= $osbiuld ?>"></td>

            <th>Invoice Supplier</th>
            <td><input type="text" name="InvoiceSupplier" value="<?= $InvoiceSupplier ?>"></td>
        </tr>
        <tr>
            <th>Manufacturer</th>
            <td><input type="text" name="manufacturer" value="<?= $manufacturer ?>"></td>

            <th>IP</th>
            <td><input type="text" name="ip" value="<?= $ip ?>"></td>

            <th>IP2</th>
            <td><input type="text" name="ip2" value="<?= $ip2 ?>"></td>
        </tr>
        <tr>
            <th>MAC Address</th>
            <td><input type="text" name="macaddress" value="<?= $macaddress ?>"></td>

            <th>MAC Address 2</th>
            <td><input type="text" name="macaddress2" value="<?= $macaddress2 ?>"></td>

            <th>Domain</th>
            <td><input type="text" name="domain" value="<?= $domain ?>"></td>
        </tr>
        <tr>
            <th>AUX</th>
            <td><input type="text" name="aux" value="<?= $aux ?>"></td>

            <th>AUX2</th>
            <td><input type="text" name="aux2" value="<?= $aux2 ?>"></td>
        </tr>
    </table>
    <br><br><br>
                <button type="submit">Salvar Alterações</button>

     
    </form>
    <p align="center"><? print $aviso ?></p>
</body>
</html>
