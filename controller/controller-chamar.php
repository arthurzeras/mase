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
    //MOSTRAR AS TRÊS ÚLTIMAS SENHAS CHAMADAS
    $ultima = $senhas->pegarUltimaSenha();
    $idUltima = $senhas->pegarIdSenha($ultima);
    $linhas = (int)$senhas->qtdeSenhas();

    if($linhas == 1){
        $ultimasSenhas = "<p id='#ultimas-senhas'>Última senha pedida: $ultimas</p>";
    }else if ($linhas == 2){
        $ultimasSenhas = "<p id='#ultimas-senhas'>Últimas senhas pedidas: ". ($senhas->pegarSenhaPorId($idUltima - 1)) ." - ". $ultima ."</p>";
    }else if ($linhas >= 3){
        $ultimasSenhas = "<p id='#ultimas-senhas'>Últimas senhas pedidas: ". ($senhas->pegarSenhaPorId($idUltima - 2)) ." - ". ($senhas->pegarSenhaPorId($idUltima - 1)) ." - ". $ultima ."</p>";
    }


    //PEGAR A SENHA CHAMADA E JOGAR EM UM COOKIE PARA SER MOSTRADA MESMO QUE ATUALIZE A PÁGINA
    if (!isset($_COOKIE['senha_chamada'])){
        $senha_chamada_cookie = "Chame uma senha";
    }else{
        $senha_chamada_cookie = "Você está atendendo a senha: ".$_COOKIE['senha_chamada'];
    }
}