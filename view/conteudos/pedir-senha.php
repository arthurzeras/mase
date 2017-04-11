<?php
    require "../../controller/controller-pedir.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form method="post">
            <input type="submit" value="Pedir Senha" name="gerar">
            <label>Atendimento preferencial?</label><input type="checkbox" name="preferencial">
        </form>
        <br><br>
        <p><?=$senha?></p>
    </body>
</html>