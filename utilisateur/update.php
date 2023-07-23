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

$data = json_decode(file_get_contents("php://input"));

if( !empty($data->email) && !empty($data->motdepasse) &&
    (!empty($data->nom) || $data->nom == null) && !empty($data->prenom) && 
    !empty($data->id) && !empty($data->admin) && 
    (!empty($data->adresse) || $data->adresse == null ) && 
    (!empty($data->contact) || $data->contact == null ) ){

    $utilisateur->admin = htmlentities($data->admin) ;
    $utilisateur->nom = htmlentities($data->nom) ;
    $utilisateur->prenom = htmlentities($data->prenom) ;
    $utilisateur->email = htmlentities($data->email) ;
    $utilisateur->motdepasse = htmlentities($data->motdepasse) ;
    $utilisateur->id = htmlentities($data->id) ;
    $utilisateur->contact = htmlentities($data->contact) ;
    $utilisateur->adresse = htmlentities($data->adresse) ;
    
    $stmt = $utilisateur->read_one_by_id() ;
    
    $num = $stmt->rowCount();

    if($num == 1){
        if($utilisateur->update()){

            http_response_code(200) ;
            echo json_encode(array(
                "message"=>"Mise à jour reussi"
            )) ;
        }
        else{
            http_response_code(400) ;
            echo json_encode(array(
                "message"=>"Echec de mise à jour.Une eureur s'est intervenue lors de la mise à jour"
            )) ;
        }
    }
    else{

        http_response_code(201) ;
        echo json_encode(array(
                "message"=>"Cet email n'est pas associé à un utilisateur.Veuillez créer un compte"
            )) ;
    }
       
}
else{

    http_response_code(404);
 
    echo json_encode(array(
        "message"=>"Pas assez donnee"
    )) ;
}