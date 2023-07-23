<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/ville.php';

$database = new Database();
$db = $database->getConnection();

$ville = new Ville($db);

$data = json_decode(file_get_contents("php://input"));

if( !empty($data->id) && !empty($data->nom_ville) ){

    $ville->nom_ville = htmlentities($data->nom_ville) ;
    $ville->id = htmlentities($data->id) ;
    
    $stmt = $ville->read_one_by_id() ;
    
    $num = $stmt->rowCount();

    if($num == 1){
        if($ville->update()){

            http_response_code(200) ;
            echo json_encode(array(
                "message"=>"Mise à jour reussi"
            )) ;
        }
        else{
            http_response_code(201) ;
            echo json_encode(array(
                "message"=>"Echec de mise à jour.Une eureur s'est intervenue lors de la mise à jour"
            )) ;
        }
    }
    else{

        http_response_code(201) ;
        echo json_encode(array(
                "message"=>"Cette ville n'exite pas"
            )) ;
    }
       
}
else{

    http_response_code(404);
 
    echo json_encode(array(
        "message"=>"Pas assez donnee pour la mise à jour"
    )) ;
}