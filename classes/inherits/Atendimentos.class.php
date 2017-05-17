<?php
require_once "classes/Crud.class.php";

class Atendimentos extends Crud{
    protected $table = "tabela_atendimentos";
    protected $id = "id_atendimentos";

    private $atendente;
    private $tipo_atendimento;
    private $duracao;
    private $data_atendimento;

    public function setAtendente($atendente){
        $this->atendente = $atendente;
    }

    public function getAtendente(){
        return $this->atendente;
    }

    public function setTipoAtendimento($tipo_atendimento){
        $this->tipo_atendimento = $tipo_atendimento;
    }

    public function getTipoAtendimento(){
        return $this->tipo_atendimento;
    }

    public function setDuracao($duracao){
        $this->duracao = $duracao;
    }

    public function getDuracao(){
        return $this->duracao;
    }

    public function setDataAtendimento($data_atendimento){
        $this->data_atendimento = $data_atendimento;
    }

    public function getDataAtendimento(){
        return $this->data_atendimento;
    }


    public function inserir(){
        $sql = "INSERT INTO $this->table (fk_atendente, fk_tipo_atendimento, duracao_atendimento, data_atendimento) VALUES (?,?,?,?)";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(1, $this->atendente);
        $stmt->bindParam(2, $this->tipo_atendimento);
        $stmt->bindParam(3, $this->duracao);
        $stmt->bindParam(4, $this->data_atendimento);
        $stmt->execute();
        return true;
    }

    public function alterar($id){

    }
    
    public function validar($id = null){
        
    }
}