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

$sql = "SELECT * FROM vehicule
        WHERE idVehicule NOT IN (
            SELECT idVehicule FROM Location
        )";

$result = $conn->query($sql);
if ($result === false) {
    die("Query error: " . $conn->error);
}

if ($result->num_rows > 0) {
    echo "<table border='1'>
        <tr>
            <th>ID_Vehicule</th>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Année</th>
            <th>PrixParJour</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . $row['idVehicule'] . "</td>
            <td>" . $row['marque'] . "</td>
            <td>" . $row['model'] . "</td>
            <td>" . $row['annee'] . "</td>
            <td>" . $row['prixParJour'] . "</td>
        </tr>";
    }

    echo "</table>";
} else {
    echo "Aucun véhicule disponible trouvé.";
}

$conn->close();
?>
