<?php 
class Lieu_depot{

    private $conn ;
    private $table_name = "lieux_depot" ;

    public $id ;
    public $id_quartier ;
    public $id_ville ;
    public $nom ;
    public $longitude ;
    public $latitude ;
    public $repere ;
    public $url_image ;
    public $description ;
    public $publier = 0;

    function __construct($bd){
        $this->conn = $bd ;
    }

    function read(){
 
        $query = "SELECT * FROM $this->table_name ";
     
        $stmt = $this->conn->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
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

        $query = "INSERT INTO $this->table_name (id_quartier , id_ville , nom , longitude , latitude , `image` , `description` , repere , publier )
                  VALUES
                  (:id_quartier , :id_ville , :nom , :longitude , :latitude , :img , :decris , :repere , :publier) " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "id_quartier" => $this->id_quartier ,
            "id_ville" => $this->id_ville ,
            "nom" => $this->nom ,
            "longitude" => $this->longitude ,
            "latitude" => $this->latitude ,
            "img" => $this->url_image ,
            "decris" => $this->description ,
            "repere" => $this->repere ,
            "publier" => $this->publier
        ) ;

        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function update(){

        $query = "UPDATE $this->table_name
                  SET id_quartier=:id_quartier , id_ville=:id_ville , nom=:nom , longitude=:longitude , latitude=:latitude , `image`=:img , `description`=:decris , repere=:repere , publier=:publier
                  WHERE id=:id
        " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "id" => $this->id ,
            "id_quartier" => $this->id_quartier ,
            "id_ville" => $this->id_ville ,
            "nom" => $this->nom ,
            "longitude" => $this->longitude ,
            "latitude" => $this->latitude ,
            "img" => $this->url_image ,
            "decris" => $this->description ,
            "repere" => $this->repere ,
            "publier" => $this->publier
        ) ;


        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function delete(){

        $query = "UPDATE $this->table_name SET publier = 0
                  WHERE id = :id ";

        $stmt = $this->conn->prepare($query) ;

        $array=array(
            "id" => $this->id
        ) ;
        
        if($stmt->execute($array))
            return true ;

        return false ;
    }
}
?>