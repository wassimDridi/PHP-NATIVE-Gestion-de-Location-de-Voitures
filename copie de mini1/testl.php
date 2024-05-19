<?php
include 'Location.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

$location = new Locations();
$location->setID_Location($_POST['idLocation']);
$location->setID_Client($_POST['idClient']);
$location->setID_Vehicule($_POST['idVehicule']);
$location->setDateDebut($_POST['dateDebut']);
$location->setDateFin($_POST['dateFin']);
$location->setPrixTotal($_POST['prixTotal']);

$idLocation = $location->getID_Location();
$idClient = $location->getID_Client();
$idVehicule = $location->getID_Vehicule();
$dateDebut = $location->getDateDebut();
$dateFin = $location->getDateFin();
$prixTotal = $location->getPrixTotal();

$sql = "INSERT INTO location (idLocation, idClient, idVehicule, DateDebut, DateFin, PrixTotal) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("iiiiss", $idLocation, $idClient, $idVehicule, $dateDebut, $dateFin, $prixTotal);

if ($stmt->execute()) {
    echo "Data inserted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>
