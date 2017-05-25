<?php
require_once "model/inherits/Usuarios.class.php";
require_once "model/inherits/TipoAtendimento.class.php";
require_once "model/inherits/Atendimentos.class.php";
require_once "model/inherits/Perfis.class.php";
require_once "model/inherits/Guiches.class.php";

$msg = "";
$result = "";
$msgerr = "";
$_SESSION['matricula'] = "";
$_SESSION['nome'] = "";
$_SESSION['email'] = "";

$usuario = new Usuarios();
$tipoAtendimento = new TipoAtendimento();
$atendimento = new Atendimentos();
$perfil = new Perfis();
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
    if(isset($_POST['id_perfil']) && isset($_POST['matricula']) && isset($_POST['nome']) && isset($_POST['email'])){
        $matriculaAtendente = $_POST['matricula'];
        $emailAtendente = $_POST['email'];
        $usuario->setPerfil($_POST['id_perfil']);
        $usuario->setMatricula($matriculaAtendente);
        $usuario->setNome($_POST['nome']);
        $usuario->setEmail($emailAtendente);
        $usuario->setSenha(md5($_POST['matricula']));
        if($usuario->validar() == false){
            $msg = '<p class="mensagem_erro">Já existe essa matrícula ou esse e-mail cadastrado.</p>';
            formCampos();
        }else{
            if($usuario->inserir() == true){
                echo '<script>alert("Usuário inserido com sucesso!")</script>';
            }else{
                $msg = "Ocorreu algum erro";
            }
        }
    }
    
    //CADASTRAR NOVO PERFIL
    if(isset($_POST['perfil'])){
        $perfil->setNome($_POST['perfil']);
        if($perfil->inserir() == true){
            echo '<script>alert("Perfil inserido com sucesso!")</script>';
            echo '<script>window.location.href="'.PATH.'admin/perfis"</script>';
        }else{
            $msg = "Ocorreu algum erro.";
        }
    }

    //CADASTRAR NOVO TIPO DE ATENDIMENTO
    if(isset($_POST['tipo_atendimento'])){
        $tipo = $_POST['tipo_atendimento'];
        $tipoAtendimento->setNomeAtendimento($tipo);
        if($tipoAtendimento->validar() == true){
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
    
    //ALTERAR USUÁRIO
    if(isset($_POST['alterar_usuario'])){
        $matricula = (int)$_POST['matricula_editar'];
        $nome = $_POST['nome_editar'];
        $email = $_POST['email_editar'];
        $id_usuario = (int)$_POST['id'];
        $perfil = $_POST['id_perfil'];

        $usuario->setMatricula($matricula);
        $usuario->setNome($nome);
        $usuario->setPerfil($perfil);
        $usuario->setEmail($email);
        
        //VALIDAR PARA NÃO COLOCAR DADOS REPETIDOS
        if($usuario->validar($id_usuario) == true){
            if($usuario->alterar($id_usuario)){
            header("Location: ".PATH."admin/usuarios&update=ok");
            }else{
                $msg = "Não foi possível alterar";
            }    
        }else{
            $msg = "Já existe este email ou matrícula cadastrado!";
        }
    }
    
    //ALTERAR PERFIL
    if(isset($_POST['alterar_perfil'])){
        $id_perfil = $_POST['id'];
        $perfil->setNome($_POST['perfil_editando']);
        
        if($perfil->alterar($id_perfil)){
            header("Location: ".PATH."admin/perfis&update=ok");
        }else{
            $msg = "Não foi possível alterar";
        }
    }

    //ALTERAR TIPO DE ATEDIMENTO
    if(isset($_POST['alterar_atendimento'])){
        $idAtendimento = $_POST['id'];
        $tipoAtendimento->setNomeAtendimento($_POST['nome_tipo']);

        if($tipoAtendimento->validar() == true){
            if($tipoAtendimento->alterar($idAtendimento)){
                header("Location: ".PATH."admin/tipoatendimento&update=ok");
            }else{
                $msg = "Não foi possível alterar";
            }    
        }else{
            $msg = "Já existe um tipo de atendimento com este nome.";
        }
    }

    //ALTERAR GUICHE
    if(isset($_POST['alterar_guiche'])){
        $idGuiche = $_POST['id'];
        $guiche->setIp($_POST['ip_maquina_alterar']);
        $guiche->setGuiche($_POST['num_guiche_alterar']);

        if($guiche->validar($idGuiche) == true){
            if($guiche->alterar($idGuiche)){
                header("Location: ".PATH."admin/guiches&update=ok");
            }else{
                $msg = "Não foi possível alterar";
            }    
        }else{
            $msg = "Este IP ou número já existe.";
        }
    }

    //DELETAR
    if(isset($_GET['do']) && $_GET['do'] == "del"){
        $pagina = $_GET['pagina'];
        $id = $_GET['id'];
        switch ($pagina){
            case "tipo_atendimento":
                $tipoAtendimento->excluir($id);
                header("Location: ".PATH."admin/tipoatendimento&del=ok");
                break;
            case "perfis":
                $perfil->excluir($id);
                header("Location: ".PATH."admin/perfis&del=ok");
                break;
            case "usuarios":
                $usuario->excluir($id);
                header("Location: ".PATH."admin/usuarios&del=ok");
                break;
            case "guiches":
                $guiche->excluir($id);
                header("Location: ".PATH."admin/guiches&del=ok");
                break;
        }
    }

    //MENSAGENS
    if(isset($_GET['update']) && $_GET['update'] == "ok"){
        echo '<script>alert("Alterado com sucesso.")</script>';
    }else if(isset($_GET['del']) && $_GET['del'] == "ok"){
        echo '<script>alert("Deletado com sucesso.")</script>';
    }

    //LOGOUT
    if(isset($_GET['logout']) && $_GET['logout'] == "true"){
        $atendente->logout();
        header("Location: ".PATH);
    }
}else{
    header("Location: ".PATH);
}