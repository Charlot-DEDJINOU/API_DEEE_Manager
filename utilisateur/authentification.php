<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type") ;
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/utilisateur.php';

$database = new Database();
$db = $database->getConnection();

$utilisateur = new Utilisateur($db);
$user = new Utilisateur($db);

$data= json_decode($_GET["data"]);

if( !empty($data->email) && !empty($data->motdepasse) && ($data->statut == 0 || $data->statut == 1)){

    $utilisateur->email = $data->email ;

    $stmt = $utilisateur->read_one();
    $num = $stmt->rowCount();

    if($num>0){

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        $user->id = $id ;
        $user->nom = $nom ;
        $user->prenom = $prenom ;
        $user->email = $email ;
        $user->motdepasse = $motdepasse ;
        $user->admin = $admin ;
        $user->contact= $contact;
        $user->adresse = $adresse ;
        $user->statut = $data->statut ;

        $utilisateur=array(
            "id" => $id ,
            "nom" => html_entity_decode($nom) ,
            "prenom" => html_entity_decode($prenom) ,
            "motdepasse" => $motdepasse ,
            "admin" => $admin
        );

        if($utilisateur['motdepasse'] == $data->motdepasse ){

            $user->update() ;
            http_response_code(200);
 
            echo json_encode($utilisateur);
        }else{

            http_response_code(201);
 
            echo json_encode(array(
                "message" => "Mot de passe incorrect"
            ));
        }
    }
    else{

        http_response_code(202);
 
        echo json_encode(array(
            "message"=>"Cet email n'est pas associé à un compte"
        ));
    }
}
else{
    
        http_response_code(404);
 
        echo json_encode(array(
            "message"=>"Pas assez de donnée"
        )) ;
}
?>