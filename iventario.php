<?php
include("excel/conectaiven.php"); // Conexão com o banco de dados

// Consulta SQL para buscar os registros
$sql = "SELECT * FROM registros";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Registros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #343a40;
            margin-top: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        table th {
            background-color: #343a40;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .actions a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
            font-size: 14px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .no-data {
            text-align: center;
            color: #6c757d;
            padding: 20px;
        }
    </style>
</head>
<body>
    <h1>Lista de Registros</h1>
    <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Serial Number</th>
                        <th>Hostname</th>
                        <th>Assignment</th>
                        <th>Type</th>
                        <th>BU</th>
                        <th>Office</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Cost Center</th>
                        <th>Purchase Order</th>
                        <th>Purchase Date</th>
                        <th>Invoice Number</th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                        <th>Platform</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["id"]) ?></td>
                            <td><?= htmlspecialchars($row["serial_number"]) ?></td>
                            <td><?= htmlspecialchars($row["hostname"]) ?></td>
                            <td><?= htmlspecialchars($row["assignment"]) ?></td>
                            <td><?= htmlspecialchars($row["type"]) ?></td>
                            <td><?= htmlspecialchars($row["bu"]) ?></td>
                            <td><?= htmlspecialchars($row["office"]) ?></td>
                            <td><?= htmlspecialchars($row["project"]) ?></td>
                            <td><?= htmlspecialchars($row["status"]) ?></td>
                            <td><?= htmlspecialchars($row["cost_center"]) ?></td>
                            <td><?= htmlspecialchars($row["purchase_order"]) ?></td>
                            <td><?= htmlspecialchars($row["purchase_date"]) ?></td>
                            <td><?= htmlspecialchars($row["invoice_number"]) ?></td>
                            <td><?= htmlspecialchars($row["manufacturer"]) ?></td>
                            <td><?= htmlspecialchars($row["model"]) ?></td>
                            <td><?= htmlspecialchars($row["platform"]) ?></td>
                            <td class="actions">
                                <a href="editar.php?id=<?= $row["id"] ?>">Editar</a>
                                <a href="copiar.php?id=<?= $row["id"] ?>">Copiar</a>
                                <a href="remover.php?id=<?= $row["id"] ?>" onclick="return confirm('Tem certeza que deseja remover?')">Remover</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">Nenhum registro encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
