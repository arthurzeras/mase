<?php

require_once "classes/Senhas.class.php";
require_once "classes/Acesso.class.php";
require_once "classes/inherits/Atendentes.class.php";

$senhas = new Senhas();
$acesso = new Acesso();
$atendente = new Atendentes();
$ultimas = 0;
$senha_chamada = "";


if(isset($_SESSION['atendente'])){
    //se nao houver nada no banco
    if ($senhas->qtdeSenhas() == 0){
        $mensagem = "Não há senha para ser chamada.";
    }else if(isset($_POST['chamar'])){
        if($senhas->verificarStatus($atendente->pegarId($_SESSION['atendente'])) != "Em Atendimento") {
            $senha_chamada = $senhas->chamarSenha($atendente->pegarId($_SESSION['atendente']));
            $_SESSION['senha_chamada'] = $senha_chamada;
            $mensagem = "Você está atendendo a senha: ".$_SESSION['senha_chamada'];
        }else{
            $mensagem = "Você já está atendendo uma senha. Finalize este atendimento";
        }
    }else if(isset($_POST['finalizar'])){
        //FINALIZAR O ATENDIMENTO
        $senhas->finalizarAtendimento($_SESSION['senha_chamada']);
        $mensagem = "Chame uma senha";
    }else{
        //PEGAR A SENHA CHAMADA E JOGAR NA SESSÃO PARA SER MOSTRADA MESMO QUE ATUALIZE A PÁGINA
        if (!isset($_SESSION['senha_chamada'])){
            $mensagem = "Chame uma senha";
        }else{
            $mensagem = "Você está atendendo a senha: ".$_SESSION['senha_chamada'];
        }
    }

}


//FAZER LOGOUT
if(isset($_GET['logout']) && $_GET['logout'] == true){
    if($senhas->verificarStatus($atendente->pegarId($_SESSION['atendente'])) == "Em Atendimento"){
        $mensagem = "Termine o atendimento antes de sair do sistema.";
    }else{
        $acesso->logout();
        header("Location: /mase/");
        unset($_SESSION['senha_chamada']);
    }
}