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

if(!empty($data->id_utilisateur) && !empty($data->id_ami))
{
    $id_destinateur = $data->id_utilisateur ;
    $id_recepteur = $data->id_ami ;
    
    $table_name_destinateur = "message_utilisateur".$id_destinateur ;

    $message1 = new Message($db , $table_name_destinateur) ;

    $message1->reference = $id_destinateur.$id_recepteur ;
    $message1->id_destinateur = $id_destinateur ;

    if(!$message1->table_exist())
        $message1->create_table() ;

    $stmt = $message1->read_one_reference() ;
    $num = $stmt->rowCount() ;

    if($num < 2)
    {
        $message1->id_recepteur = $id_recepteur ;
        $message1->messages = htmlentities("Veuillez soumettre en image les photos de votre d'itentité , d'attestation de résidence") ;

        if($id_destinateur != $id_recepteur)
        {
            $table_name_recepteur = "message_utilisateur".$id_recepteur ;

            $message2 = new Message($db , $table_name_recepteur) ;
            $message2->id_destinateur = $id_destinateur ;

            if(!$message2->table_exist())
                $message2->create_table() ;

            $message2->id_recepteur = $id_recepteur ;
            $message2->messages = htmlentities("Veuillez soumettre en image les photos , d'attestation de résidence ,de votre acte de naissance et ainsi que toutes images néccessaires") ;
            $message2->reference = $id_recepteur.$id_destinateur ;

            $message1->create() ;
            $message2->create() ;
        }
        else
            $message1->create() ;

    }
    
    $message1->id_recepteur = $id_recepteur ;
    $message1->messages = htmlentities("Veuillez renseigner les informations suisvantes sur vos équipement\n1-Le nom de l'équipement\n2-Etat\n3-Au moins deux images\n4-Les caractéristiques\5-À combien souhaiterais vous le vendre\n6-Facture attestant que l'équipement est bien le votre\n\nMerci de fournir ces informations") ;

    if($id_destinateur != $id_recepteur)
    {
        $table_name_recepteur = "message_utilisateur".$id_recepteur ;

        $message2 = new Message($db , $table_name_recepteur) ;
        $message2->id_destinateur = $id_destinateur ;

        if(!$message2->table_exist())
            $message2->create_table() ;

        $message2->id_recepteur = $id_recepteur ;
        $message2->messages = htmlentities("Veuillez renseigner les informations suisvantes sur vos équipement\n1-Le nom de l'équipement\n2-Etat\n3-Au moins deux images\n4-Les caractéristiques\5-À combien souhaiterais vous le vendre\n6-Facture attestant que l'équipement est bien le votre\n\nMerci de fournir ces informations") ;
        $message2->reference = $id_recepteur.$id_destinateur ;

        $message1->create() ;
        $message2->create() ;
    }
    else
        $message1->create() ;

    http_response_code(200) ;

    echo json_encode(array(
        "message" => "Message envoyé"
    )) ;
}
else
{
    http_response_code(400) ;

    echo json_encode(array(
        "message" => "Pas assez de donnée"
    )) ;
}
?>