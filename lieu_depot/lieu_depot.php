<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
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

if(isset($_GET["id"])){

    $lieu_depot->id = htmlentities($_GET["id"]) ;
    
    $stmt = $lieu_depot->read_one_by_id() ;
    
    $num = $stmt->rowCount();

    if($num > 0){

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        $ville = new Ville($db) ;
        $ville->id = $id_ville ;
        $ville = $ville->get_name_ville() ;

        $quartier = new Quartier($db) ;
        $quartier->id = $id_quartier ;
        $quartier = $quartier->get_name_quartier() ;

        $lieu_depot = array(
            "id" => $id ,
            "quartier" => html_entity_decode($quartier) ,
            "ville" => html_entity_decode($ville) ,
            "nom" => html_entity_decode($nom) ,
            "longitude" => $longitude ,
            "latitude" => $latitude ,
            "img" => $image ,
            "decris" => html_entity_decode($description) ,
            "repere" => html_entity_decode($repere) ,
            "publier" => $publier
        ) ;

        http_response_code(200);
 
        echo json_encode($lieu_depot);
    }
    else{

        http_response_code(201) ;

        echo json_encode(array(
                "message"=>"Ce lieu de depot n'existe pas"
            )) ;
    }
       
}
else{

    http_response_code(404);
 
    echo json_encode(array(
        "message"=>"Pas assez de donnee pour la lecture"
    )) ;
}
?>