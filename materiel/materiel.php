<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/materiel.php';

$database = new Database();
$db = $database->getConnection();

$materiel = new Materiel($db);

if(isset($_GET["id"])){

    $materiel->id = htmlentities($_GET["id"]) ;
    
    $stmt = $materiel->read_one_by_id() ;
    
    $num = $stmt->rowCount();

    if($num > 0){

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        $materiel=array(
            "id" => $id ,
            "designation" => $designation ,
            "etat" => $etat ,
            "type" => $type ,
            "price" => $prix_unitaire ,
            "image" => $image ,
            "caracteristique" => $caracteristique ,
            "quantite_stock" => $quantite_stock ,
            "publier" => $publier
        ) ;

        http_response_code(200);
 
        echo json_encode($materiel);
    }
    else{

        http_response_code(201) ;

        echo json_encode(array(
                "message"=>"Ce materiel n'existe pas"
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