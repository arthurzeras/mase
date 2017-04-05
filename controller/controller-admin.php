<?php
require "classes/inherits/CrudAtendentes.class.php";
$msg = "";
$acao = "";
$msgUpdate = "";
$atendente = new CrudAtendentes();


//CADASTRAR NOVO ATENDENTE
if (isset($_POST['matricula']) && isset($_POST['nome']) && isset($_POST['senha'])){
    $atendente->setMatricula($_POST['matricula']);
    $atendente->setNome($_POST['nome']);
    $atendente->setSenha(md5($_POST['senha']));

    if ($atendente->inserir() == true){
        $msg = "Atendente inserido com sucesso!";
    }else{
        $msg = "Ocorreu algum erro";
    }
}

//ALTERAR
//PROCEDIMENTOS PARA PEGAR O GET DA URL
if(strlen($_SERVER['REQUEST_URI']) > 11){ //SE A STRING DA URL FOR MAIOR QUE 11 (/mase/admin?...)
    $get = explode("?",$_SERVER['REQUEST_URI']);//VAI EXPLODIR A URL PELO: ?
    $res = explode("&",$get[1]);//VAI EXPLODIR PELO: &, SEPARANDO A ACAO DO ID
    $acao = explode("=", $res[0]);//VAI MOSTRAR SOMENTE O QUE A AÇAO FAZ
    $id = explode("=", $res[1]);//VAI PEGAR O ID

//TIRAR DO ARRAY PARA FICAR MAIS FÁCIL DE USAR
    $id = $id[1];
    $acao = $acao[1];

    if (isset($_POST['alterar'])){
        $matricula = (int)$_POST['matricula'];
        $nome = $_POST['nome'];
        $idAtendente = (int)$_POST['id'];

        $atendente->setMatricula($matricula);
        $atendente->setNome($nome);

        if($atendente->alterar($idAtendente)){
            $msgUpdate = "Alterado com sucesso!";
        }else{
            $msgUpdate = "Não foi possível alterar";
        }
    }
}


