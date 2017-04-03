<?php
require "classes/Atendentes.class.php";

$atendente = new Atendentes();
$error = "";

if(isset($_POST['matricula']) && isset($_POST['senha'])){
    $matricula = $_POST['matricula'];
    $senha = md5($_POST['senha']); //CRIPTOGRAFAR SENHA

    //SE DIGITOU ALGUMA COISA ERRADA, EXIBE UMA MENSAGEM DE ERRO
    if ($atendente->login($matricula,$senha) == false){
        $error = "Algum campo está errado, tente novamente.";

    //SE ESTIVER CERTO, INICIA UMA SESSÃO COM O NOME DO ATENDENTE
    }else{
        $nomeAtendente = $atendente->login($matricula,$senha);
        $_SESSION['atendente'] = $nomeAtendente;
    }


}