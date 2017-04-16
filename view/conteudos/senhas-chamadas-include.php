<?php
require_once "../../classes/Senhas.class.php";

$senhas = new Senhas();
$audio = "<audio controls autoplay hidden>";
$audio .= "<source src='assets/audio/som-chamada.mp3'>";
$audio .= "</audio>";

//SE NAO HOUVER NADA NO BANCO
if($senhas->qtdeSenhas() == 0){
    echo "--";

//SE HOUVER SOMENTE SENHAS COM STATUS = AGUARDANDO
}else if(!in_array("Em Atendimento", $senhas->verificarStatus())){
    if(in_array("Finalizado", $senhas->verificarStatus())){
        echo $senhas->mostrarSenhaChamada();
    }else{
        echo "--";
    }
//SE HOUVER SENHAS QUE JÁ FORAM CHAMADAS
}else if(in_array("Em Atendimento", $senhas->verificarStatus())){
    if(!isset($_COOKIE['senha'])){
        setcookie("senha", $senhas->mostrarSenhaChamada(), time() + 3600);
        echo $_COOKIE['senha'];
    }else if($_COOKIE['senha'] != $senhas->mostrarSenhaChamada()){
        setcookie("senha_2", $senhas->mostrarSenhaChamada(), time() + 3600);
        setcookie("hora", $senhas->pegarHora($senhas->mostrarSenhaChamada()), time() + 3600);
        if($senhas->pegarHora($_COOKIE['senha_2']) == $_COOKIE['hora']){
            echo $senhas->mostrarSenhaChamada();

            if($_COOKIE['senha'] != $senhas->mostrarSenhaChamada()){
                setcookie("senha", $senhas->mostrarSenhaChamada(), time() + 3600);
                echo $audio;
                setcookie("hora", $senhas->pegarHora($senhas->mostrarSenhaChamada()), time() + 3600);
            }
        }
    }else{
        setcookie("hora", $senhas->pegarHora($senhas->mostrarSenhaChamada()), time() + 3600);
        if($senhas->pegarHora($_COOKIE['senha']) != $_COOKIE['hora']){
            echo $audio;
            echo $_COOKIE['senha_2'];
        }else{
            echo $_COOKIE['senha_2'];
        }
    }
}