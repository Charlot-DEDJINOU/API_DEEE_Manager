<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/utilisateur.php';
include_once '../objects/message.php' ;

$database = new Database() ;
$db = $database->getConnection();

$utilisateur = new Utilisateur($db) ;

if(isset($_GET["data"]))
{
    $id_start = $_GET["data"] ;
    $table_name = "message_utilisateur".$id_start ;

    $message = new Message($db , $table_name) ;
    $message->id_destinateur = $id_start ;

    if(!$message->table_exist())
        $message->create_table() ;

    $references = $message->read_references() ;

    $num = $references->rowCount();
 
    if($num>0){
    
        $conversation_arr=array();
        $conversation_arr["conversations"]=array();

        $array=array() ;
    
        while ($row = $references->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            if(!in_array($reference , $array))
            {
                array_push($array , $reference) ;

                $message->reference = $reference ;

                $conversation = $message->read_last_message() ;
                $conversation = $conversation->fetch(PDO::FETCH_ASSOC) ;
                extract($conversation) ;
            
                $id = 0 ;
                if($id_start == $id_destinateur)
                    $id=$id_recepteur ;
                else 
                    $id=$id_destinateur ;

                $utilisateur = new Utilisateur($db) ;
                $utilisateur->id = $id ;
                $utilisateur = $utilisateur->read_one_by_id() ;
                $utilisateur = $utilisateur->fetch(PDO::FETCH_ASSOC) ;
                extract($utilisateur) ;

                $conversation_item = array(
                    "last_message" => html_entity_decode($messages) ,
                    "date_heure" => $date_message ,
                    "type" => $type ,
                    "statut" => $statut ,
                    "id" => $id ,
                    "nom_utilisateur" => html_entity_decode($nom) ,
                    "prenom_utilisateur" => html_entity_decode($prenom) ,
                    "color_black" => $id_destinateur != $id_start
                ) ;

                array_push($conversation_arr["conversations"], $conversation_item);  
            }
        }

        http_response_code(200);
 
        echo json_encode($conversation_arr);
    }
    else
    {
        http_response_code(200);
    
        echo json_encode(
            array("message" => "Débutez une conversation")
        );
    }
}
else
{
    http_response_code(404);
    
    echo json_encode(
        array("message" => "Pas assez de données")
    );
}