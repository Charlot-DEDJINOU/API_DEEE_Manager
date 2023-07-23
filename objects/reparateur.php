<?php
class Reparateur{
 
    private $conn;
    private $table_name = "reparateur";
 
    public $id_utilisateur;
    public $id_quartier = NULL;
    public $id_ville;
    public $annee_experience;
    public $etoile = 0;
    public $nombre_projet;
    public $id_metier;
    public $description ;
    public $publier = 0 ;
    public $contact ;
    public $image = "icone";
    public $fin_abonnement ;
 
    public function __construct($db){
        $this->conn = $db;
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
                  WHERE  id_utilisateur = :id ";

        $stmt = $this->conn->prepare($query) ;

        $stmt->execute(array(
            "id"=>$this->id_utilisateur
        )) ;
        
        return $stmt ;
    }

    function create(){

        $query = "INSERT INTO $this->table_name (id_utilisateur , id_quartier , id_ville , annee_experience , etoile , nombre_projet , id_metier , `description` , contact , publier , fin_abonnement)
                  VALUES
                  (:id_utilisateur , :id_quartier , :id_ville , :annee_experience , :etoile , :nombre_projet , :id_metier , :descriptio , :contact , :publier ,  DATE_ADD(NOW(), INTERVAL 3 MONTH) )" ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "id_utilisateur" => $this->id_utilisateur ,
            "id_quartier" => $this->id_quartier ,
            "id_ville" => $this->id_ville ,
            "annee_experience" => $this->annee_experience ,
            "etoile" => $this->etoile ,
            "nombre_projet" => $this->nombre_projet ,
            "id_metier" => $this->id_metier ,
            "descriptio" => $this->description ,
            "contact" => $this->contact ,
            "publier" => $this->publier
        ) ;

        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function update(){

        $query = "UPDATE $this->table_name
                  SET id_quartier = :id_quartier , id_ville = :id_ville , annee_experience = :annee_experience, etoile = :etoile , nombre_projet = :nombre_projet , id_metier = :id_metier , `description` = :descriptio , publier = :publier ,
                      contact = :contact , fin_abonnement =:fin_abonnement , `image` =:imag
                  WHERE id_utilisateur=:id_utilisateur
        " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "id_utilisateur" => $this->id_utilisateur ,
            "id_quartier" => $this->id_quartier ,
            "id_ville" => $this->id_ville ,
            "annee_experience" => $this->annee_experience ,
            "etoile" => $this->etoile ,
            "nombre_projet" => $this->nombre_projet ,
            "id_metier" => $this->id_metier ,
            "descriptio" => $this->description ,
            "publier" => $this->publier ,
            "contact" => $this->contact ,
            "fin_abonnement" => $this->fin_abonnement ,
            "imag" => $this->image
        ) ;


        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function delete(){

        $query = "UPDATE $this->table_name SET publier = 0
                  WHERE id_utilisateur = :id_utilisateur ";

        $stmt = $this->conn->prepare($query) ;

        $array=array(
            "id_utilisateur" => $this->id_utilisateur
        ) ;
        
        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function yet_register(){

        $stmt = $this->read_one_by_id() ;

        $number = $stmt->rowCount() ;

        if($number > 0) 
            return true ;

        return false ;
    }

    function update_premium()
    {
        $date = strtotime($this->fin_abonnement) + strtotime(date("Y-m-d H:i:s")) ;

        $date = date('Y-m-d H:i:s', $date); 
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $date); 

        if(strtotime($this->fin_abonnement) - strtotime(date("Y-m-d H:i:s")) < 0)
            $query = "UPDATE $this->table_name SET fin_abonnement = DATE_ADD(NOW(), INTERVAL 3 MONTH)" ;
        else
            $query = "UPDATE $this->table_name SET fin_abonnement = DATE_ADD($this->fin_abonnement , INTERVAL 3 MONTH) " ;

        $stmt = $this->conn->prepare($query) ;

        if($stmt->execute())
            return true ;
        return false ;
    }
}
?>