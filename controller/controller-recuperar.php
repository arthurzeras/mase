<?php require_once "model/inherits/Atendentes.class.php";
$atendente = new Atendentes();
$mensagem = "";

if(isset($_POST['email'])){
    $atendente->setEmail($_POST['email']);
    $email = $atendente->recuperarEmail();

    switch ($email){
        case false:
            $mensagem = "O email digitado não existe, tente novamente.";
            break;
        case true:
            $mensagem = '<script>alert("Foram enviadas instruções de alteração de senha para o seu email.")</script>';
    }
}