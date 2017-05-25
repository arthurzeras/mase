<?php

define("PATH", "https://mase-arthurzeras.c9users.io/"); //URL RAIZ DO SITE
$r = (isset($_GET['r'])) ? htmlentities(strip_tags($_GET['r'])) : "";

if(isset($_SESSION['atendente'])){
    switch ($r){
        case "":
            route("atendente/index", "MASE - Chamar nova senha");
            break;
        case "senhas":
            route("visualizadorSenhas", "MASE - Senhas chamadas");
            break;
        case "pedir":
            route("pedir-senha", "MASE - Pedir nova senha");
            break;
        default:
            route("404", "MASE - Página não encontrada");
            break;
    }
}else if(isset($_SESSION['adm'])){
    switch ($r){
        case "":
            route("admin/index", "MASE - Painel de administração");
            break;
        case "admin/tipoatendimento";
            route("admin/tipoAtendimento", "MASE - Tipos de atendimentos - Painel de administração");
            break;
        case "admin/usuarios":
            route("admin/usuarios", "MASE - Usuários - Painel de administração");
            break;
        case "admin/perfis":
            route("admin/perfis", "MASE - Perfis - Painel de administração");
            break;
        case "admin/guiches":
            route("admin/guiches", "MASE - Guichês - Painel de administração");
            break;
        case "admin/addusuario":
            route("admin/add-usuario", "MASE - Cadastrar novo usuário - Painel de administração");
            break;
        case "senhas":
            route("visualizadorSenhas", "MASE - Senhas chamadas");
            break;
        case "pedir":
            route("pedir-senha", "MASE -Pedir nova senha");
            break;
        default:
            route("404", "MASE - Página não encontrada");
            break;
    }
}else{
    switch ($r){
        case "":
            route("login", "MASE - Login");
            break;
        case "senhas":
            route("visualizadorSenhas", "MASE -Senhas chamadas");
            break;
        case "pedir":
            route("pedir-senha", "MASE -Pedir nova senha");
            break;
        case "recuperar-senha":
            route("recuperar-senha", "MASE - Esqueci minha senha");
            break;
        default:
            route("404", "MASE - Página não encontrada");
            break;
    }
}

function route($rota, $titulo){
    $conteudo = "view/conteudos/".$rota.".php";
    require "view/main.php";
}

