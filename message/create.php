<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/utilisateur.php';
include_once '../objects/message.php' ;

$database = new Database() ;
$db = $database->getConnection();

$utilisateur = new Utilisateur($db) ;

$data = json_decode($_GET["data"]);

if(!empty($data->id_utilisateur) && !empty($data->id_ami) && 
    !empty($data->message) && !empty($data->type))
{
    $id_destinateur = $data->id_utilisateur ;
    $id_recepteur = $data->id_ami ;
    
    $table_name_destinateur = "message_utilisateur".$id_destinateur ;

    $message1 = new Message($db , $table_name_destinateur) ;
    $message1->id_destinateur = $id_destinateur ;

    if(!$message1->table_exist())
        $message1->create_table() ;

    $message1->id_recepteur = $id_recepteur ;
    $message1->messages = htmlentities($data->message) ;
    $message1->reference = $id_destinateur.$id_recepteur ;
    $message1->type = $data->type ;

    $two = true ;

    if($id_destinateur != $id_recepteur)
    {
        $table_name_recepteur = "message_utilisateur".$id_recepteur ;

        $message2 = new Message($db , $table_name_recepteur) ;
        $message2->id_destinateur = $id_destinateur ;

        if(!$message2->table_exist())
            $message2->create_table() ;

        $message2->id_recepteur = $id_recepteur ;
        $message2->messages = htmlentities($data->message) ;
        $message2->reference = $id_recepteur.$id_destinateur ;
        $message2->type = $data->type ;

        if($message1->create() && $message2->create())
            $two = true ;
        else
            $two = false ;
    }
    else
    {
        if($message1->create())
            $two = true ;
        else
            $two = false ;
    }

    if($two == true)
    {
        http_response_code(200) ;

        echo json_encode(array(
            "message" => "Message envoyé"
        )) ;
    }
    else
    {
        http_response_code(300) ;

        echo json_encode(array(
            "message" => "Echec d'envoie"
        )) ;
    }
}
else
{
    http_response_code(400) ;

    echo json_encode(array(
        "message" => "Pas assez de donnée"
    )) ;
}
?>