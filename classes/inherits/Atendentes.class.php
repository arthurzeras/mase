<?php

require_once "classes/Crud.class.php";

class Atendentes extends Crud{
    protected $table = "tabela_atendentes";
    protected $id = "id_atendente";

    private $matricula;
    private $nome;
    private $email;
    private $senha;

    public function setMatricula($matricula){
        $this->matricula = $matricula;
    }

    public function getMatricula(){
        return $this->matricula;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function inserir(){
        $sql = "INSERT INTO $this->table (matricula, nome_atendente, email_atendente, senha_atendente) VALUES (:matricula, :nome, :email ,:senha)";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":matricula", $this->matricula);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $this->senha);
        $stmt->execute();

        return true;
    }

    public function alterar($id){
        $sql = "UPDATE $this->table SET matricula = :matricula, nome_atendente = :nome, email_atendente = :email WHERE $this->id = :id";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":matricula", $this->matricula, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function alterarSenha($id, $senhaAtual){
        $senha_atual = self::pegarLinha($id);
        if ($senhaAtual != $senha_atual->senha_atendente){
            return false;
        }else{
            $sql = "UPDATE $this->table SET senha_atendente = :senha WHERE $this->id = :id";
            $stmt = BD::prepare($sql);
            $stmt->bindParam(":senha", $this->senha);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;
        }
    }

    public function pegarId($nome){
        $return = "";

        $sql = "SELECT $this->id FROM $this->table WHERE nome_atendente = :nome";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":nome",$nome);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $key){
            $return = $key->id_atendente;
        }

        return $return;
    }

    public function verificarDisponibilidade($coluna, $valor){
        $sql = "SELECT * FROM $this->table WHERE $coluna = :valor";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":valor", $valor);
        $stmt->execute();
        return $stmt->rowCount();
    }

}