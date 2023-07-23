<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/quartier.php';
include_once '../objects/ville.php';
include_once '../objects/ville_quartier.php';

$database = new Database();
$db = $database->getConnection();

$quartier = new Quartier($db);
$ville = new Ville($db) ;
$ville_quartier = new Ville_quartier($db) ;

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->quartier) && !empty($data->ville)){

    $quartier->nom_quartier = htmlentities($data->quartier) ;
    
    $stmt = $quartier->read_one() ;
    
    $num = $stmt->rowCount();

    if($num == 0)
        $quartier->create() ;

    $ville->nom_ville = htmlentities($data->ville) ;

    $stmt = $ville->read_one() ;
    
    $num = $stmt->rowCount();

    if($num == 0)
        $ville->create() ;

    $quartier = $quartier->get_id_quartier() ;

    $ville = $ville->get_id_ville() ;

    $ville_quartier->id_quartier = $quartier ;
    $ville_quartier->id_ville = $ville ;

    $stmt = $ville_quartier->read_one() ;

    $number = $stmt->rowCount() ;

    if($number == 0)
    {
        if($ville_quartier->create())
        {
                http_response_code(200) ;
                echo json_encode(array(
                "message"=>"Ajout reussi"
            )) ;
        }
        else
        {
                http_response_code(201) ;
                echo json_encode(array(
                "message"=>"Echec d'ajout.Une eureur s'est intervenue lors de l'ajout"
            )) ;
        }
    }
    else
    {
            http_response_code(201) ;
            echo json_encode(array(
            "message"=>"Ce quartier est déjà relié à cette ville"
        )) ;
    }
}
else{
    http_response_code(404);
 
    echo json_encode(array(
        "message"=>"Pas assez de donnée pour l'ajout"
    )) ;
}
?>