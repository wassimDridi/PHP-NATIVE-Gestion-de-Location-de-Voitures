<?php
require 'Client.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

$idClient = $_POST["idClient"];
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$adresse = $_POST["adresse"];
$numtel = $_POST["numtel"];
$email = $_POST["email"];

$client = new Client();
$client->setId($idClient);
$client->setNom($nom);
$client->setPrenom($prenom);
$client->setAdresse($adresse);
$client->setNumeroTelephone($numtel);
$client->setEmail($email);


$idClient = $client->getId();
$nom = $client->getNom();
$prenom = $client->getPrenom();
$adresse = $client->getAdresse();
$numtel = $client->getNumeroTelephone();
$email = $client->getEmail();
$sql = "INSERT INTO client (idClient, nom, prenom, adresse, numTel, email) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssss", $idClient, $nom, $prenom, $adresse, $numtel, $email);

if ($stmt->execute()) {
    echo "New client record created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
    //_________________________

    echo $idClient ;
  $client = new Client($idClient, $nom, $prenom , $adresse, $numtel, $email );
  

    echo "<h2>Liste des Clients</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID Client</th><th>Nom</th><th>Prénom</th><th>adresse</th><th>Numéro de Téléphone</th><th>Email</th></tr>";

        echo "<tr>";
        echo "<td>" . $client->getId() . "</td>";
        echo "<td>" . $client->getNom() . "</td>";
        echo "<td>" . $client->getPrenom() . "</td>";
        echo "<td>" . $client->getAdresse() . "</td>";
        echo "<td>" . $client->getNumeroTelephone() . "</td>";
        echo "<td>" . $client->getEmail() . "</td>";
        echo "</tr>";
    
    echo "</table>";

?>