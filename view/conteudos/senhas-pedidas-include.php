<?php
require_once "../../classes/Senhas.class.php";

$senhas = new Senhas();

$ultima = $senhas->pegarUltimaSenha();
$idUltima = $senhas->pegarIdSenha($ultima);
$linhas = (int)$senhas->qtdeSenhas();

$_SESSION['ultimasSenhas'] = "";

if($linhas == 1){
    $_SESSION['ultimasSenhas'] = "<p id='#ultimas-senhas'>Última senha pedida: $ultima</p>";
}else if ($linhas == 2){
    $_SESSION['ultimasSenhas'] = "<p id='#ultimas-senhas'>Últimas senhas pedidas: ". ($senhas->pegarSenhaPorId($idUltima - 1)) ." - ". $ultima ."</p>";
}else if ($linhas >= 3){
    $_SESSION['ultimasSenhas'] = "<p id='#ultimas-senhas'>Últimas senhas pedidas: ". ($senhas->pegarSenhaPorId($idUltima - 2)) ." - ". ($senhas->pegarSenhaPorId($idUltima - 1)) ." - ". $ultima ."</p>";
}

echo $_SESSION['ultimasSenhas'];
