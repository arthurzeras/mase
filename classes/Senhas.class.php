<?php

require "BD.class.php";

class Senhas extends BD{

    public function qtdeSenhas(){
        $sql = "SELECT senha FROM tabela_senhas";
        $stmt = BD::prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function pegarSenhaPorId($idSenha){
        $result = "";

        $sql = "SELECT senha FROM tabela_senhas WHERE id_senha = :senha";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":senha", $idSenha);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $key) {
            $result = $key->senha;
        }

        return $result;
    }

    public function pegarUltimaSenha($tipoDeSenha = null){
        $ultima_senha = 0;

        if($tipoDeSenha == "Normal"){
            $sql = "SELECT senha FROM tabela_senhas WHERE id_senha = (SELECT MAX(id_senha) FROM tabela_senhas WHERE tipo_senha = 'Normal')";
        }else if($tipoDeSenha == "Preferencial"){
            $sql = "SELECT senha FROM tabela_senhas WHERE id_senha = (SELECT MAX(id_senha) FROM tabela_senhas WHERE tipo_senha = 'preferencial')";
        }else if($tipoDeSenha ==  null){
            $sql = "SELECT senha FROM tabela_senhas WHERE id_senha = (SELECT MAX(id_senha) FROM tabela_senhas)";
        }

        $stmt = BD::prepare($sql);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $key) {
           $ultima_senha = $key->senha;
        }

        return $ultima_senha;
    }

    public function pegarIdSenha($senha){
        $result = 0;

        $sql = "SELECT id_senha from tabela_senhas WHERE senha = :senha";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":senha",$senha);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $key){
            $result = $key->id_senha;
        }

        return $result;
    }

    public function inserir($senha,$tipoDeSenha){
        $sql = "INSERT INTO tabela_senhas (senha,status,tipo_senha) VALUES (:senha, 'Aguardando', :tipo)";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":tipo", $tipoDeSenha);

        return $stmt->execute();
    }

    public function pedirSenha($tipoDeAtendimento){
        $ultimaSenha = self::pegarUltimaSenha($tipoDeAtendimento);
        $ultimaSenhaNumero = explode("-", $ultimaSenha);

        if($ultimaSenha == "0"){
            $ultimaSenhaNumero[1] = 0;
        }

        if($tipoDeAtendimento == "Normal"){
            $ultimaSenhaNumero[1]++;
            $ultimaSenha = "N-".$ultimaSenhaNumero[1];

        }else if($tipoDeAtendimento == "Preferencial"){
            $ultimaSenhaNumero[1]++;
            $ultimaSenha = "P-".$ultimaSenhaNumero[1];
        }

        self::inserir($ultimaSenha,$tipoDeAtendimento);
        return self::pegarUltimaSenha($tipoDeAtendimento);
    }

    public function alterarStatus($status,$id_senha){
        $sql = "UPDATE tabela_senhas SET status = '$status' WHERE id_senha = $id_senha";
        $stmt = BD::prepare($sql);
        $stmt->execute();
    }

    public function chamarTipoSenha($tipoSenha){
        $result = "";

        $sql = "SELECT senha FROM tabela_senhas WHERE status = 'Aguardando' AND tipo_senha = :tipo ORDER BY MAX(id_senha)";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":tipo",$tipoSenha);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $key) {
            $result = $key->senha;
        }

        return $result;
    }

    public function chamarSenha(){
        $status = "";

        //VERIFICAR SE HÁ ALGUM PREFERENCIAL
        $sql = "SELECT senha FROM tabela_senhas WHERE status = 'Aguardando' AND tipo_senha = 'Preferencial'";
        $stmt = BD::prepare($sql);
        $stmt->execute();
        $preferencial = $stmt->rowCount();

        //CONDIÇÕES DE CHAMADAS PARA SENHA PREFERENCIAL OU NORMAL
        if($preferencial == 0){
            $aguardando = self::chamarTipoSenha("Normal");
        }else{
            $aguardando = self::chamarTipoSenha("Preferencial");
        }

        //PEGAR O ID DA SENHA PARA ATUALIZAR O STATUS DA SENHA ANTERIOR
        $id_senha = self::pegarIdSenha($aguardando);

        //VERIFICAR O STATUS DA SENHA
        $id_senha_status = $id_senha -1;
        $sql = "SELECT status FROM tabela_senhas WHERE id_senha = $id_senha_status";
        $stmt = BD::prepare($sql);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $key){
            $status = $key->status;
        }

        //ALTERAR O STATUS DA SENHA ANTERIOR PARA FINALIZADO
        if ($status == "Em Atendimento"){
            self::alterarStatus('Finalizado', $id_senha_status);
        }

        //ALTERAR O STATUS DE: AGUARDANDO PARA: EM ATENDIMENTO
        self::alterarStatus('Em Atendimento', $id_senha);

        return $aguardando;
    }
}