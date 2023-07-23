<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/materiel.php';

$database = new Database();
$db = $database->getConnection();

$materiel = new Materiel($db);

$data = json_decode(file_get_contents("php://input"));

if( !empty($data->designation) && !empty($data->etat) &&
    !empty($data->type) && !empty($data->prix_unitaire) &&
    !empty($data->url_image) && !empty($data->caracteristique) &&
    !empty($data->quantite_stock) && ($data->publier == 0 || $data->publier == 1)){

        $materiel->designation = htmlentities($data->designation) ;
        $materiel->etat = htmlentities($data->etat) ;
        $materiel->type = htmlentities($data->type) ;
        $materiel->prix_unitaire = htmlentities($data->prix_unitaire) ;
        $materiel->url_image = htmlentities($data->url_image) ;
        $materiel->caracteristique = htmlentities($data->caracteristique) ;
        $materiel->quantite_stock = htmlentities($data->quantite_stock) ;
        $materiel->publier = htmlentities($data->publier) ;
        
        if($materiel->create()){

            http_response_code(200) ;
            echo json_encode(array(
                "message"=>"Ajout reussi"
            )) ;
    }
    else{
        http_response_code(201) ;
        echo json_encode(array(
            "message"=>"Echec d'ajout.Une eureur s'est intervenue lors de l'ajout"
        )) ;
    }
}
else{

    http_response_code(404);

    echo json_encode(array(
        "message"=>"Pas assez de donnee pour l'ajout de ce nouveau produit"
    )) ;
    }
?>