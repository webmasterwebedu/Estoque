<?php ob_start();
session_start();

if($_GET['erro']== 1){
print "<script>alert('Favor Logar - se  !!!');</script>";
}
if($_GET['erro']== 2){
print "<script>alert('Usuario ou senha errada !!!');</script>";
}

?>


<!DOCTYPE html>

<html lang="pt-br">

    <head>
    
    <style>
	body {

    padding: 0;

    margin: 0;

   /* background-color: #454d6b;  */
   
   	background-image :url('imagens/fundo-clear.jpg');

}

#login {

    display: flex;

    align-items: center;

    justify-content: center;

    height: 100vh;

    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;


}

.card {

    background-color:#fff;



    padding: 40px;

    border-radius: 2px;

    width:280px;

}

.card-header {

    padding-bottom: 50px;

    opacity: 0.8;

    color: #000;

}

.card-header::after {

    content: "";

    width: 70px;

    height: 1px;

    background-color: #fff;

    display: block;

    margin-top: -17px;

    margin-left: -5px;

}

.card-content label {

    color: #000;

    font-size: 12px;

    opacity: 0.8;

}

.card-content-area {

    display: flex;

    flex-direction: column;

    padding:10px 0;

}

.card-content-area input {

    margin-top: 10px;

    padding:0 5px;

    background-color: transparent;

    border:none;

    border-bottom: 1px solid #e1e1e1;

    outline: none;

    color: #000;

}

.card-footer {

    display: flex;

    flex-direction: column;

}

.card-footer .submit{

    width: 100%;

    height: 40px;

    background-color: #a13854;

    border:none;

    color:#e1e1e1;

    margin: 10px 0;

}

.card-footer a {

    text-align: center;

    font-size: 12px;

    opacity: 0.8;

    color: #fff;

    text-decoration: none;

}
	
	</style>

        <meta charset="UTF-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport"content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="style.css">

        <title>Clear Channel - Estoque TI</title>

    </head>

    <body>

        <div id="login">
        

           <form class="card" id="form1" name="form1" method="post" action="menuprincipal.php">

                <div class="card-header">

                    <h4>Sistema de Estoque  TI  Clear Channel</h4>

                </div>

                <div class="card-content">

                    <div class="card-content-area">

                        <label for="usuario">Usuário</label>

                        <input type="text" name="username" id="username" autocomplete="off">

                    </div>

                    <div class="card-content-area">

                        <label for="password">Senha</label>

                        <input type="password" name="password" id="password" autocomplete="off">

                    </div>

                </div>

                <div class="card-footer">

                    <input name="bt_login" type="submit" value="Login" class="submit">

                    <a href="#" class="recuperar_senha">Esqueceu a senha?</a>

                </div>

            </form>

        </div>

    </body>

</html>
