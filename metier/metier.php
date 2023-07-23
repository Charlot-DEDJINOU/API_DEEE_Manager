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

    if($num > 0){

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        $metier=array(
            "id" => $id ,
            "nom" => $designation ,
        );

        http_response_code(200);
 
        echo json_encode($metier);
    }
    else{

        http_response_code(201) ;

        echo json_encode(array(
                "message"=>"Cette metier n'existe pas"
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