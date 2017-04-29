<?php
require_once "classes/inherits/Atendentes.class.php";
require_once "classes/inherits/TipoAtendimento.class.php";
require_once "classes/inherits/Atendimentos.class.php";
require_once "classes/Acesso.class.php";

$msg = "";
$result = "";
$buceta = "";
$_SESSION['matricula'] = "";
$_SESSION['nome'] = "";
$_SESSION['email'] = "";

$atendente = new Atendentes();
$tipoAtendimento = new TipoAtendimento();
$atendimento = new Atendimentos();
$sair = new Acesso();

function formCampos(){
    if(isset($_POST['matricula']) && isset($_POST['nome']) && isset($_POST['email'])){
        $_SESSION['matricula'] = $_POST['matricula'];
        $_SESSION['nome'] = $_POST['nome'];
        $_SESSION['email'] = $_POST['email'];
    }
}

if(isset($_SESSION['adm'])) {
    //CADASTRAR NOVO ATENDENTE
    if (isset($_POST['matricula']) && isset($_POST['nome']) && isset($_POST['email'])) {
        $matriculaAtendente = $_POST['matricula'];
        $emailAtendente = $_POST['email'];
        $atendente->setMatricula($matriculaAtendente);
        $atendente->setNome($_POST['nome']);
        $atendente->setEmail($emailAtendente);
        $atendente->setSenha(md5($_POST['matricula']));


        //NÃO PERMITIR INSERIR O MESMO E-MAIL OU MATRICULA JÁ EXISTENTE
        if((($atendente->verificarDisponibilidade("matricula",$matriculaAtendente)) != 0) && (($atendente->verificarDisponibilidade("email_atendente",$emailAtendente)) != 0)){
            $msg = "<p class='mensagem_erro'>Já existe um atendente com esta matrícula e campo!</p>";
            formCampos();
        }else if(($atendente->verificarDisponibilidade("matricula",$matriculaAtendente)) != 0){
            $msg = "<p class='mensagem_erro'>Já existe um atendente com esta matrícula!</p>";
            formCampos();
        }else if (($atendente->verificarDisponibilidade("email_atendente",$emailAtendente)) != 0) {
            $msg = "<p class='mensagem_erro'>Já existe um atendente com este email!</p>";
            formCampos();
        }else{
            if ($atendente->inserir() == true){
                $msg = '<script>alert("Atendente inserido com sucesso!")</script>';
            } else {
                $msg = "Ocorreu algum erro";
            }
        }
    }

    //CADASTRAR NOVO TIPO DE ATENDIMENTO
    if(isset($_POST['tipo_atendimento'])){
        $tipo = $_POST['tipo_atendimento'];
        $tipoAtendimento->setNomeAtendimento($tipo);

        //CADASTRAR O TIPO NA TABELA TIPO ATENDIMENTO
        if($tipoAtendimento->inserir() == true){
            $msg = "Tipo de atendimento inserido com sucesso!";
        }else{
            $msg = "Ocorreu algum erro.";
        }
    }

    //ALTERAR ATENDENTE
    if (isset($_POST['alterar_atendente'])) {
        $matricula = (int)$_POST['matricula'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $idAtendente = (int)$_POST['id'];

        $atendente->setMatricula($matricula);
        $atendente->setNome($nome);
        $atendente->setEmail($email);

        if ($atendente->alterar($idAtendente)) {
            header("Location: /mase/admin/atendentes&update=ok");
        } else {
            $msg = "Não foi possível alterar";
        }
    }

    //ALTERAR TIPO DE ATEDIMENTO
    if(isset($_POST['alterar_atendimento'])){
        $idAtendimento = $_POST['id'];
        $tipoAtendimento->setNomeAtendimento($_POST['nome_tipo']);

        if($tipoAtendimento->alterar($idAtendimento)){
            header("Location: /mase/admin/tipoAtendimento&update=ok");
        }else{
            $msg = "Não foi possível alterar";
        }
    }

    //DELETAR
    if (isset($_GET['do']) && $_GET['do'] == "del") {
        $pagina = $_GET['pagina'];
        $id = $_GET['id'];
        switch ($pagina){
            case "tipo_atendimento":
                $tipo = $tipoAtendimento->pegarLinha($id);
                $atendimento->deletarColuna($atendimento->formatarVariavel($tipo->nome_tipo));
                $tipoAtendimento->excluir($id);
                header("Location: /mase/admin/tipoAtendimento&del=ok");
                break;
            case "atendentes":
                $atendente->excluir($id);
                header("Location: /mase/admin/atendentes&del=ok");
                break;
        }
    }

    //MENSAGENS
    if (isset($_GET['update']) && $_GET['update'] == "ok") {
        $msg = '<script>alert("Alterado com sucesso.")</script>';
    } else if (isset($_GET['del']) && $_GET['del'] == "ok") {
        $msg = '<script>alert("Deletado com sucesso.")</script>';
    }

    //LOGOUT
    if(isset($_GET['logout']) && $_GET['logout'] == "true"){
        $sair->logout();
        header("Location: /mase/");
    }
}else{
    header("Location: /mase/");
}