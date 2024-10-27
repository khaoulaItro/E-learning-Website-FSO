<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

// Connexion MongoDB
$client = new Client("mongodb://localhost:27017");
$collection = $client->webprojet->utilisateur;

// session_start() est déjà appelé plus bas dans le script, donc supprimez-le d'ici

// Si une session est en cours et qu'un email est défini
if (!empty($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Requête pour récupérer les informations de l'utilisateur
    $user = $collection->findOne(['email' => $email]);

    // Si un utilisateur correspond à l'email, récupérez les données
    if ($user) {
        $id = $user['_id']; // Supposons que l'ID est stocké dans _id
        $name = $user['nom'];
        $password = $user['password'];
        $sexe = $user['sexe'];
    }
}

$email = $pass = $email_error = $pass_error = '';

function validate_email($field)
{
    if ($field == "") return "<br>Entrer votre email<br>";
    else if (
        !((strpos($field, ".") > 0) &&
            (strpos($field, "@") > 0)) ||
        preg_match("/[^a-zA-Z0-9.@_-]/", $field)
    )
        return "<br>L'email est invalide <br>";
    return "";
}

function validate_password($field)
{
    if ($field == "") return "<br>Entrer votre mot de passe<br>";
    else if (strlen($field) < 6)
        return "<br>Mot de passe doit contenir au moins 6 caractères<br>";
    return "";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    session_start(); // Appel de session_start() ici pour gérer la session lorsqu'un formulaire est soumis

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $email_error = validate_email($email);
    $pass_error = validate_password($pass);

    if ($email_error == '') {
        $_SESSION['email'] = $email;
    }

    try {
        // Requête pour trouver l'utilisateur avec l'email et le mot de passe correspondants
        $user = $collection->findOne(['email' => $email, 'password' => $pass]);

        if ($user) {
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['sexe'] = $user['sexe'];
            $_SESSION['email'] = $email;
            header('Location: ./accueil.php');
            exit;
        } elseif ($pass_error == '' || $email_error == '') {
            if ($pass_error == '') {
                $pass_error .= "<br> Vérifiez le mot de passe";
            } else {
                $email_error .= "<br> Vérifiez votre email";
            }
            session_unset();
            session_destroy();
        }
    } catch (Exception $e) {
        die("Erreur de connexion à MongoDB : " . $e->getMessage());
    }
}
