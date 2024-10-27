<?php

require_once 'vendor/autoload.php';

use MongoDB\Client;

// Connexion à MongoDB
$client = new Client("mongodb://localhost:27017");

// Sélection de la base de données et de la collection
$database = $client->selectDatabase("cours");
$collection = $database->selectCollection("data");

// Chemin vers le répertoire contenant les fichiers JSON
$chemin_json = 'C:\xamppp\htdocs\E-learning-Website-FSO\JSON';

// Liste des fichiers JSON à importer
$fichiers_json = [
    'angularCourse.json',
    'mongodbCource.json',
    'gitCourse.json',
    'javascriptCourse.json',
    'phpCourse.json',
    'vueJsCourse.json',
    // Ajoutez d'autres fichiers si nécessaire
];

// Importation des fichiers JSON dans MongoDB
foreach ($fichiers_json as $fichier) {
    // Chemin complet du fichier JSON
    $chemin_complet = $chemin_json . $fichier;

    // Charger le contenu du fichier JSON
    $contenu_json = file_get_contents($chemin_complet);

    // Décoder le contenu JSON en tableau associatif
    $cours = json_decode($contenu_json, true);

    // Insérer le cours dans la collection MongoDB
    $collection->insertOne($cours);

    echo "Cours inséré avec succès: $fichier\n";
}

// Récupération et affichage des cours depuis MongoDB
$cours = $collection->find();

// Afficher les cours
foreach ($cours as $document) {
    // Utiliser les données du document
    print_r($document);
}

echo "Importation et récupération terminées!\n";

?>
