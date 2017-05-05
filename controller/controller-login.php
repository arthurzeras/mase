<?php
require "classes/inherits/Atendentes.class.php";

$atendente = new Atendentes();
$error = "";

if(isset($_POST['matricula']) && isset($_POST['senha'])){
    $matricula = $_POST['matricula'];
    $senha = md5((string)$_POST['senha']); //CRIPTOGRAFAR SENHA

    //SE DIGITOU ALGUMA COISA ERRADA, EXIBE UMA MENSAGEM DE ERRO
    if ($atendente->login($matricula,$senha) == false){
        $error = "Algum campo está errado, tente novamente.";

    //SE ESTIVER CERTO, INICIA A SESSÃO
    }else{
        $nome = $atendente->login($matricula, $senha);

        if($nome == "admin"){
            $_SESSION['adm'] = $nome;
            header("Location: /mase/");
        }else{
            $_SESSION['atendente'] = $nome;
            header("Location: /mase/");
        }
    }
}