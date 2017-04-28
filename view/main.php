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

$imagemLogo = '<img src="'.$diretorio.'/img/logo_header.png" class="imagem_logo img-responsive">';
$botaoLogout = '<a class="icones_header logout" href="?logout=true"><i class="flaticon flaticon-logout"></i></a>';

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?=$diretorio?>/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?=$diretorio?>/css/flaticon.css">
        <link rel="stylesheet" type="text/css" href="<?=$diretorio?>/css/estilos.css">
    </head>
    <body>
        <?php require_once $conteudo;?>
        <script type="text/javascript" src="<?=$diretorio?>/js/jquery-2.2.1.min.js"></script>
        <script type="text/javascript" src="<?=$diretorio?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?=$diretorio?>/js/scr2.js"></script>
        <script type="text/javascript" src="<?=$diretorio?>/js/collapse.js"></script>
    </body>
</html>