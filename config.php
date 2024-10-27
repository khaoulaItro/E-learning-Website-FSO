<?php

require 'vendor/autoload.php'; // Assurez-vous que c'est le bon chemin vers votre autoloader

use MongoDB\Client;

// Remplacez "mongodb://localhost:27017" par votre URI de connexion MongoDB
$client = new Client("mongodb://localhost:27017");

// Remplacez "cours" par le nom de votre base de données et "data" par le nom de votre collection
$database = $client->cours;
$collection = $database->data;

// Exemple d'insertion de données
$document = [
    'key' => 'value',
    'another_key' => 'another_value'
];

$collection->insertOne($document);

echo "Document inséré avec succès!";
