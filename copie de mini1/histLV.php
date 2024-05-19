<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

$sql = "SELECT vehicule.idVehicule, vehicule.marque, vehicule.model, vehicule.annee, location.dateDebut, location.dateFin, location.prixTotal
        FROM vehicule
        JOIN location ON vehicule.idVehicule = location.idVehicule";
$result = $conn->query($sql);


$result = $conn->query($sql);
if ($result === false) {
    die("Query error: " . $conn->error);
}

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID_Vehicule</th>
                <th>Marque</th>
                <th>Modele</th>
                <th>Annee</th>
                <th>DateDebut</th>
                <th>DateFin</th>
                <th>PrixTotal</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['idVehicule'] . "</td>
                <td>" . $row['marque'] . "</td>
                <td>" . $row['model'] . "</td>
                <td>" . $row['annee'] . "</td>
                <td>" . $row['dateDebut'] . "</td>
                <td>" . $row['dateFin'] . "</td>
                <td>" . $row['prixTotal'] . "</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No rental history found for vehicles.";
}

$conn->close();

?>