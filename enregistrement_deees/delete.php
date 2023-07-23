<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/enregistrer_deees.php';

$database = new Database();
$db = $database->getConnection();

$enregistrement_deee = new Deee($db);

if(isset($_GET["id"])){

    $enregistrement_deee->id = htmlentities($_GET["id"]) ;
    
    $stmt = $enregistrement_deee->read_one_by_id() ;
    
    $num = $stmt->rowCount();

    if($num > 0){

        if($enregistrement_deee->delete()){
            http_response_code(200);
 
            echo json_encode(array(
                "message" => "Supression reussi"
            ));
        }
        else{
            http_response_code(204);
 
            echo json_encode(array(
                "message" => "Eureur de supression"
            ));
        }
    }
    else{

        http_response_code(201) ;

        echo json_encode(array(
                "message"=>"Ce enregistrement_deees n'existe pas"
            )) ;
    }
       
}
else{

    http_response_code(404);
 
    echo json_encode(array(
        "message"=>"Pas assez de donnee pour la suppression"
    )) ;
}
?>