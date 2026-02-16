<?php
// Inicia a sessão para acessar informações do usuário logado e mensagens
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclui o arquivo de conexão com o banco de dados
require_once 'conecta.php'; // Certifique-se de que este caminho está correto

// Inclui a checagem de login para proteger a página
require_once 'checa-login.php'; // Garante que apenas usuários logados acessem

$mensagem = '';
$mensagem_tipo = ''; // 'sucesso' ou 'erro'

// Obtém o nome de usuário da sessão
$username_logado = $_SESSION['username'] ?? null;

// Verifica se o username_logado está disponível na sessão
if (!$username_logado) {
    // Se não estiver logado ou o username não estiver na sessão, redireciona ou exibe erro
    // É uma boa prática redirecionar para a página de login neste caso
    header("Location: login.php"); // Altere para o seu arquivo de login
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Receber e sanitizar as entradas do usuário
    $senha_atual_digitada = $_POST['senha_atual'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar_nova_senha = $_POST['confirmar_nova_senha'] ?? '';

    // 2. Validação básica das senhas
    if (empty($senha_atual_digitada) || empty($nova_senha) || empty($confirmar_nova_senha)) {
        $mensagem = 'Todos os campos so obrigatórios.';
        $mensagem_tipo = 'erro';
    } elseif ($nova_senha !== $confirmar_nova_senha) {
        $mensagem = 'A novas senhas de confirmação nao coincidem.';
        $mensagem_tipo = 'erro';
    } elseif (strlen($nova_senha) < 6) { // Exemplo: Nova senha deve ter no mínimo 6 caracteres
        $mensagem = 'A nova senha deve ter pelo menos 6 caracteres.';
        $mensagem_tipo = 'erro';
    } else {
        // 3. Consultar a senha MD5 atual do usuário no banco de dados, usando o username
        $sql_consulta_senha_atual = "SELECT password FROM api_user WHERE user = ?";
        if ($stmt = mysqli_prepare($ligacao, $sql_consulta_senha_atual)) {
            mysqli_stmt_bind_param($stmt, "s", $username_logado); // 's' para string (username)
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $senha_md5_armazenada);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            // Verificar se o usuário foi encontrado e se há uma senha armazenada
            if (empty($senha_md5_armazenada)) {
                $mensagem = 'Usuário não encontrado ou senha não definida no sistema.';
                $mensagem_tipo = 'erro';
            }
            // 4. Comparar a senha atual digitada com a senha MD5 armazenada
            // ATENÇÃO: Comparar MD5 é INSEGURO. Considere migrar para password_hash().
            else if (md5($senha_atual_digitada) === $senha_md5_armazenada) {
                // Senha atual correta, agora atualiza para a nova senha (em MD5)
                $nova_senha_md5 = md5($nova_senha); // ATENÇÃO: Continuamos usando MD5 aqui conforme seu requisito.

                $sql_atualiza_senha = "UPDATE api_user SET password = ? WHERE user = ?";
                if ($stmt_update = mysqli_prepare($ligacao, $sql_atualiza_senha)) {
                    mysqli_stmt_bind_param($stmt_update, "ss", $nova_senha_md5, $username_logado); // 'ss' para duas strings
                    if (mysqli_stmt_execute($stmt_update)) {
                        $mensagem = 'Senha alterada com sucesso!';
                        $mensagem_tipo = 'sucesso';
                    } else {
                        $mensagem = 'Erro ao atualizar a senha: ' . mysqli_error($ligacao);
                        $mensagem_tipo = 'erro';
                    }
                    mysqli_stmt_close($stmt_update);
                } else {
                    $mensagem = 'Erro na prepara&ccedil;&atilde;o da atualiza&ccedil;&atilde;o da senha:' . mysqli_error($ligacao);
                    $mensagem_tipo = 'erro';
                }
            } else {
                $mensagem = 'Senha atual incorreta.';
                $mensagem_tipo = 'erro';
            }
        } else {
            $mensagem = 'Erro na prepara&ccedil;&atilde;o da consulta da senha atual: ' . mysqli_error($ligacao);
            $mensagem_tipo = 'erro';
        }
    }
    // Fechar a conexão com o banco de dados
    mysqli_close($ligacao);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trocar Senha</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"> <style>
        /* Estilos básicos para o formulário, adicione ao seu estilo.css se preferir */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 500px;
            margin: 20px auto; /* Ajustado para melhor centralização vertical */
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            background-color: #fff;
        }
        .header-info {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .header-info h2 {
            margin-top: 0;
            color: #333;
            font-size: 2em;
        }
        .header-info p {
            color: #555;
            font-size: 1.1em;
            margin-bottom: 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }
        .form-group input[type="password"] {
            width: calc(100% - 22px); /* Ajuste para borda e padding */
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box; /* Inclui padding e borda na largura total */
            font-size: 1em;
        }
        .btn {
            background-color: #007bff; /* Azul padrão de botão */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 100%; /* Botão em largura total */
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
        }
        .message.sucesso {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-info">
            <h2>Trocar Senha</h2>
            <p>Usu&aacute;rio Logado: <strong><?php echo htmlspecialchars($username_logado); ?></strong></p>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="message <?php echo $mensagem_tipo; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <form action="trocar_senha.php" method="POST">
            <div class="form-group">
                <label for="senha_atual">Senha Atual:</label>
                <input type="password" id="senha_atual" name="senha_atual" required>
            </div>
            <div class="form-group">
                <label for="nova_senha">Nova Senha:</label>
                <input type="password" id="nova_senha" name="nova_senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar_nova_senha">Confirmar Nova Senha:</label>
                <input type="password" id="confirmar_nova_senha" name="confirmar_nova_senha" required>
            </div>
            <button type="submit" class="btn">Alterar Senha</button>
        </form>
    </div>
</body>
</html>