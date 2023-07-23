<?php
class Utilisateur{
 
    private $conn;
    private $table_name = "utilisateur";
 
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $motdepasse;
    public $admin;
    public $contact ;
    public $adresse ;
    public $statut = 0 ;
 
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
                  WHERE  email = :email ";

        $stmt = $this->conn->prepare($query) ;

        $stmt->execute(array(
            "email"=>$this->email
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

        $query = "INSERT INTO $this->table_name (`nom` , `prenom` , `email` , `motdepasse` , `admin` , contact , adresse)
                  VALUES
                  (:nom , :prenom , :email , :motdepasse , :admine , :contact , :adresse) " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "nom" => $this->nom ,
            "prenom" => $this->prenom ,
            "email" => $this->email ,
            "motdepasse" => $this->motdepasse ,
            "admine" => 0 ,
            "adresse" => $this->adresse ,
            "contact" => $this->contact
        ) ;

        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function update(){

        $query = "UPDATE $this->table_name
                  SET nom=:nom , prenom=:prenom , email=:email , motdepasse=:motdepasse , `admin`=:admine , contact=:contact , adresse=:adresse , statut=:statut
                  WHERE id=:id
        " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "nom" => $this->nom ,
            "prenom" => $this->prenom ,
            "email" => $this->email ,
            "motdepasse" => $this->motdepasse ,
            "admine" => $this->admin ,
            "id" => $this->id ,
            "adresse" => $this->adresse ,
            "contact" => $this->contact ,
            "statut" => $this->statut
        );

        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function get_utilisateur_infos() {

        $stmt = $this->read_one_by_id() ;

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        return [$nom , $prenom] ;
    }

}
?>