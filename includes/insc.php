<?php

if (!isset($_SERVER['HTTP_REFERER'])) {
    die("Page inaccessible");
}

$email = $error_email = $name = $error_name = $pass = $error_pass =
    $confirm = $error_confirm = $sexe = $error_sexe = '';

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
    if ($field == "") return "<br>Entrer votre mot de pass<br>";
    else if (strlen($field) < 6)
        return "<br>Mot de pass doit contenir au moins 6 caracteres<br>";
    return "";
}

function validate_username($field)
{
    if ($field == "") return "<br>Entrer le nom<br>";
    else if (strlen($field) < 4)
        return "<br>Le nom doit contenir au moins 5 caracteres<br>";
    else if (preg_match("/[^a-zA-Z ]/", $field))
        return "<br>Le nom est invalide";
    return "";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    session_start();

    require_once __DIR__ . '/../vendor/autoload.php'; // Assurez-vous d'inclure correctement le chemin vers la bibliothèque MongoDB

    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->webprojet->utilisateur;

    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $name = $_POST['name'];
    $sexe = $_POST['sexe'];
    $confirm = $_POST['confirmpass'];

    $error_email = validate_email($email);
    $error_pass = validate_password($pass);
    $error_name = validate_username($name);

    if ($confirm == '') {
        $error_confirm = "<br>Confirmer le mot de pass";
    } elseif ($confirm != $pass) {
        $error_confirm = "<br>Les deux mots de pass sont differents";
    }

    // Vérifier si l'email existe déjà dans la collection MongoDB
    $existingUser = $collection->findOne(['email' => $email]);
    if ($existingUser) {
        $error_email = "<br>Email déjà existant";
    } elseif ($error_confirm == '' && $error_email == '' && $error_name == '' && $error_pass == '') {
        // Insérer l'utilisateur dans la collection MongoDB
        $collection->insertOne([
            'nom' => $name,
            'email' => $email,
            'password' => $pass,
            'sexe' => $sexe
        ]);

        header('location:login.php');
        exit;
    } else {
        session_unset();
        session_destroy();
    }
}
