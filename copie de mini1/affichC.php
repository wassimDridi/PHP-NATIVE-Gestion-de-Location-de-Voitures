<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}


$sql = "SELECT * FROM client";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID Client</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Adresse</th>
                <th>Numero de Tel</th>
                <th>email</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['idClient'] . "</td>
                <td>" . $row['nom'] . "</td>
                <td>" . $row['prenom'] . "</td>
                <td>" . $row['adresse'] . "</td>
                <td>" . $row['numTel'] . "</td>
                <td>" . $row['email'] . "</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No rental history found for clients.";
}

$conn->close();
?>
