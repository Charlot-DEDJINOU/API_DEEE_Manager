<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/utilisateur.php';
 
$database = new Database();
$db = $database->getConnection();

$utilisateur = new Utilisateur($db);
 
$data = json_decode($_GET["data"]) ;

if(!empty($data->email))
{
    $utilisateur->email = $data->email ;
    $stmt = $utilisateur->read_one();
    $num = $stmt->rowCount();
    
    if($num>0){
    
        $utilisateur=array();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
        
        extract($row);
    
        $utilisateur=array(
            "id" => $id ,
            "nom" => html_entity_decode($nom) ,
            "prenom" => html_entity_decode($prenom) ,
            "admin" => $admin ,
            "contact" => $contact ,
            "adresse" => html_entity_decode($adresse) ,
            "status" => $statut
        );
    
        http_response_code(200);
    
        echo json_encode($utilisateur);
    }
    else{
    
        http_response_code(201);
    
        echo json_encode(
            array("message" => "Cet email n'est pas associé à un compte")
        );
    }
}
else{

    http_response_code(404);
    
    echo json_encode(
        array("message" => "Pas assez de données")
    );
}

// {
//     "id_utilisateur":1,
//     "nom_utilisateur":"DEDJINOU",
//     "prenom_utilisateur":"Charlot",
//     "metier":"Frigoriste",
//     "ville":"Cotonou",
//     "quartier":"Cajèhoun",
//     "annee_experience":2,
//     "etoile":0,
//     "contact":"+229 97887325",
//     "image":"download.jpg",
//     "nombre_projet":1,
//     "fin_abonnement":"2023-06-02 00:38:47",
//     "description":"Le maintenancier informatique est un professionnel spécialisé dans la maintenance des systèmes informatiques. Sa mission principale est d'assurer le bon fonctionnement des équipements informatiques, notamment les ordinateurs, les serveurs, les réseaux et les logiciels.\n\nLe maintenancier informatique doit être en mesure d'identifier les problèmes informatiques et de les résoudre rapidement",
//     "jour_restant":7772252,
//     "premium":true,
//     "publier":0
//     }