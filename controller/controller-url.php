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
}else{

    switch ($r){
        case "":
            route("login");
            break;

        case "admin":
            route("admin/admin");
            break;
        case "admin/addatendente":
            route("admin/addAtendente");
            break;
    }
}



function route ($rota){
    $conteudo = "/conteudos/".$rota.".php";
    require "view/main.php";
}

