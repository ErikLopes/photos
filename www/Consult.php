<?php

include_once('Connection.php');

class Consult {
    
    private $limitMax = 10;
    private $limitMin = 0;
    private $idCategory;
    private $Con;
    
    function __construct() {
       $this->Con = new Connection();
    }
    
    public function getLimitMax() {
        return $this->limitMax;
    }

    public function getLimitMin() {
        return $this->limitMin;
    }

    public function setLimitMax($limitMax) {
        $this->limitMax = $limitMax;
    }

    public function setLimitMin($limitMin) {
        $this->limitMin = $limitMin;
    }
    
    public function getIdCategory() {
        return $this->idCategory;
    }

    public function setIdCategory($idCategory) {
        $this->idCategory = $idCategory;
    }   
    
    public function getImages(){
        
        try{
            $query = "SELECT * FROM images WHERE active = true limit :limitMin, :limitMax ";
       
            $stmt = $this->Con->prepare($query);
            $stmt->bindParam(':limitMin', $this->limitMin, PDO::PARAM_INT);
            $stmt->bindParam(':limitMax', $this->limitMax, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }  catch (Exception $ex){
            error_log('[Consulta][getImages]-> '.$ex->getMessage());
        }
    }
    
}
