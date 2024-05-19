<?php
include 'DB.php';

$bd = new DB();
$Connecte = $bd->connect();

if ($Connecte->connect_error) {
    die("Connection error: " . $Connecte->connect_error);
}

require_once 'Client.php';

if(isset($_POST['submit_inscription'])){
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse = $_POST["adresse"];
    $numtel = $_POST["telephone"];
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];
    $client = new Client($nom, $prenom, $adresse, $numtel, $email, $mdp, $Connecte);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: url('1.jpg') center/cover no-repeat;
            transition: background-image 1s ease;
            animation: changeBackground 16s infinite;
        }

        .container {
            position: relative;
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin: auto;
        }

        .form {
            position: relative;
            width: 45%;
            z-index: 1; /* Ensure form is above blurred background */
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
        }

        .form::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            
            filter: blur(10px); /* Adjust the blur effect as needed */
            opacity: 0.8; /* Adjust the opacity as needed */
            z-index: -1;
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

        p {
            margin-top: 20px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Animation for background image change */
        @keyframes changeBackground {
            0% { background-image: url('1.png'); }
            25% { background-image: url('2.png'); }
            50% { background-image: url('3.png'); }
            75% { background-image: url('4.png'); }
            100% { background-image: url('1.png'); }
        }

        /* Apply animation to the body element */
        .top-container {
            position: absolute;
            top: 20px;
            left: 65%;
            transform: translateX(-50%);
            z-index: 2;
            text-align: center;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }
        
    </style>
</head>
<body>
<div class="top-container">
       <h1> Dridi Cars</h1>
    </div>

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
    </div>
</body>
</html>
