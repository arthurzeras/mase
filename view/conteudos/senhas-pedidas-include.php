<?php
require_once "../../classes/Senhas.class.php";

$senhas = new Senhas();

$ultima = $senhas->pegarUltimaSenha();
$idUltima = $senhas->pegarIdSenha($ultima);
$linhas = (int)$senhas->qtdeSenhas();

$_SESSION['ultimasSenhas'] = "";

if($linhas == 1){
    $_SESSION['ultimasSenhas'] = "<p id='ultimas_senhas'>$ultima</p>";
}else if ($linhas == 2){
    $_SESSION['ultimasSenhas'] = "<p id='ultimas_senhas'>". ($senhas->pegarSenhaPorId($idUltima - 1)) ." <span class='divisor'>&#8226;</span> ". $ultima ."</p>";
}else if ($linhas >= 3){
    $_SESSION['ultimasSenhas'] = "<p id='ultimas_senhas'>". ($senhas->pegarSenhaPorId($idUltima - 2)) ." <span class='divisor'>&#8226;</span> ". ($senhas->pegarSenhaPorId($idUltima - 1)) ." <span class='divisor'>&#8226;</span> ". $ultima ."</p>";
}

echo $_SESSION['ultimasSenhas'];
