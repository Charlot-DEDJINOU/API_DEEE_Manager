<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/lieu_depot.php';
include_once '../objects/quartier.php' ;
include_once '../objects/ville.php' ;

$database = new Database();
$db = $database->getConnection();

$lieu_depot = new Lieu_depot($db);

$data = json_decode(file_get_contents("php://input"));

if( !empty($data->nom) && !empty($data->quartier) &&
    !empty($data->ville) && !empty($data->longitude) && !empty($data->repere) &&
    !empty($data->url_image) && !empty($data->description) &&
    !empty($data->latitude) && ($data->publier == 0 || $data->publier == 1)){

        $ville = new Ville($db) ;
        $ville->nom_ville = $data->ville ;
        $ville = $ville->get_id_ville() ;

        $quartier = new Quartier($db) ;
        $quartier->nom_quartier = $data->quartier ;
        $quartier = $quartier->get_id_quartier() ;

        $lieu_depot->nom = htmlentities($data->nom) ;
        $lieu_depot->id_quartier = htmlentities($quartier) ;
        $lieu_depot->id_ville = htmlentities($ville) ;
        $lieu_depot->longitude = htmlentities($data->longitude) ;
        $lieu_depot->latitude = htmlentities($data->latitude) ;
        $lieu_depot->url_image = htmlentities($data->url_image) ;
        $lieu_depot->repere = htmlentities($data->repere) ;
        $lieu_depot->description = htmlentities($data->description) ;
        $lieu_depot->publier = htmlentities($data->publier) ;
        
        if($lieu_depot->create()){

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
        "message"=>"Pas assez de donnee"
    )) ;
    }
?>