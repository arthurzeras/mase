<?php
require_once "BD.class.php";

class Senhas{
    private $tabela = "tabela_senhas";

    public function qtdeSenhas(){
        $sql = "SELECT senha FROM $this->tabela";
        $stmt = BD::prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function pegarSenhaPorId($idSenha){
        $sql = "SELECT senha FROM $this->tabela WHERE id_senha = :senha";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":senha", $idSenha);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result->senha;
    }

    public function pegarUltimaSenha($tipoDeSenha = null){
        if($tipoDeSenha == "Normal"){
            $sql = "SELECT senha FROM $this->tabela WHERE id_senha = (SELECT MAX(id_senha) FROM $this->tabela WHERE tipo_senha = 'Normal')";
        }else if($tipoDeSenha == "Preferencial"){
            $sql = "SELECT senha FROM $this->tabela WHERE id_senha = (SELECT MAX(id_senha) FROM $this->tabela WHERE tipo_senha = 'preferencial')";
        }else if($tipoDeSenha ==  null){
            $sql = "SELECT senha FROM $this->tabela WHERE id_senha = (SELECT MAX(id_senha) FROM $this->tabela)";
        }

        $stmt = BD::prepare($sql);
        $stmt->execute();
        $ultima_senha = $stmt->fetch();

        return $ultima_senha->senha;
    }

    public function pegarIdSenha($senha){
        $sql = "SELECT id_senha from $this->tabela WHERE senha = :senha";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":senha",$senha);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result->id_senha;
    }

    public function inserir($senha,$tipoDeSenha){
        $sql = "INSERT INTO $this->tabela (senha,status,tipo_senha) VALUES (:senha, 'Aguardando', :tipo)";
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

    public function alterarStatus($status, $id_senha, $usuario = null, $hora){
        $sql = "UPDATE $this->tabela SET status = ?, fk_usuario = ?, hora_chamada = ? WHERE id_senha = ?";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(1, $status);
        $stmt->bindParam(2, $usuario);
        $stmt->bindParam(3, $hora);
        $stmt->bindParam(4, $id_senha);
        $stmt->execute();
    }

    public function statusPorSenha($senha){
        $sql = "SELECT status FROM $this->tabela WHERE senha = :senha";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result->status;
    }

    public function verificarStatus($usuario = null){
        if($atendente != null){
            $sql = "SELECT status FROM $this->tabela WHERE fk_usuario = ?";
            $stmt = BD::prepare($sql);
            $stmt->bindParam(1, $usuario);
            $stmt->execute();
            $result = $stmt->fetch();

            return $result->status;

        }else{
            $sql = "SELECT status FROM $this->tabela";
            $stmt = BD::prepare($sql);
            $stmt->execute();

            $status_senha = $stmt->fetchAll();
            $array_status = array();
            $i = 0;
            foreach ($status_senha as $key => $value){
                $array_status[$i] = $value->status;
                $i++;
            }

            return $array_status;
        }
    }

    public function chamarTipoSenha($tipoSenha){
        $sql = "SELECT senha FROM $this->tabela WHERE status = 'Aguardando' AND tipo_senha = :tipo ORDER BY MAX(id_senha)";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":tipo",$tipoSenha);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result->senha;
    }

    public function chamarSenha($atendente, $hora){
        //VERIFICAR SE HÁ ALGUM PREFERENCIAL
        $sql = "SELECT senha FROM $this->tabela WHERE status = 'Aguardando' AND tipo_senha = 'Preferencial'";
        $stmt = BD::prepare($sql);
        $stmt->execute();
        $preferencial = $stmt->rowCount();

        //CONDIÇÕES DE CHAMADAS PARA SENHA PREFERENCIAL OU NORMAL
        if($preferencial == 0){
            $senha = self::chamarTipoSenha("Normal");
        }else{
            $senha = self::chamarTipoSenha("Preferencial");
        }

        $id_senha = self::pegarIdSenha($senha);

        //ALTERAR O STATUS DE: AGUARDANDO PARA: EM ATENDIMENTO
        self::alterarStatus('Em Atendimento', $id_senha, $atendente, $hora);

        return $senha;
    }

    public function chamarNovamente($senha, $hora){
        $sql = "UPDATE $this->tabela SET hora_chamada = :hora WHERE senha = :senha";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":hora", $hora);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();

        return $senha;
    }

    public function finalizarAtendimento($senha){
        $sql = "UPDATE $this->tabela SET status = 'Finalizado' WHERE senha = :senha";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();
    }

    public function mostrarSenhaChamada(){
        $sql = "SELECT senha FROM $this->tabela WHERE hora_chamada = (SELECT MAX(hora_chamada) FROM tabela_senhas)";
        $stmt = BD::prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result->senha;
    }

    public function pegarHora($senha){
        $sql = "SELECT hora_chamada FROM $this->tabela WHERE senha = :senha";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result->hora_chamada;
    }
}