<?php require_once "classes/Crud.class.php";

class TipoAtendimento extends Crud{
    protected $table = "tabela_tipo_atendimento";
    protected $id = "id_tipo_atendimento";
    private $nome_atendimento;

    public function setNomeAtendimento($nome_atendimento){
        $this->nome_atendimento = $nome_atendimento;
    }
    public function getNomeAtendimento(){
        return $this->nome_atendimento;
    }

    public function inserir(){
        $sql = "INSERT INTO $this->table (nome_tipo) VALUE (:nome_atendimento)";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":nome_atendimento", $this->nome_atendimento);
        $stmt->execute();

        return true;
    }

    public function alterar($id_upd){
        $sql = "UPDATE $this->table SET nome_tipo = :nome_atendimento WHERE $this->id = :id";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":nome_atendimento", $this->nome_atendimento);
        $stmt->bindParam(":id", $id_upd);
        return $stmt->execute();
    }

    public function pegarId($nome){
        $return = "";
        $sql = "SELECT $this->id FROM $this->table WHERE nome_tipo = :nome";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->execute();

        foreach($stmt->fetchAll() as $key => $value){
            $return = $value->id_tipo_atendimento;
        }

        return $return;
    }
}