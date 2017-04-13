<?php

$r = (isset($_GET['r'])) ? htmlentities(strip_tags($_GET['r'])) : "";

if(isset($_SESSION['atendente'])){
    switch ($r){
        case "":
            route("inicio");
            break;

        case "portfolio":
            route($r);
            break;

        case "sobre":
            route($r);
            break;
    }
}else if(isset($_SESSION['adm'])){
    switch ($r){
        case "":
            route("admin/admin");
            break;
        case "admin/addatendente":
            route("admin/addAtendente");
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

