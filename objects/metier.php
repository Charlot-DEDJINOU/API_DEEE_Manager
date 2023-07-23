<?php 
class Metier{

    private $conn;
    private $table_name = "metier";
 
    public $id;
    public $designation;

 
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
                  WHERE  designation = :designation ";

        $stmt = $this->conn->prepare($query) ;

        $stmt->execute(array(
            "designation"=>$this->designation
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

        $query = "INSERT INTO $this->table_name (designation)
        VALUES
        (:designation) " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "designation" => $this->designation 
        ) ;

        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function update(){

        $query = " UPDATE $this->table_name
                   SET designation = :designation
                   WHERE id = :id
        " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "designation" => $this->designation ,
            "id" => $this->id
        ) ;

        if($stmt->execute($array))
            return true ;
        
        return false ;
    }

    function get_name_metier() {

        $stmt = $this->read_one_by_id() ;

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        return $designation ;
    }

    function get_id_metier() {

        $stmt = $this->read_one() ;

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        return $id ;
    }

}
?>