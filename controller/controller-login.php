<?php
require "model/inherits/Usuarios.class.php";

$usuario = new Usuarios();
$error = "";

if(isset($_POST['matricula']) && isset($_POST['senha'])){
    $matricula = $_POST['matricula'];
    $senha = md5((string)$_POST['senha']); //CRIPTOGRAFAR SENHA

    //SE DIGITOU ALGUMA COISA ERRADA, EXIBE UMA MENSAGEM DE ERRO
    if ($usuario->login($matricula,$senha) == false){
        $error = "Algum campo está errado, tente novamente.";

    //SE ESTIVER CERTO, INICIA A SESSÃO
    }else{
        $array_usuario = $usuario->login($matricula, $senha);

        if($array_usuario->fk_perfil == 1){
            $_SESSION['adm'] = $array_usuario->nome_usuario;
            header("Location: ".PATH);
        }else if($array_usuario->fk_perfil == 2){
            $_SESSION['atendente'] = $array_usuario->nome_usuario;
            header("Location: ".PATH);
        }
    }
}