<?php
    require "../controller/controller-chamar.php";
    //TER TAMBEM A CONTAGEM DE QUANTAS SENHAS FORAM CHAMADAS NO DIA
?>


<!DOCTYPE html>
<html lang="pt-br">
    <head>

    </head>
    <body>
        <form method="post">
            <input type="submit" value="Chamar Próxima Senha" name="chamar">
        </form>
        <br><br>
        <p><?=$senha_chamada_cookie?></p>
        <div id="conteudo"></div>

        <script type="text/javascript" src="../../assets/js/jquery-2.2.1.min.js"></script>
        <script type="text/javascript" src="../../assets/js/scripts.js"></script>
    </body>
</html>