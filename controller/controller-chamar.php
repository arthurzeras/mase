<?php

require "../classes/Senhas.class.php";

$senhas = new Senhas();
$ultimas = 0;
$ultimas_inner = "";



//se nao houver nada no banco
if ($senhas->qtdeSenhas() == 0){
    $senha_chamada_cookie = "Não há senha para ser chamada.";

//se existir o pedido de senha e evitar o erro de chamar senha que nao existe
}else if (isset($_POST['chamar'])){
    $senha_chamada = $senhas->chamarSenha();
    $senha_chamada_id = $senhas->pegarIdSenha($senha_chamada);
    setcookie("senha_chamada", $senha_chamada, time() + (24*3600));
    setcookie("senha_chamada_id", $senha_chamada_id, time() + (24*3600));

    if($senha_chamada === null){
        $senhas->alterarStatus("Finalizado",$_COOKIE['senha_chamada_id']);
        $senha_chamada_cookie = "Não há mais senha para ser chamada";
    }else{
        $senha_chamada_cookie = "Você está atendendo a senha: ".$_COOKIE['senha_chamada'];
        header("Refresh:0");
    }
}else{
    //pegar a senha chamada e jogar no cookie para ser mostrada sempre mesmo que atualize a pagina
    $ultimas = $senhas->pegarUltimaSenha();
    $linhas = (int)$senhas->qtdeSenhas();

//    if($linhas == 1){
//        $ultimas_inner = "<p id='#ultimas-senhas'>Última senha pedida: $ultimas</p>";
//    }else if ($linhas == 2){
//        $ultimas_inner = "<p id='#ultimas-senhas'>Últimas senhas pedidas: ". ($ultimas-1) ." - ". $ultimas ."</p>";
//    }else if ($linhas >= 3){
//        $ultimas_inner = "<p id='#ultimas-senhas'>Últimas senhas pedidas: ". ($ultimas-2) ." - ". ($ultimas-1) ." - ". $ultimas ."</p>";
//    }
    if (!isset($_COOKIE['senha_chamada'])){
        $senha_chamada_cookie = "Chame uma senha";
    }else{
        $senha_chamada_cookie = "Você está atendendo a senha: ".$_COOKIE['senha_chamada'];
    }
}