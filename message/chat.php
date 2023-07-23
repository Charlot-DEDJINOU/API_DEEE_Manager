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

$data = json_decode($_GET["data"]);

if(!empty($data->id_utilisateur) && !empty($data->id_ami))
{
    $id_utilisateur = $data->id_utilisateur ;
    $id_ami = $data->id_ami ;

    $table_name = "message_utilisateur".$id_utilisateur ;

    $message = new Message($db , $table_name) ;
    $message->id_destinateur = $id_utilisateur ;
    
    if(!$message->table_exist())
        $message->create_table() ;
    
    $message->id_recepteur = $id_ami ;
    $message->reference = $id_utilisateur.$id_ami ;
    $stmt = $message->read_all_message() ;

    $message_arr=array();
    $message_arr["messages"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $message_item = array(
            "id_destinateur" => $id_destinateur ,
            "id_recepteur" => $id_recepteur ,
            "message" => html_entity_decode($messages) ,
            "date_message" => $date_message ,
            "type" => $type
        ) ;
        
        array_push($message_arr["messages"], $message_item);
    }

    $utilisateur = new Utilisateur($db) ;
    $utilisateur->id = $id_ami ;
    $utilisateur = $utilisateur->read_one_by_id() ;
    $utilisateur = $utilisateur->fetch(PDO::FETCH_ASSOC) ;
    extract($utilisateur) ;

    $message_arr["statut"] = $statut ;
    $message_arr["nom_utilisateur"] = html_entity_decode($nom) ;
    $message_arr["prenom_utilisateur"] = html_entity_decode($prenom) ;

    http_response_code(200);

    echo json_encode($message_arr) ;
}
else
{
    http_response_code(404);
    
    echo json_encode(
        array("message" => "Pas assez de données")
    );
}