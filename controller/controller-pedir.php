<?php

require "../../classes/Senhas.class.php";

$senhas = new Senhas();

if(isset($_POST['gerar'])){
    usleep(rand(0,2000000));

    if(isset($_POST['preferencial'])){
        $senha = "Sua senha é: ".$senhas->pedirSenha("Preferencial");
    }else{
        $senha = "Sua senha é: ".$senhas->pedirSenha("Normal");
    }

}else{
    $senha = "Peça uma senha";
}