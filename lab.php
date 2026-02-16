<?php ob_start();
session_start();
require_once 'conecta.php';

// Suponha que você tenha uma conexão aberta com o banco de dados $conn
// Sua query para buscar os dados das filiais
$query = "SELECT * FROM filiais";

$result = mysqli_query($ligacao, $query);

if ($result):
?>
    <!-- Começa o elemento select -->
    <select name="filial">
        <option value="000">Selecione</option>

        <?php
        // Loop pelo resultado da query para gerar as opções
        while ($row = mysqli_fetch_assoc($result)): 
        ?>
            <option value="<?php echo $row['filial']; ?>">
                <?php echo $row['nome_filial']; ?>
            </option>
        <?php endwhile; ?>
    </select>
<?php
else:  // Aqui o else precisa ser seguido de dois pontos
    echo "Erro na consulta: " . mysqli_error($ligacao);
endif;  // E finalizamos o bloco do if com endif;

// Fecha a conexão com o banco de dados
mysqli_close($ligacao);

?>