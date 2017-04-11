<?php
require "classes/inherits/Atendentes.class.php";
require "classes/Acesso.class.php";
$msg = "";
$result = "";
$atendente = new Atendentes();
$sair = new Acesso();

if(isset($_SESSION['adm'])) {
    //CADASTRAR NOVO ATENDENTE
    if (isset($_POST['matricula']) && isset($_POST['nome']) && isset($_POST['senha'])) {
        $atendente->setMatricula($_POST['matricula']);
        $atendente->setNome($_POST['nome']);
        $atendente->setSenha(md5($_POST['senha']));

        if ($atendente->inserir() == true) {
            $msg = "Atendente inserido com sucesso!";
        } else {
            $msg = "Ocorreu algum erro";
        }
    }

    //ALTERAR ATENDENTE
    if (isset($_POST['alterar'])) {
        $matricula = (int)$_POST['matricula'];
        $nome = $_POST['nome'];
        $idAtendente = (int)$_POST['id'];

        $atendente->setMatricula($matricula);
        $atendente->setNome($nome);

        if ($atendente->alterar($idAtendente)) {
            header("Location: /mase/admin&update=ok");
        } else {
            $msg = "Não foi possível alterar";
        }
    }

    //DELETAR ATENDENTE
    if (isset($_GET['do']) && $_GET['do'] == "del") {
        $id = $_GET['id'];
        $atendente->excluir($id);
        header("Location: /mase/admin&del=ok");
    }

    //MENSAGENS
    if (isset($_GET['update']) && $_GET['update'] == "ok") {
        $msg = "<p align='center'>Alterado com sucesso!</p>";
    } else if (isset($_GET['del']) && $_GET['del'] == "ok") {
        $msg = "<p align='center'>Deletado com sucesso!</p>";
    }

    //LOGOUT
    if(isset($_GET['logout']) && $_GET['logout'] == "ok"){
        $sair->logout();
        header("Location: /mase/");
    }
}else{
    header("Location: /mase/");
}