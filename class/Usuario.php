<?php

class Usuario {
    
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;
    
    //magic methods/////////////////////////////////////
    public function __toString(){
        
        return json_encode(array(            
            "idusuario"=>$this->getIdusuario(),    
            "deslogin"=> $this->getDeslogin(),
            "dessenha"=> $this->getDessenha(),
            "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
        ));        
    }    
    
    
    //getters e setters//////////////////////////////////
    public function getIdusuario(){
        return $this->idusuario;
    }

    public function getDeslogin(){
        return $this->deslogin;
    }

    public function getDessenha(){
        return $this->dessenha;
    }

    public function getDtcadastro(){
        return $this->dtcadastro;
    }

    public function setIdusuario($idusuario){
        $this->idusuario = $idusuario;
    }

    public function setDeslogin($deslogin){
        $this->deslogin = $deslogin;
    }

    public function setDessenha($dessenha){
        $this->dessenha = $dessenha;
    }

    public function setDtcadastro($dtcadastro){
        $this->dtcadastro = $dtcadastro;
    }
    
    ///////////////////////////////////////////////
    
    public function loadById($id) {
        $sql =  new Sql();
        
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID" => $id));
        
        if(count($result) > 0){
            $row = $result[0];           
            
            $this->setIdusuario($row["idusuario"]);
            $this->setDeslogin($row["deslogin"]);
            $this->setDessenha($row["dessenha"]);
            $this->setDtcadastro(new DateTime($row["dtcadastro"]));
        }
    }
    
    //como não tem o 'this' pode ser um metodo solto
    //não precisando instanciar um 'usuario' para chama-lo
    public static function getList(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios ORDER BY idusuario;");
    }
    
    public static function search($login) {
        $sql = new Sql();
        
        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY idusuario", array(":SEARCH" => "%".$login."%"));
    }
    
    public function login($login, $password){
        $sql =  new Sql();
        
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :SENHA", array(
            ":LOGIN"=>$login,
            ":SENHA"=>$password));
        
        if(count($result) > 0){
            $row = $result[0];
            
            $this->setIdusuario($row["idusuario"]);
            $this->setDeslogin($row["deslogin"]);
            $this->setDessenha($row["dessenha"]);
            $this->setDtcadastro(new DateTime($row["dtcadastro"]));
        }else {
            
            throw new Exception("Login ou senha tão errado");
        }
    }
}