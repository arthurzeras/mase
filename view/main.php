<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php require_once $conteudo;

        if(isset($_GET['r'])){
            $url = explode("/", $_GET['r']);
            if(isset($url[1])){
                echo "<script type='text/javascript' src='../assets/js/jquery-2.2.1.min.js'></script>";
                echo "<script type='text/javascript' src='../assets/js/scr.js'></script>";
            }else{
                echo "<script type='text/javascript' src='assets/js/jquery-2.2.1.min.js'></script>";
                echo "<script type='text/javascript' src='assets/js/scr.js'></script>";
            }
        }else{
            echo "<script type='text/javascript' src='assets/js/jquery-2.2.1.min.js'></script>";
            echo "<script type='text/javascript' src='assets/js/scr.js'></script>";
        }
        ?>
    </body>
</html>