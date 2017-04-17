<?php
require_once "BD.class.php";

class Atendimentos extends BD{
    private $table = "tabela_atendimentos";

    public function formatarVariavel($tipo){
        $tipoMinimizado = strtolower($tipo); //CONVERTE OS CARACTERES PARA MINUSCULOS
        return str_replace(" ", "_", $tipoMinimizado); //CONVERTE OS ESPAÇOS PARA UNDERLINE
    }

    public function inserirColuna($nomeTipoAtendimento){
        $sql = "ALTER TABLE $this->table ADD quantidade_$nomeTipoAtendimento VARCHAR(255) NULL";
        $stmt = BD::prepare($sql);
        $stmt->execute();
    }

    public function deletarColuna($nomeTipoAtendimento){
        $sql = "ALTER TABLE $this->table DROP quantidade_$nomeTipoAtendimento";
        $stmt = BD::prepare($sql);
        $stmt->execute();
    }
}