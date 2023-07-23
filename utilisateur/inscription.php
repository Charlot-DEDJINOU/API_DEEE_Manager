<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/utilisateur.php';

$database = new Database();
$db = $database->getConnection();

$utilisateur = new Utilisateur($db);

$data = json_decode($_GET["data"]);

if( !empty($data->email) && !empty($data->motdepasse) &&
    (!empty($data->nom) || $data->nom == null) && !empty($data->prenom) &&
    (!empty($data->adresse) || $data->adresse == null ) && 
    (!empty($data->contact) || $data->contact == null )){

    $utilisateur->nom = htmlentities($data->nom) ;
    $utilisateur->prenom = htmlentities($data->prenom) ;
    $utilisateur->email = htmlentities($data->email) ;
    $utilisateur->motdepasse = htmlentities($data->motdepasse) ;
    $utilisateur->contact = htmlentities($data->contact) ;
    $utilisateur->adresse = htmlentities($data->adresse) ;
    
    $stmt = $utilisateur->read_one() ;
    
    $num = $stmt->rowCount();

    if($num == 0){
        if($utilisateur->create()){

            http_response_code(200) ;
            echo json_encode(array(
                "message"=>"Inscription réussie"
            )) ;
        }
        else{
            http_response_code(201) ;
            echo json_encode(array(
                "message"=>"Echec d'inscription."
            )) ;
        }
    }
    else{

        http_response_code(201) ;
        echo json_encode(array(
                "message"=>"Cet email est déjà associé à un utilisateur"
            )) ;
    }
       
}
else{

    http_response_code(404);
 
    echo json_encode(array(
        "message"=>"Pas assez de donnee pour la création de compte"
    )) ;
}
?>