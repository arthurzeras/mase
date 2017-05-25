<?php
require_once "model/Senhas.class.php";

$senhas = new Senhas();

if(isset($_POST['gerar'])){
    usleep(rand(0,2000000));

    if(isset($_POST['preferencial'])){
        $senha = "Sua senha é: <span>".$senhas->pedirSenha("Preferencial")."</span>";
    }else{
        $senha = "Sua senha é: <span>".$senhas->pedirSenha("Normal")."</span>";
    }

}else{
    $senha = "";
}