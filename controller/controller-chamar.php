<?php

require_once "classes/Senhas.class.php";
require_once "classes/Acesso.class.php";
require_once "classes/inherits/Atendentes.class.php";

$senhas = new Senhas();
$acesso = new Acesso();
$atendente = new Atendentes();
$senha_chamada = "";

if(isset($_SESSION['atendente'])){
    //SE NAO HOUVER SENHAS NO BANCO DE DADOS
    if ($senhas->qtdeSenhas() == 0){
        $mensagem = "Não há senha para ser chamada.";
    }else if(isset($_POST['chamar'])){
        //VERIFICA SE HÁ SENHA PARA SER CHAMADA
        $status_senha = $senhas->verificarStatus();
        $array_status = array();
        $i = 0;
        foreach ($status_senha as $key => $value){
            $array_status[$i] = $value->status;
            $i++;
        }
        if(!in_array("Aguardando",$array_status)){
            $mensagem = "Não há senha para ser chamada.";
        }else if($senhas->verificarStatus($atendente->pegarId($_SESSION['atendente'])) != "Em Atendimento") {
            $senha_chamada = $senhas->chamarSenha($atendente->pegarId($_SESSION['atendente']));
            $_SESSION['senha_chamada'] = $senha_chamada;
            $mensagem = "Você chamou a senha: ".$_SESSION['senha_chamada'];
            echo "<script>document.onclick(setSenha(2);</script>";
        }else{
            echo "<script>alert('Você já está atendendo uma senha. Finalize este atendimento');</script>";
            $mensagem = "Você está atendendo a senha: ".$_SESSION['senha_chamada'];
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
        echo "<script>alert('Termine o atendimento antes de sair do sistema.')</script>";
    }else{
        $acesso->logout();
        header("Location: /mase/");
        unset($_SESSION['senha_chamada']);
    }
}