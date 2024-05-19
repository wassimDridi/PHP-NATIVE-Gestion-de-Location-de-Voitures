<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}


$sql = "SELECT client.idClient, client.nom, client.prenom, location.dateDebut, location.dateFin, location.prixTotal
        FROM client
        JOIN location ON client.idClient = location.idClient#";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID_Client</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>DateDebut</th>
                <th>DateFin</th>
                <th>PrixTotal</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['idClient'] . "</td>
                <td>" . $row['nom'] . "</td>
                <td>" . $row['prenom'] . "</td>
                <td>" . $row['dateDebut'] . "</td>
                <td>" . $row['dateFin'] . "</td>
                <td>" . $row['prixTotal'] . "</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No rental history found for clients.";
}

$conn->close();
?>
