<?php
require_once "model/Crud.class.php";

class Guiches extends Crud{
    protected $table = "tabela_guiches";
    protected $id = "id_guiche";
    private $ip;
    private $guiche;

    public function setIp($ip){
        $this->ip = $ip;
    }
    public function getIp(){
        return $this->ip;
    }
    public function setGuiche($guiche){
        $this->guiche = $guiche;
    }
    public function getGuiche(){
        return $this->guiche;
    }

    public function inserir(){
        $sql = "INSERT INTO $this->table (ip_maquina, numero_guiche) VALUES (:ip, :guiche)";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":ip", $this->ip);
        $stmt->bindParam(":guiche", $this->guiche);
        $stmt->execute();
        return true;
    }

    public function alterar($id){
        $sql = "UPDATE $this->table SET ip_maquina = :ip, numero_guiche = :guiche WHERE $this->id = :id";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":ip", $this->ip);
        $stmt->bindParam(":guiche", $this->guiche);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    
    public function validar($id = null){
        $sql = "SELECT * FROM $this->table WHERE ip_maquina = :ip OR numero_guiche = :num";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":ip", $this->ip);
        $stmt->bindParam(":num", $this->guiche);
        $stmt->execute();
        $result = $stmt->fetch();
        
        if($id != null){
            if((($stmt->rowCount() == 1) && ($result->id_guiche != $id)) || ($stmt->rowCount() == 2)){
                return false;
            }else{
                return true;
            }
        }else{
            if($stmt->rowCount() > 0){
                return false;
            }else{
                return true;
            }
        }
    }

    public function pegarId($ip){
        $sql = "SELECT $this->id FROM $this->table WHERE ip_maquina = :ip";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":ip", $ip);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result->id_guiche;
    }
}