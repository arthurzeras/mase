<?php
require_once "classes/Senhas.class.php";
require_once "classes/Acesso.class.php";
require_once "classes/inherits/TipoAtendimento.class.php";
require_once "classes/inherits/Atendentes.class.php";
require_once "classes/inherits/Atendimentos.class.php";

$senhas = new Senhas();
$acesso = new Acesso();
$atendente = new Atendentes();
$tipoAtendimento = new TipoAtendimento();
$atendimento = new Atendimentos();

$senha_chamada = "";
$mensagem = "";
$botao = "<input type='submit' value='Chamar próxima senha' name='chamar'>";

if(isset($_SESSION['atendente'])){

    //SE NAO HOUVER SENHAS NO BANCO DE DADOS
    if ($senhas->qtdeSenhas() == 0){
        $mensagem = "Não há senha para ser chamada.";


    //SE O ATENDENTE CLICOU NO BOTAO DE CHAMAR SENHA
    }else if(isset($_POST['chamar'])){
        $botao = "<input type='submit' value='Chamar senha novamente' name='chamar_novamente'>";

        //SE NÃO HÁ NENHUMA SENHA COM STATUS AGUARDANDO
        if(!in_array("Aguardando",$senhas->verificarStatus())){
            $mensagem = "Não há senha para ser chamada.";
            $botao = "<input type='submit' value='Chamar próxima senha' name='chamar'>";

        //SE EXISTIR SENHAS COM STATUS DIFERENTE DE EM ATENDIMENTO ELE CHAMA A SENHA
        }else if($senhas->verificarStatus($atendente->pegarId($_SESSION['atendente'])) != "Em Atendimento") {
            $hora_atual = date("H:i:s");
            $_SESSION['hora_inicial'] = $hora_atual;
            $senha_chamada = $senhas->chamarSenha($atendente->pegarId($_SESSION['atendente']), $hora_atual);
            $_SESSION['senha_chamada'] = $senha_chamada;
            $mensagem = "Você chamou a senha: ".$_SESSION['senha_chamada'];

        //
        }else{
            $botao = "<input type='submit' value='Chamar ".$_SESSION['senha_chamada']." novamente' name='chamar_novamente'>";
            $mensagem = "Você está atendendo a senha: ".$_SESSION['senha_chamada'];
        }
    }else if(isset($_POST['chamar_novamente'])){
        $hora_atual = date("H:i:s");
        $senha_chamada = $senhas->chamarNovamente($_SESSION['senha_chamada'], $hora_atual);
        $_SESSION['senha_chamada'] = $senha_chamada;
        $botao = "<input type='submit' value='Chamar ".$_SESSION['senha_chamada']." novamente' name='chamar_novamente'>";
        $mensagem = "Você chamou a senha: ".$_SESSION['senha_chamada'];
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
        $mensagem = "Chame uma senha";
    }else{
        //PEGAR A SENHA CHAMADA E JOGAR NA SESSÃO PARA SER MOSTRADA MESMO QUE ATUALIZE A PÁGINA
        if (!isset($_SESSION['senha_chamada'])){
            $mensagem = "Chame uma senha";
        }else{
            $mensagem = "Você está atendendo a senha: ".$_SESSION['senha_chamada'];
        }
    }
}
//FAZER LOGOUT
if(isset($_GET['logout']) && $_GET['logout'] == true){
    if($senhas->verificarStatus($atendente->pegarId($_SESSION['atendente'])) == "Em Atendimento"){
        echo "<script>alert('Termine o atendimento antes de sair do sistema.')</script>";
    }else{
        $acesso->logout();
        header("Location: /mase/");
        unset($_SESSION['senha_chamada']);
    }
}