<?php

class Usuario {
    
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;
    
    //magic methods/////////////////////////////////////
    public function __construct($login = "", $senha = ""){
        $this->setDeslogin($login);
        $this->setDessenha($senha);
    }
    
    
    
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
    
    //funções estaticas//////////////////////////////////////////////
    public static function search($login) {
        $sql = new Sql();
        
        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY idusuario", array(":SEARCH" => "%".$login."%"));
    }
   
    //como não tem o 'this' pode ser um metodo solto
    //não precisando instanciar um 'usuario' para chama-lo
    public static function getList(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios ORDER BY idusuario;");
    }
    
    //funções publicas/////////////////////////////////////////////
    public function setDados($dados) {
        
        $this->setIdusuario($dados["idusuario"]);
        $this->setDeslogin($dados["deslogin"]);
        $this->setDessenha($dados["dessenha"]);
        $this->setDtcadastro(new DateTime($dados["dtcadastro"]));
    }
    
    
    public function loadById($id) {
        $sql =  new Sql();
        
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ":ID" => $id));
        
        if(count($result) > 0)
            $this->setDados($result[0]);
        
    }
    
    
    
    public function login($login, $password){
        $sql =  new Sql();
        
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :SENHA", array(
            ":LOGIN"=>$login,
            ":SENHA"=>$password));
        
        if(count($result) > 0)
            $this->setDados($result[0]);
        else
            throw new Exception("Login ou senha tão errado");        
    }
    
    //insere usuario novo
    public function insert() {
        $sql = new Sql();
        
        $result = $sql->select("CALL sp_usuarios_insert (:LOGIN, :PASSWORD)", array(
            ":LOGIN"=>$this->getDeslogin(),
            ":PASSWORD"=>$this->getDessenha()
        ));
        
        if(count($result) > 0)
            $this->setDados($result[0]);
        else 
            throw new Exception("resultados vazios ou nao inseridos");
    }
    
    public function update($login, $senha){
        $sql = new Sql();
        
        $this->setDeslogin($login);
        $this->setDessenha($senha);
        
        $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :SENHA WHERE idusuario = :ID", array(
            ":LOGIN"=>$this->getDeslogin(),
            ":SENHA"=>$this->getDessenha(),
            ":ID"=>$this->getIdusuario()
        ));
    }
    
    public function delete() {
        $sql = new Sql();
        
        $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
            ":ID"=>$this->getIdusuario()
        ));
        
        $this->setIdusuario(0);
        $this->setDeslogin("");
        $this->setDessenha("");
        $this->setDtcadastro(new DateTime());
    }
    
}