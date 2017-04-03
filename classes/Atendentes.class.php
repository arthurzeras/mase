<?php

require "BD.class.php";

class Atendentes extends BD{


    //FAZER LOGIN
    public function login($matricula, $senha){
        $nome = "";

        //VERIFICAR SE A MATRÍCULA E A SENHA ESTÃO CORRETAS
        $sql = "SELECT nome_atendente FROM tabela_atendentes WHERE matricula = :matricula AND senha_atendente = :senha";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":matricula", $matricula);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();

        //SE ESTIVER CORRETA, RETORNA O NOME DO ATENDENTE
        if ($stmt->rowCount() == 1){
            foreach ($stmt->fetchAll() as $key){
                $nome = $key->nome_atendente;
            }

            return $nome;

        //SE ESTIVER ERRADA, RETORNA FALSO
        }else{
            return false;
        }
    }

    //FAZER LOGOUT
    public function logout(){
        unset($_SESSION['atendente']);
        session_destroy();
    }
}