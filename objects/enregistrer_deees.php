<?php 
class Deee{

    private $conn ;
    private $table_name = "enregistrer_deees" ;

    public $id ;
    public $id_utilisateur ;
    public $id_quartier ;
    public $id_ville ;
    public $qte_livrer ;
    public $repere ;
    public $contact ;
    public $description ;
    public $collecter = 0;
    public $traiter = 0;
    public $type_gestion = "0" ;
    public $detail_traitement = NULL ;
    public $date_enregistrement = NULL ;
    public $date_collecte = NULL ;
    public $date_traitement = NULL ;

    function __construct($bd){
        $this->conn = $bd ;
    }

    function read(){
 
        $query = "SELECT * FROM $this->table_name ORDER BY id DESC";
     
        $stmt = $this->conn->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }

    function read_by_user()
    {
        $query = "SELECT * FROM $this->table_name WHERE id_utilisateur = :id_utilisateur";
     
        $stmt = $this->conn->prepare($query);
     
        $array = array(
            "id_utilisateur" => $this->id_utilisateur
        ) ;

        $stmt->execute($array);
     
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

        $query = "INSERT INTO $this->table_name (id_utilisateur , id_quartier , id_ville , qte_livrer , repere , contact , `description` , date_enregistrement)
                  VALUES
                  (:id_utilisateur , :id_quartier , :id_ville , :qte_livrer , :repere , :contact , :descriptio , NOW() )" ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "id_utilisateur" => $this->id_utilisateur ,
            "id_quartier" => $this->id_quartier ,
            "id_ville" => $this->id_ville ,
            "contact" => $this->contact ,
            "qte_livrer" => $this->qte_livrer ,
            "repere" => $this->repere ,
            "descriptio" => $this->description
        ) ;

        if($stmt->execute($array))
            return true ;

        return false ;
    }

    function update(){

        $query = "UPDATE $this->table_name
                  SET id_utilisateur=:id_utilisateur , id_quartier=:id_quartier , id_ville=:id_ville , qte_livrer=:qte_livrer , contact=:contact , repere=:repere , collecter=:collecter ,
                      `description`=:descriptio , traiter=:traiter , type_gestion=:type_gestion , detail_traitement=:detail_traitement ,
                      date_enregistrement=:date_enregistrement , date_collecte=:date_collecte , date_traitement=:date_traitement
                  WHERE id=:id
        " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "id" => $this->id ,
            "id_utilisateur" => $this->id_utilisateur ,
            "id_quartier" => $this->id_quartier ,
            "id_ville" => $this->id_ville ,
            "contact" => $this->contact ,
            "qte_livrer" => $this->qte_livrer ,
            "repere" => $this->repere ,
            "descriptio" => $this->description ,
            "collecter" => $this->collecter ,
            "traiter" => $this->traiter ,
            "type_gestion" => $this->type_gestion ,
            "detail_traitement" => $this->detail_traitement ,
            "date_enregistrement" => $this->date_enregistrement ,
            "date_collecte" => $this->date_collecte ,
            "date_traitement" => $this->date_traitement ,
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

    function yet_register(){

        $query = "SELECT * FROM $this->table_name 
                  WHERE  id_utilisateur = :id_utilisateur  AND collecter = :collecter";

        $stmt = $this->conn->prepare($query) ;

        $stmt->execute(array(
        "id_utilisateur"=>$this->id_utilisateur ,
        "collecter" => 0 
        )) ;

        $number = $stmt->rowCount() ;

        if($number > 0) 
            return true ;

        return false ;
    }
}
?>