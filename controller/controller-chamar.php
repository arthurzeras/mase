<?php
require_once "classes/Senhas.class.php";
require_once "classes/Acesso.class.php";
require_once "classes/inherits/TipoAtendimento.class.php";
require_once "classes/inherits/Atendentes.class.php";
require_once "classes/inherits/Atendimentos.class.php";

$senhas = new Senhas();
$atendente = new Atendentes();
$tipoAtendimento = new TipoAtendimento();
$atendimento = new Atendimentos();

$senha_chamada = "";
$mensagem = "";
$botao = "<button data-toggle='tooltip' title='Chamar próxima senha' class='botao_chamar' type='submit' name='chamar'><img class='icon_call' src='assets/img/icon-next.png'></button>";
$botao_finalizar = '<a data-toggle="tooltip" title="Finalizar atendimento" class="botao_finalizar disabled" href="/mase/&finalizar=ok" role="button"><img id="icon_finish" src="assets/img/icon-finish.png"></a>';

if(isset($_SESSION['atendente'])){

    //SE NAO HOUVER SENHAS NO BANCO DE DADOS
    if ($senhas->qtdeSenhas() == 0){
        $mensagem = '<p class="box_senha sem_senha">Não há senha para chamar</p>';
        $botao_finalizar = "";

    //SE O ATENDENTE CLICOU NO BOTAO DE CHAMAR SENHA
    }else if(isset($_POST['chamar'])){
        $botao = "<button data-toggle='tooltip' title='Chamar senha de novo' class='botao_chamar' type='submit' name='chamar_novamente'><img class='icon_call' src='assets/img/icon-repeat.png'></button>";


        //SE NÃO HÁ NENHUMA SENHA COM STATUS AGUARDANDO
        if(!in_array("Aguardando",$senhas->verificarStatus())){
            $mensagem = '<p class="box_senha sem_senha">Não há senha para chamar</p>';
            $botao = "<button data-toggle='tooltip' title='Chamar próxima senha' class='botao_chamar' type='submit' name='chamar'><img class='icon_call' src='assets/img/icon-next.png'></button>";
            $botao_finalizar = '';

        //SE EXISTIR SENHAS COM STATUS DIFERENTE DE EM ATENDIMENTO ELE CHAMA A SENHA
        }else if($senhas->verificarStatus($atendente->pegarId($_SESSION['atendente'])) != "Em Atendimento") {
            $hora_atual = date("H:i:s");
            $_SESSION['hora_inicial'] = $hora_atual;
            $senha_chamada = $senhas->chamarSenha($atendente->pegarId($_SESSION['atendente']), $hora_atual);
            $_SESSION['senha_chamada'] = $senha_chamada;
            $mensagem = '<p class="box_senha">'.$_SESSION['senha_chamada'].'</p>';
        }else{
            $botao = "<button data-toggle='tooltip' title='Chamar senha de novo' class='botao_chamar' type='submit' name='chamar_novamente'><img class='icon_call' src='assets/img/icon-repeat.png'></button>";
            $mensagem = '<p class="box_senha">'.$_SESSION['senha_chamada'].'</p>';
        }
    }else if(isset($_POST['chamar_novamente'])){
        $hora_atual = date("H:i:s");
        $senha_chamada = $senhas->chamarNovamente($_SESSION['senha_chamada'], $hora_atual);
        $_SESSION['senha_chamada'] = $senha_chamada;
        $botao = "<button data-toggle='tooltip' title='Chamar senha de novo' class='botao_chamar' type='submit' name='chamar_novamente'><img class='icon_call' src='assets/img/icon-repeat.png'></button>";
        $mensagem = '<p class="box_senha">'.$_SESSION['senha_chamada'].'</p>';
    }else if(isset($_POST['finalizar'])){
        $horaInicial = new DateTime($_SESSION['hora_inicial']);
        $horaFinal = new DateTime(date("H:i:s"));
        $diff = $horaFinal->diff($horaInicial)->format("%H:%I:%S");

        $atendimento->setAtendente($_POST['atendente']);
        $atendimento->setTipoAtendimento($_POST['tipo_atendimento']);
        $atendimento->setDuracao($diff);
        $atendimento->setDataAtendimento($_POST['data']);
        $atendimento->inserir();

        //FINALIZAR O ATENDIMENTO
        $senhas->finalizarAtendimento($_SESSION['senha_chamada']);
        header("Location: /mase/");
        $mensagem = '<p class="box_senha chamar_senha">Chame uma senha</p>';
    }else{
        //PEGAR A SENHA CHAMADA E JOGAR NA SESSÃO PARA SER MOSTRADA MESMO QUE ATUALIZE A PÁGINA
        if (!isset($_SESSION['senha_chamada'])){
            $mensagem = '<p class="box_senha chamar_senha">Chame uma senha</p>';
        }else if($senhas->statusPorSenha($_SESSION['senha_chamada']) == "Finalizado"){
            $mensagem = '<p class="box_senha chamar_senha">Chame uma senha</p>';
        }else{
            $mensagem = '<p class="box_senha">'.$_SESSION['senha_chamada'].'</p>';
        }
    }

    //EDITAR INFORMAÇÕES DO ATENDENTE
    if(isset($_POST['editar'])){
        $matricula = $_POST['matricula'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $id = $_POST['id_atendente'];

        $atendente->setMatricula($matricula);
        $atendente->setNome($nome);
        $atendente->setEmail($email);
        if($atendente->alterar($id)){
            $mensagem = '<script>alert("Dados alterados com sucesso!");</script>';
        }else{
            $mensagem = '<script>alert("Ocorreu algum erro");</script>';
        }

        if(isset($_GET['senha'])){
            $senha_atual = $_POST['senha_atual'];
            $nova_senha = $_POST['nova_senha'];
            $atendente->setSenha(md5($nova_senha));
            if ($atendente->alterarSenha($id, md5($senha_atual)) === false){
                $mensagem = '<script>alert("A senha digitada não existe");</script>';
            }else{
                $mensagem = '<script>alert("Dados alterados com sucesso!");</script>';
            }
        }
    }
}
//FAZER LOGOUT
if(isset($_GET['logout']) && $_GET['logout'] == true){
    if($senhas->verificarStatus($atendente->pegarId($_SESSION['atendente'])) == "Em Atendimento"){
        echo "<script>alert('Termine o atendimento antes de sair do sistema.')</script>";
    }else{
        $atendente->logout();
        header("Location: /mase/");
        unset($_SESSION['senha_chamada']);
    }
}