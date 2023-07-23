<?php 
class Materiel{

    private $conn ;
    private $table_name = "materiel" ;

    public $id ;
    public $designation ;
    public $prix_unitaire ;
    public $etat ;
    public $type ;
    public $url_image ;
    public $caracteristique ;
    public $quantite_stock ;
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

        $query = "INSERT INTO $this->table_name (designation , etat , `type` , prix_unitaire , `image` , caracteristique , quantite_stock , publier )
                  VALUES
                  (:designation , :etat , :typ , :prix_unitaire , :img , :caracteristique , :quantite_stock , :publier) " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "designation" => $this->designation ,
            "etat" => $this->etat ,
            "typ" => $this->type ,
            "prix_unitaire" => $this->prix_unitaire ,
            "img" => $this->url_image ,
            "caracteristique" => $this->caracteristique ,
            "quantite_stock" => $this->quantite_stock ,
            "publier" => $this->publier
        ) ;

        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function update(){

        $query = "UPDATE $this->table_name
                  SET designation=:designation , etat=:etat , `type`=:typ , prix_unitaire=:prix_unitaire , `image`=:img , caracteristique=:caracteristique , quantite_stock=:quantite_stock , publier=:publier
                  WHERE id=:id
        " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "designation" => $this->designation ,
            "etat" => $this->etat ,
            "typ" => $this->type ,
            "prix_unitaire" => $this->prix_unitaire ,
            "img" => $this->url_image ,
            "caracteristique" => $this->caracteristique ,
            "quantite_stock" => $this->quantite_stock ,
            "publier" => $this->publier ,
            "id" => $this->id
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