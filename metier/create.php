<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/metier.php';

$database = new Database();
$db = $database->getConnection();

$metier = new Metier($db);

if(isset($_GET["designation"])){

    $metier->designation = htmlentities($_GET["designation"]) ;
    
    $stmt = $metier->read_one() ;
    
    $num = $stmt->rowCount();

    if($num == 0){
        if($metier->create()){

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

        http_response_code(201) ;
        echo json_encode(array(
                "message"=>"Ce metier existe déjà"
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