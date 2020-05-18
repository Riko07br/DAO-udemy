<?php
class Sql extends PDO {
    
    private $conn;    
    
    public function __construct(){
        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", ""); 
    }
    
    //prepara diversos parametros
    private function setParams($statement, $parameters = array()){
        foreach ($parameters as $key => $value) {
            $this->setParam($statement, $key, $value);
        }
    }
    
    //prepara e trata um unico parametro
    private function setParam($statement, $key, $value){
        $statement->bindParam($key, $value);
    }
    
    //metodo para inserir query
    public function query($rawQuery, $params = array()) {
        
        $stmt = $this->conn->prepare($rawQuery);
        
        $this->setParams($stmt, $params);
        
         $stmt->execute();
         
         return $stmt;
    }
    
    //retorna 
    public function select($rawQuery, $params = array()):array {
        $stmt = $this->query($rawQuery, $params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}