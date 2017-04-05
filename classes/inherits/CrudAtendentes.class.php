<?php

require "classes/Crud.class.php";

class CrudAtendentes extends Crud{
    protected $table = "tabela_atendentes";
    protected $id = "id_atendente";

    private $matricula;
    private $nome;
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

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function inserir(){
        $sql = "INSERT INTO $this->table (matricula, nome_atendente, senha_atendente) VALUES (:matricula, :nome, :senha)";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":matricula", $this->matricula);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":senha", $this->senha);
        $stmt->execute();

        return true;
    }

    public function alterar($id){
        $sql = "UPDATE $this->table SET matricula = :matricula, nome_atendente = :nome WHERE $this->id = :id";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":matricula", $this->matricula, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

}