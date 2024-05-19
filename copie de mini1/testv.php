<?php

require 'Vehicule.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

$idv = $_POST["idv"];
$marque = $_POST["marque"];
$model = $_POST["model"];
$annee = $_POST["annee"];
$prixParJour = $_POST["prixParJour"];

$vehicul = new Vehicule($idv, $marque, $model, $annee, $prixParJour);

$idv = $vehicul->getId();
$marque = $vehicul->getMarque();
$model = $vehicul->getModele();
$annee = $vehicul->getAnnee();
$prixParJour = $vehicul->getPrixParJour();


$sql = "INSERT INTO vehicule (idVehicule, marque, model, annee, prixParJour) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssi", $idv, $marque, $model, $annee, $prixParJour);

if ($stmt->execute()) {
    echo "New vehicle record created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
