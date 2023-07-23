<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/ville.php';

$database = new Database();
$db = $database->getConnection();

$ville = new Ville($db);

if(isset($_GET["nom_ville"])){

    $ville->nom_ville = htmlentities($_GET["nom_ville"]) ;
    
    $stmt = $ville->read_one() ;
    
    $num = $stmt->rowCount();

    if($num > 0){

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        $ville=array(
            "id" => $id ,
            "nom" => html_entity_decode($nom_ville) ,
        );

        http_response_code(200);
 
        echo json_encode($ville);
    }
    else{

        http_response_code(201) ;

        echo json_encode(array(
                "message"=>"Cette ville n'existe pas"
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