<?php
require_once "classes/inherits/Atendentes.class.php";
require_once "classes/inherits/TipoAtendimento.class.php";
require_once "classes/inherits/Atendimentos.class.php";
require_once "classes/inherits/Guiches.class.php";

$msg = "";
$result = "";
$msgerr = "";
$_SESSION['matricula'] = "";
$_SESSION['nome'] = "";
$_SESSION['email'] = "";

$atendente = new Atendentes();
$tipoAtendimento = new TipoAtendimento();
$atendimento = new Atendimentos();
$guiche = new Guiches();

function formCampos(){
    if(isset($_POST['matricula']) && isset($_POST['nome']) && isset($_POST['email'])){
        $_SESSION['matricula'] = $_POST['matricula'];
        $_SESSION['nome'] = $_POST['nome'];
        $_SESSION['email'] = $_POST['email'];
    }
}

if(isset($_SESSION['adm'])) {
    //CADASTRAR NOVO ATENDENTE
    if(isset($_POST['matricula']) && isset($_POST['nome']) && isset($_POST['email'])){
        $matriculaAtendente = $_POST['matricula'];
        $emailAtendente = $_POST['email'];
        $atendente->setMatricula($matriculaAtendente);
        $atendente->setNome($_POST['nome']);
        $atendente->setEmail($emailAtendente);
        $atendente->setSenha(md5($_POST['matricula']));


        //NÃO PERMITIR INSERIR O MESMO E-MAIL OU MATRICULA JÁ EXISTENTE
        if((($atendente->verificarDisponibilidade("matricula",$matriculaAtendente)) != 0) && (($atendente->verificarDisponibilidade("email_atendente",$emailAtendente)) != 0)){
            $msg = "<p class='mensagem_erro'>Já existe um atendente com esta matrícula e email!</p>";
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
        if($tipoAtendimento->pegarId($tipo) === ""){
            if($tipoAtendimento->inserir() == true){
                echo '<script>alert("Tipo de atendimento inserido com sucesso!")</script>';
                echo '<script>window.location.href="'.PATH.'admin/tipoatendimento"</script>';
            }else{
                $msg = "Ocorreu algum erro.";
            }
        }else{
            $msgerr = "<p id='erro'>Já existe um tipo de atendimento com este nome!</p>";
        }
    }

    //CADASTRAR NOVO GUICHÊ
    if(isset($_POST['ip_maquina']) && isset($_POST['num_guiche'])){
        $guiche->setIp($_POST['ip_maquina']);
        $guiche->setGuiche($_POST['num_guiche']);
        if($guiche->validar() == true){
            $guiche->inserir();
            echo '<script>alert("Cadastrado com sucesso!")</script>';
            echo '<script>window.location.href="'.PATH.'admin/guiches"</script>';
        }else{
            $msgerr = '<p id="erro">Já existe este ip ou este número cadastrado.</p>';
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
            header("Location: ".PATH."admin/atendentes&update=ok");
        } else {
            $msg = "Não foi possível alterar";
        }
    }

    //ALTERAR TIPO DE ATEDIMENTO
    if(isset($_POST['alterar_atendimento'])){
        $idAtendimento = $_POST['id'];
        $tipoAtendimento->setNomeAtendimento($_POST['nome_tipo']);

        if($tipoAtendimento->alterar($idAtendimento)){
            header("Location: ".PATH."admin/tipoatendimento&update=ok");
        }else{
            $msg = "Não foi possível alterar";
        }
    }

    //ALTERAR GUICHE
    if(isset($_POST['alterar_guiche'])){
        $idGuiche = $_POST['id'];
        $guiche->setIp($_POST['ip_maquina']);
        $guiche->setGuiche($_POST['num_guiche']);

        if($guiche->alterar($idGuiche)){
            header("Location: ".PATH."admin/guiches&update=ok");
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
                $tipoAtendimento->excluir($id);
                header("Location: ".PATH."admin/tipoatendimento&del=ok");
                break;
            case "atendentes":
                $atendente->excluir($id);
                header("Location: ".PATH."admin/atendentes&del=ok");
                break;
            case "guiches":
                $guiche->excluir($id);
                header("Location: ".PATH."admin/guiches&del=ok");
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
        $atendente->logout();
        header("Location: ".PATH);
    }
}else{
    header("Location: ".PATH);
}