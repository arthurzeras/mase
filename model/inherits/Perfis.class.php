<?php require_once "model/Crud.class.php";

class Perfis extends Crud{
    protected $table = "tabela_perfis";
    protected $id = "id_perfil";
    
    private $nome;
    
    public function setNome($nome){
        $this->nome = $nome;
    }
    
    public function getNome(){
        return $nome;
    }
    
    public function inserir(){
        $sql = "INSERT INTO $this->table (nome_perfil) VALUE (?)";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(1, $this->nome);
        $stmt->execute();

        return true;
    }
    
    public function alterar($id_upd){
        $sql = "UPDATE $this->table SET nome_perfil = ? WHERE $this->id = ?";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(1, $this->nomes);
        $stmt->bindParam(2, $id_upd);
        return $stmt->execute();
    }
    
    public function validar($id = null){
        
    }
    
    public function pegarId($nome){
        $return = "";
        $sql = "SELECT $this->id FROM $this->table WHERE nome_perfil = ?";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(1, $nome);
        $stmt->execute();

        foreach($stmt->fetchAll() as $key => $value){
            $return = $value->id_perfil;
        }

        return $return;
    }
}
