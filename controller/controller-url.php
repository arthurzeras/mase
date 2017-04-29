<?php

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
        case "admin/teste":
            route("admin/teste");
            break;
        case "admin/addatendente":
            route("admin/addAtendente");
            break;
        case "senhas":
            route("visualizadorSenhas");
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
    }
}

function route($rota){
    $conteudo = "view/conteudos/".$rota.".php";
    require "view/main.php";
}

