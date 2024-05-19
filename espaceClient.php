<?php
include 'DB.php';

$bd = new DB();
$Connecte = $bd->connect();
//$Connect fih connection mysqli class DB
if ($Connecte->connect_error) {
    die("Connection error: " . $Connecte->connect_error);
}

require_once 'Client.php';
include 'LogIn.php';
if(isset($_POST['submit_inscription'])){
    //header('location:espaceClient.php');
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse = $_POST["adresse"];
    $numtel = $_POST["telephone"];
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];
    $client = new Client($nom,$prenom, $adresse, $numtel, $email, $mdp ,$Connecte);
}
if(isset($_POST['LogIn'])){
    //header('location:espaceClient.php');
    $email = $_POST["loginemail"];
    $mdp = $_POST["loginmdp"];
    $logIn = new LogIn($email,$mdp ,$Connecte);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Espace Client</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.container {
    display: flex;
    justify-content: space-between;
    width: 80%;
    margin: auto;
}

.form {
    width: 45%;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h2 {
    color: #333;
}

label {
    display: block;
    margin: 10px 0 5px;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

button {
    background-color: #3498db;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #2980b9;
}

    </style>
</head>
<body>
    <div class="container">
        <form id="inscription-form" class="form" method="post" action="">
            <h2>Inscription</h2>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" required>

            <label for="telephone">Numéro de téléphone:</label>
            <input type="tel" id="telephone" name="telephone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="mdp">Mot de passe:</label>
            <input type="password" id="mdp" name="mdp" required>

            <button type="submit" name="submit_inscription">S'inscrire</button>
        </form>

        <form id="login-form" class="form" method="post" action="">
            <h2>Connexion</h2>
            <label for="login-email">Email:</label>
            <input type="email" id="login-email" name="loginemail" required>

            <label for="login-mot-de-passe">Mot de passe:</label>
            <input type="password" id="loginmdp" name="loginmdp" required>

            <button type="submit" name="LogIn">Se connecter</button>
        </form>
    </div>
</body>
</html>
