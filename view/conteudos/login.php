<?php
    require_once "controller/controller-login.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            input{
                width:50%;
                height: 40px;
                font-size: 13pt;
                margin-bottom: 5px
            }
            input[type="submit"]{
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <h1 align="center">Login</h1>
        <form method="post" align="center">
            <input type="text" placeholder="Número da Matrícula" name="matricula" required>
            <input type="password" placeholder="Senha" name="senha" required>
            <input type="submit" value="Entrar">
            <br>
            <?=$error?>
        </form>
    </body>
</html>