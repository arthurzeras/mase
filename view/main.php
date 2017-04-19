<?php
if(isset($_GET['r'])){
    $url = explode("/", $_GET['r']);
    if(isset($url[1])){
        $diretorio = "../assets";
    }else{
        $diretorio = "assets";
    }
}else{
    $diretorio = "assets";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?=$diretorio?>/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?=$diretorio?>/css/estilos.css">
    </head>
    <body>
        <?php require_once $conteudo;?>
        <script type="text/javascript" src="<?=$diretorio?>/js/jquery-2.2.1.min.js"></script>
        <script type="text/javascript" src="<?=$diretorio?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?=$diretorio?>/js/scr2.js"></script>
    </body>
</html>