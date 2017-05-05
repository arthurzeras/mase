<?php

require_once "BD.class.php";

interface Acesso{
    //FAZER LOGIN
    public function login($matricula, $senha);

    //FAZER LOGOUT
    public function logout();
}