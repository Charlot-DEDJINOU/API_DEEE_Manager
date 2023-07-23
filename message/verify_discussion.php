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

    if($num == 0)
    {
        $message1->id_recepteur = $id_recepteur ;
        $message1->messages = htmlentities("vos messages sont chiffrés de bout en bout pour garantir votre confidentialité. Cela signifie que seules les personnes avec qui vous communiquez peuvent voir vos messages et personne d'autre, pas même WhatsApp. Nous prenons la confidentialité de vos messages très au sérieux et nous travaillons en permanence pour garantir la sécurité de vos conversations") ;

        if($id_destinateur != $id_recepteur)
        {
            $table_name_recepteur = "message_utilisateur".$id_recepteur ;

            $message2 = new Message($db , $table_name_recepteur) ;
            $message2->id_destinateur = $id_destinateur ;

            if(!$message2->table_exist())
                $message2->create_table() ;

            $message2->id_recepteur = $id_recepteur ;
            $message2->messages = htmlentities("vos messages sont chiffrés de bout en bout pour garantir votre confidentialité. Cela signifie que seules les personnes avec qui vous communiquez peuvent voir vos messages et personne d'autre, pas même WhatsApp. Nous prenons la confidentialité de vos messages très au sérieux et nous travaillons en permanence pour garantir la sécurité de vos conversations") ;
            $message2->reference = $id_recepteur.$id_destinateur ;

            $message1->create() ;
            $message2->create() ;
        }
        else
            $message1->create() ;

        http_response_code(200) ;

        echo json_encode(array(
            "message" => "Reussi"
        )) ;
    }
    else
    {
        http_response_code(200) ;

        echo json_encode(array(
            "message" => "Ils écrivent déjà"
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