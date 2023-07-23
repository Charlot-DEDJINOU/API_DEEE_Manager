<?php 
class Message{

    private $conn ;
    private $table_name ;
    public $id_destinateur ;
    public $id_recepteur ;
    public $messages ;
    public $date_message ;
    public $reference ;
    public $type = "texte" ;

    function __construct($db , $table)
    {
        $this->table_name = $table ;
        $this->conn = $db ;
    }

    function table_exist()
    {
        try{
            $query = "SELECT * FROM $this->table_name" ;

            $query = $this->conn->query($query) ;

            return true ;

        }catch(PDOException $exception){
            return false ;
        }

    }

    function insert_admin()
    {
        $query = "INSERT INTO $this->table_name (id_destinateur , id_recepteur , messages , date_message , reference , `type`)
            VALUES
            (:id_destinateur , :id_recepteur , :messages , NOW() , :reference , :typ)
        " ;

        $stmt = $this->conn->prepare($query) ;

        $array = array(
            "id_destinateur" => $this->id_destinateur ,
            "id_recepteur" => 3 ,
            "messages" => "vos messages sont chiffrés de bout en bout pour garantir votre confidentialité. Cela signifie que seules les personnes avec qui vous communiquez peuvent voir vos messages et personne d'autre, pas même WhatsApp. Nous prenons la confidentialité de vos messages très au sérieux et nous travaillons en permanence pour garantir la sécurité de vos conversations"  ,
            "reference" => $this->id_destinateur."3" ,
            "typ" => $this->type
        ) ;

        if($stmt->execute($array))
            return true ;
            
        return false ;

    }

    function create_table()
    {
        $query = "CREATE TABLE $this->table_name (
                id_destinateur int ,
                id_recepteur int  ,
                messages text  ,
                date_message DATETIME ,
                reference text ,
                `type` text ,
                FOREIGN KEY (id_destinateur) REFERENCES utilisateur(id) ,
                FOREIGN KEY (id_recepteur) REFERENCES utilisateur(id) 
            );
        " ;

        $stmt = $this->conn->prepare($query) ;
        $stmt->execute() ;
    }

    function read_references()
    {
        $query = "SELECT reference FROM $this->table_name ORDER BY date_message DESC " ;

        $reference = $this->conn->prepare($query) ;

        $reference->execute() ;

        return $reference ;
    }
    
    function read_one_reference()
    {
        $query = "SELECT reference FROM $this->table_name WHERE reference =:reference" ;

        $reference = $this->conn->prepare($query) ;

        $array = array(
            "reference" => $this->reference 
        ) ;

        $reference->execute($array) ;

        return $reference ;
    }

    function read_last_message()
    {
        $query = "SELECT * FROM $this->table_name WHERE reference=:reference ORDER BY date_message DESC LIMIT 0,1" ;

        $array = array(
            "reference" => $this->reference 
        ) ;

        $stmt = $this->conn->prepare($query) ;

        $stmt->execute($array) ;

        return $stmt ;
    }

    function read_all_message()
    {
        $query = "SELECT * FROM $this->table_name 
                  WHERE reference = :reference" ;
        $array = array(
            "reference" => $this->reference 
        ) ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->execute($array) ;
        return $stmt ;
    }

    function create()
    {
        $query = "INSERT INTO $this->table_name (id_destinateur , id_recepteur , messages , date_message , reference , `type`) 
                  VALUE
                  (:id_destinateur , :id_recepteur , :messages , NOW() , :reference , :typ)
        " ;

        $stmt = $this->conn->prepare($query) ;
        $array = array(
            "id_destinateur" => $this->id_destinateur ,
            "id_recepteur" => $this->id_recepteur ,
            "messages" => $this->messages ,
            "reference" => $this->reference ,
            "typ" => $this->type
        ) ;
        if($stmt->execute($array))
            return true ;
            
        return false ;
    }
}
?>