<?php 
class Quartier {

    private $conn ;
    private $table_name = "quartier" ;

    public $id ;
    public $nom_quartier ;

    function __construct($bd){
        $this->conn = $bd ;
    }

    function read(){
 
        $query = "SELECT * FROM $this->table_name ";
     
        $stmt = $this->conn->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }

    function read_one(){
        
        $query = "SELECT *
                  FROM $this->table_name 
                  WHERE  nom_quartier = :nom_quartier ";

        $stmt = $this->conn->prepare($query) ;

        $stmt->execute(array(
            "nom_quartier"=>$this->nom_quartier
        )) ;
        
        return $stmt ;
    }

    function read_one_by_id(){
        
        $query = "SELECT *
                  FROM $this->table_name 
                  WHERE  id = :id ";

        $stmt = $this->conn->prepare($query) ;

        $stmt->execute(array(
            "id"=>$this->id
        )) ;
        
        return $stmt ;
    }

    function create(){

        $query = "INSERT INTO $this->table_name (nom_quartier)
        VALUES
        (:nom_quartier) " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "nom_quartier" => $this->nom_quartier 
        ) ;

        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function update(){

        $query = " UPDATE $this->table_name
                   SET nom_quartier = :nom_quartier
                   WHERE id = :id
        " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "nom_quartier" => $this->nom_quartier ,
            "id" => $this->id
        ) ;

        if($stmt->execute($array))
            return true ;
        
        return false ;
    }

    function get_name_quartier() {

        $stmt = $this->read_one_by_id() ;

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        return $nom_quartier ;
    }

    function get_id_quartier() {

        $stmt = $this->read_one() ;

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        return $id ;
    }

}

?>