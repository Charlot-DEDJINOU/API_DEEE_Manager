<?php 
class Ville_quartier {

    private $conn ;
    private $table_name = "ville_quartier" ;

    public $id_ville ;
    public $id_quartier ;

    function __construct($db)
    {
        $this->conn = $db ;
    }

    function get_ville()
    {
        $query = "SELECT id_ville FROM $this->table_name
                WHERE id_quartier = :id_quartier
        " ;

        $array = array(
            "id_quartier" => $this->id_quartier
        ) ;

        $stmt = $this->conn->prepare($query) ;

        $stmt->execute($array) ;

        return $stmt ;
    }

    function read_one()
    {
        $query = "SELECT id_ville , id_quartier FROM ville_quartier
                  WHERE id_ville = :id_ville AND id_quartier = :id_quartier
        " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "id_quartier" => $this->id_quartier ,
            "id_ville" => $this->id_ville
        ) ;

        $stmt->execute($array) ;

        return $stmt ;
    }

    function create()
    {
        $query = "INSERT INTO $this->table_name
                  VALUES
                  (:id_ville , :id_quartier)
        " ;

        $array = array(
            "id_quartier" => $this->id_quartier ,
            "id_ville" => $this->id_ville
        ) ;

        $stmt = $this->conn->prepare($query) ;

        if($stmt->execute($array))
            return true ;
        return false ;
    }
}

?>