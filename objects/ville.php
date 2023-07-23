<?php 
class Ville{

    private $conn;
    private $table_name = "ville";
 
    public $id;
    public $nom_ville;

 
    public function __construct($db){
        $this->conn = $db;
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
                  WHERE  nom_ville = :nom_ville ";

        $stmt = $this->conn->prepare($query) ;

        $stmt->execute(array(
            "nom_ville"=>$this->nom_ville
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

        $query = "INSERT INTO $this->table_name (nom_ville)
        VALUES
        (:nom_ville) " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "nom_ville" => $this->nom_ville 
        ) ;

        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function update(){

        $query = " UPDATE $this->table_name
                   SET nom_ville = :nom_ville
                   WHERE id = :id
        " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "nom_ville" => $this->nom_ville ,
            "id" => $this->id
        ) ;

        if($stmt->execute($array))
            return true ;
        
        return false ;
    }

    function get_name_ville() {

        $stmt = $this->read_one_by_id() ;

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        return $nom_ville ;
    }

    function get_id_ville() {

        $stmt = $this->read_one() ;

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        return $id ;
    }

}
?>