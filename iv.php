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



require_once 'excel/conecta-iv.php'; // Inclui a conexão com o banco de dados
require_once 'checa-login.php';

// Parâmetros de paginação
$registros_por_pagina = isset($_GET['registros_por_pagina']) ? intval($_GET['registros_por_pagina']) : 10;
$pagina_atual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($pagina_atual - 1) * $registros_por_pagina;

// Captura o termo de busca
$busca = isset($_GET['busca']) ? mysqli_real_escape_string($ligacao, $_GET['busca']) : '';

// Ajusta a consulta com base na busca
$filtro_busca = "";
if ($busca) {
    $filtro_busca = "WHERE type LIKE '%$busca%' 
                     OR bu LIKE '%$busca%' 
                     OR office LIKE '%$busca%' 
                     OR project LIKE '%$busca%' 
                     OR status LIKE '%$busca%' 
                     OR costcenter LIKE '%$busca%' 
                     OR manufacturer LIKE '%$busca%' 
                     OR domain LIKE '%$busca%'";
}

// Contar total de registros considerando a busca
$query_total = "SELECT COUNT(*) as total FROM registros $filtro_busca";
$resultado_total = mysqli_query($ligacao, $query_total);

if (!$resultado_total) {
    die("Erro ao contar registros: " . mysqli_error($ligacao));
}

$total_registros = mysqli_fetch_assoc($resultado_total)['total'];

// Buscar registros para a página atual com filtro
$query = "SELECT * FROM registros $filtro_busca LIMIT $offset, $registros_por_pagina";
$resultado = mysqli_query($ligacao, $query);

if (!$resultado) {
    die("Erro ao buscar registros: " . mysqli_error($ligacao) . "<br>Consulta: $query");
}

// Calcular total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginação - Showeb</title>
    
    <script language="javascript" type="text/javascript" src="janela.js"></script>
    
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        /table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #000;
        }
        table th {
            background-color: #007BFF;
            color: white;
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .pagination a {
            text-decoration: none;
            padding: 10px 15px;
            color: #007BFF;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
        }
        .pagination a.active {
            background-color: #007BFF;
            color: white;
            border-color: #007BFF;
        }
        .pagination a:hover {
            background-color: #0056b3;
            color: white;
        }
        .filter {
            margin-bottom: 20px;
        }
        .filter label {
            font-weight: bold;
            margin-right: 10px;
        }
        .filter select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>


    <div class="filter">
        <form method="get" action="">
            <label for="busca">Buscar:</label>
            <input 
                type="text" 
                name="busca" 
                id="busca" 
                value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>" 
                placeholder="Digite o termo de busca"
            >
            
            <label for="registros_por_pagina">Registros por página:</label>
            <select name="registros_por_pagina" id="registros_por_pagina">
                <option value="10" <?= $registros_por_pagina == 10 ? 'selected' : '' ?>>10</option>
                <option value="20" <?= $registros_por_pagina == 20 ? 'selected' : '' ?>>20</option>
                <option value="50" <?= $registros_por_pagina == 50 ? 'selected' : '' ?>>50</option>
                <option value="100" <?= $registros_por_pagina == 100 ? 'selected' : '' ?>>100</option>
            </select>
            
            <button type="submit">Filtrar</button>
            <input type="hidden" name="pagina" value="<?= $pagina_atual ?>">
            <input type="hidden" name="pag" value="iventario">
            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print "User: ".$_SESSION['username']; ?></strong>
        </form>
      </div>

    <table>
        <thead>
            <tr>
                <th></th>
                <th>Type</th>
                <th>Hostname</th>
                <th>Office</th>
                <th>Project</th>
                <th>Status</th>
                <th>Cost Center</th>
                <th>Manufacturer</th>
                <th>Domain</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultado) > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($resultado)) : ?>
                    <tr>
                   
                        <td  align="center"><a href="javascript:OpenUp('edit-ativo.php?id=<?php print $row['id'];?>',970,600);"><img src="imagens/lapis.png" alt="editar" width="30" height="30"></a></td>
                        <td><?= htmlspecialchars($row['type']) ?></td>
                        <td><?= htmlspecialchars($row['hostname']) ?></td>
                        <td><?= htmlspecialchars($row['office']) ?></td>
                        <td><?= htmlspecialchars($row['project']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= htmlspecialchars($row['costcenter']) ?></td>
                        <td><?= htmlspecialchars($row['manufacturer']) ?></td>
                        <td><?= htmlspecialchars($row['domain']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="9">Nenhum registro encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
            <a href="?pagina=<?= $i ?>&registros_por_pagina=<?= $registros_por_pagina ?>&busca=<?= urlencode($busca) ?>&pag=iventario" 
               class="<?= $i == $pagina_atual ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</body>
</html>
