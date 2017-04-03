<?php
include_once "classes/Url.class.php";

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
}else{
    if ($r == ""){
        route("login");
    }
}

function route ($rota){
    $escrever = new escrever();
    $escrever->conteudo = "/conteudos/".$rota.".php";
    require "view/main.php";
}

