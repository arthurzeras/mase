<?php

require_once "model/Crud.class.php";
require_once "model/Acesso.class.php";

class Usuarios extends Crud implements Acesso{
    protected $table = "tabela_usuarios";
    protected $id = "id_usuario";

    private $matricula;
    private $nome;
    private $perfil;
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

    public function setPerfil($perfil){
        $this->perfil = $perfil;
    }

    public function getPerfil(){
        return $this->perfil;
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

    public function login($matricula, $senha){
        $nome = "";

        //VERIFICAR SE A MATRÍCULA E A SENHA ESTÃO CORRETAS
        $sql = "SELECT * FROM $this->table WHERE matricula = :matricula AND senha_usuario = :senha";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":matricula", $matricula);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();

        //SE ESTIVER CORRETA, RETORNA OS DADOS DO USUÁRIO
        if ($stmt->rowCount() == 1){
            return $stmt->fetch();

            //SE ESTIVER ERRADA, RETORNA FALSO
        }else{
            return false;
        }
    }

    public function logout(){
        unset($_SESSION['atendente']);
        unset($_SESSION['adm']);
        session_destroy();
    }


    public function inserir(){
        $sql = "INSERT INTO $this->table (fk_perfil, matricula, nome_usuario, email_usuario, senha_usuario) VALUES (?,?,?,?,?)";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(1, $this->perfil);
        $stmt->bindParam(2, $this->matricula);
        $stmt->bindParam(3, $this->nome);
        $stmt->bindParam(4, $this->email);
        $stmt->bindParam(5, $this->senha);
        $stmt->execute();

        return true;
    }

    public function alterar($id){
        $sql = "UPDATE $this->table SET fk_perfil = ?, matricula = ?, nome_usuario = ?, email_usuario = ? WHERE $this->id = ?";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(1, $this->perfil);
        $stmt->bindParam(2, $this->matricula, PDO::PARAM_INT);
        $stmt->bindParam(3, $this->nome);
        $stmt->bindParam(4, $this->email);
        $stmt->bindParam(5, $id);
        return $stmt->execute();
    }

    public function alterarSenha($id, $senhaAtual){
        $senha_atual = self::pegarLinha($id);
        if ($senhaAtual != $senha_atual->senha_usuario){
            return false;
        }else{
            $sql = "UPDATE $this->table SET senha_usuario = :senha WHERE $this->id = :id";
            $stmt = BD::prepare($sql);
            $stmt->bindParam(":senha", $this->senha);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;
        }
    }

    public function pegarId($nome){
        $return = "";

        $sql = "SELECT $this->id FROM $this->table WHERE nome_usuario = :nome";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":nome",$nome);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $key){
            $return = $key->id_usuario;
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

    public function validar($id = null){
        $sql = "SELECT * FROM $this->table WHERE email_usuario = :email OR matricula = :matricula";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":matricula", $this->matricula);
        $stmt->execute();
        $result = $stmt->fetch();
        
        if($id != null){
            if(($stmt->rowCount() == 1) && ($result->id_usuario != $id) || ($stmt->rowCount() == 2)){
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

    public function recuperarEmail(){
        $sql = "SELECT * FROM $this->table WHERE email_usuario = :email";
        $stmt = BD::prepare($sql);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if($stmt->rowCount() == 1){
            return true;
        }else{
            return false;
        }
    }
}