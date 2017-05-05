<?php
require_once "BD.class.php";


abstract class Crud{
    protected $table;
    protected $id;

    abstract public function inserir();
    abstract public function alterar($id);

    public function pegarLinha($id){
        $sql = "SELECT * FROM $this->table WHERE $this->id = :id";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function pegarTudo(){
        $sql = "SELECT * FROM $this->table";
        $stmt = BD::prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function excluir($id){
        $sql = "DELETE FROM $this->table WHERE $this->id = :id";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }

    public function pegarTudoLinhas(){
        $sql = "SELECT * FROM $this->table";
        $stmt = BD::prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }
}