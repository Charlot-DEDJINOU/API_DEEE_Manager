<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/reparateur.php';


$database = new Database();
$db = $database->getConnection();

$reparateur = new Reparateur($db);

$data = json_decode($_GET["data"]);

if(!empty($data)){

    $reparateur->id_utilisateur = htmlentities($data) ; 

    $stmt = $reparateur->read_one_by_id() ;

    $number = $stmt->rowCount() ;

    if($number > 0){

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

        extract($row);

        $reparateur->fin_abonnement = $fin_abonnement ;

        if($reparateur->update_premium()){

            http_response_code(200) ;
            echo json_encode(array(
                "message"=>"Mise à jour réussie"
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
            "message"=>"Pas de reparateur avec cet id"
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