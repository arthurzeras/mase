<?php
require_once "classes/inherits/Atendentes.class.php";
require_once "classes/inherits/TipoAtendimento.class.php";
require_once "classes/inherits/Atendimentos.class.php";
require_once "classes/Acesso.class.php";

$msg = "";
$result = "";
$atendente = new Atendentes();
$tipoAtendimento = new TipoAtendimento();
$atendimento = new Atendimentos();
$sair = new Acesso();

if(isset($_SESSION['adm'])) {
    //CADASTRAR NOVO ATENDENTE
    if (isset($_POST['matricula']) && isset($_POST['nome']) && isset($_POST['senha'])) {
        $atendente->setMatricula($_POST['matricula']);
        $atendente->setNome($_POST['nome']);
        $atendente->setEmail($_POST['email']);
        $atendente->setSenha(md5($_POST['senha']));

        if ($atendente->inserir() == true) {
            $msg = "Atendente inserido com sucesso!";
        } else {
            $msg = "Ocorreu algum erro";
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