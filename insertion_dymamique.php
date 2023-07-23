<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once './config/database.php';
include_once './objects/materiel.php';

$database = new Database();
$db = $database->getConnection();

$materiel = new Materiel($db) ;

$caracteristique = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt";
$quantite = 20 ;

$data = [
        [
         "id" => 1,
         'image' => "../asset/image1.jpg,../asset/image1.jpg",
         'nom'  =>  'Imprimante',
         'etat' => 'Neuf',
         'price' => 20 ,
         'type' => 'Equipement'
        ],
        [
         "id" => 2,
         'image' => "../assets/nature.jpg",
         'nom'  =>  'Imprimante',
         'etat' => 'Neuf',
         'price' => 20 ,
         'type' => 'Equipement'
        ],
        [
         "id" => 3,
         'image' => "../asset/image1.jpg,../asset/image1.jpg",
         'nom'  =>  'Portable Android S7',
         'etat' => 'Neuf',
         'price' => 20 ,
         'type' => 'Piece'
        ] ,
        [
          "id" => 4,
          'image' => "../asset/image1.jpg,../asset/image1.jpg",
          'nom'  =>  'Portable Android S7',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Equipement'
         ],
         [
          "id" => 5,
          'image' => "../asset/image1.jpg,../asset/image1.jpg",
          'nom'  =>  'Portable Android S7',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Piece'
         ],
         [
          "id" => 6,
          'image' => "../asset/image1.jpg,../asset/image1.jpg",
          'nom'  =>  'Carte graphique',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Equipement'
         ],
         [
          "id" => 7,
          'image' => "../asset/image1.jpg,../asset/image1.jpg",
          'nom'  =>  'Carte graphique',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Equipement'
         ],
         [
          "id" => 8,
          'image' => ".//asset/image1.jpg",
          'nom'  =>  'Portable Android S7',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Piece'
         ],
         [
          "id" => 9,
          'image' => "../asset/image1.jpg,../asset/image1.jpg",
          'nom'  =>  'Portable Android S7',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Equipement'
         ],
         [
          "id" => 10,
          'image' => "../asset/image1.jpg,../asset/image1.jpg",
          'nom'  =>  'Radio',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Equipement'
         ],
         [
          "id" => 11,
          'image' => "../asset/image1.jpg,../asset/image1.jpg",
          'nom'  =>  'Radio',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Equipement'
         ],
         [
          "id" => 12,
          'image' => "../asset/image1.jpg,../asset/image1.jpg",
          'nom'  =>  'Radio',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Piece'
         ],
         [
          "id" => 13,
          'image' => "../asset/image1.jpg,../asset/image1.jpg",
          'nom'  =>  'Portable Android S7',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Equipement'
         ],
         [
          "id" => 14,
          'image' => "../asset/image1.jpg,../asset/image1.jpg",
          'nom'  =>  'Imprimante',
          'etat' => 'Neuf',
          'price' => 20 ,
          'type' => 'Equipement' 
         ]
      ] ;

foreach($data as $item){
        
    $materiel->designation = $item["nom"];
    $materiel->prix_unitaire = $item["price"];
    $materiel->etat = $item["etat"] ;
    $materiel->type = $item["type"] ;
    $materiel->url_image = $item["image"] ;
    $materiel->caracteristique = $caracteristique ;
    $materiel->quantite_stock = $quantite;
        
    $materiel->create() ;
}

http_response_code(200) ;

echo json_encode(array(
    "message" => "CHARLOT"
)) ;

?>