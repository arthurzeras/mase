<?php

define("PATH", "/mase/"); //URL RAIZ DO SITE
$r = (isset($_GET['r'])) ? htmlentities(strip_tags($_GET['r'])) : "";

if(isset($_SESSION['atendente'])){
    switch ($r){
        case "":
            route("atendente/index");
            break;
        case "atendente/editar":
            route("atendente/editar");
            break;
        case "senhas":
            route("visualizadorSenhas");
            break;
        case "pedir":
            route("pedir-senha");
            break;
        default:
            route("404");
            break;
    }
}else if(isset($_SESSION['adm'])){
    switch ($r){
        case "":
            route("admin/index");
            break;
        case "admin/tipoatendimento";
            route("admin/tipoAtendimento");
            break;
        case "admin/atendentes":
            route("admin/atendentes");
            break;
        case "admin/guiches":
            route("admin/guiches");
            break;
        case "admin/teste":
            route("admin/teste");
            break;
        case "admin/addatendente":
            route("admin/addAtendente");
            break;
        case "senhas":
            route("visualizadorSenhas");
            break;
        case "pedir":
            route("pedir-senha");
            break;
        default:
            route("404");
            break;
    }
}else{
    switch ($r){
        case "":
            route("login");
            break;
        case "senhas":
            route("visualizadorSenhas");
            break;
        case "pedir":
            route("pedir-senha");
            break;
        case "recuperar-senha":
            route("recuperar-senha");
            break;
        default:
            route("404");
            break;
    }
}

function route($rota){
    $conteudo = "view/conteudos/".$rota.".php";
    require "view/main.php";
}

