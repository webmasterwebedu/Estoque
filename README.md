# Sistema de Estoque (PHP + MySQL)

Aplicacao web para controle de estoque interno, com login, gestao de usuarios, movimentacao de entrada/saida e consulta por filial.

## Visao geral

Este projeto foi construido em PHP procedural, usando MySQL como banco de dados e interface HTML/CSS/JS simples.

Principais modulos:
- Autenticacao de usuarios (`index.php`, `menuprincipal.php`, `checa-login.php`)
- Administracao de usuarios (`admin_users.php`, `add-user.php`, `edit-user.php`)
- Controle de estoque (`lista_estoque.php`, `add_produto.php`, `edit-produto.php`)
- Historico de movimentacoes (`entradas-saidas.php`, tabela `entra_sai`)
- Alteracao de senha (`trocar_senha.php`)
- Importacao CSV para inventario (`excel/index.php`, `excel/processa.php`)

## Tecnologias

- PHP (mysqli)
- MySQL
- HTML/CSS
- JavaScript basico

## Estrutura do projeto

- `index.php`: tela de login
- `menuprincipal.php`: tela principal apos login
- `menu.php`: navegacao entre modulos do sistema
- `conecta.php`: conexao principal com banco
- `bd.sql`: script SQL base (estrutura + dados iniciais)
- `css/`: estilos
- `imagens/`: assets da interface
- `excel/`: upload/importacao de CSV do inventario

## Requisitos

- PHP 8.x (ou 7.4+)
- MySQL 8.x (ou compativel)
- Servidor web local (Apache/Nginx ou stack como XAMPP/WAMP)

## Como rodar localmente

1. Clone ou copie os arquivos para seu servidor PHP local.
2. Crie o banco no MySQL.
3. Importe o script `bd.sql`.
4. Configure credenciais de banco em:
   - `conecta.php`
   - `conectaiven.php` (se usar modulo de inventario separado)
   - `excel/conecta-iv.php` (modulo de importacao CSV)
5. Acesse no navegador:
   - `http://localhost/estoque/`

## Configuracao do banco

Exemplo de ajuste em `conecta.php`:

```php
$servername = "localhost";
$database = "nome_do_banco";
$username = "usuario";
$password = "senha";
```

O arquivo `bd.sql` inclui tabelas principais como:
- `api_user`
- `estoque`
- `entra_sai`
- `filiais`
- `movimentacoes`

## Fluxo basico de uso

1. Login em `index.php`.
2. Acesso ao menu principal (`menuprincipal.php`).
3. Gestao de estoque em `menu.php?pag=estoque`.
4. Registro e consulta de entradas/saidas em `menu.php?pag=entrada-saida`.
5. Gestao de usuarios (perfil admin) em `menu-user.php?pag=users`.

## Observacoes importantes

- O projeto usa MD5 para senha em alguns pontos. Para ambiente de producao, recomenda-se migrar para `password_hash()` e `password_verify()`.
- Existem arquivos com codificacao de caracteres inconsistente (UTF-8/ANSI), o que pode causar textos com caracteres quebrados.
- O modulo de inventario na pasta `excel/` depende de configuracao propria de conexao e do layout esperado do CSV.

## Melhorias recomendadas

- Padronizar conexoes de banco em um unico arquivo.
- Adicionar validacao mais forte de entrada e uso de prepared statements em todas as queries.
- Criar `.env` para segredos e credenciais.
- Adicionar controle de permissao por perfil em todas as rotas.
- Escrever testes basicos de regressao para fluxos criticos.

## Licenca

Defina aqui a licenca do projeto (ex.: MIT) antes de publicar.
