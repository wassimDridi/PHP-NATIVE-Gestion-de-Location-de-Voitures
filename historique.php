<?php
if(isset($_POST['espaceAdmin'])){
    header("Location: espaceAdmin.php");
}
include 'DB.php';

$bd = new DB();
$Connect = $bd->connect();

if ($Connect->connect_error) {
    die("Connection error: " . $Connect->connect_error);
}

if(isset($_POST['Clients'])){
    header("Location: Clientss.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de Location de Voiture</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f8f8;
    color: #333;
}

header {
    background-color: #3498db;
    color: #fff;
    text-align: center;
    padding: 20px;
    margin-left: 200px;
    max-width: 70%;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.client-info, .rental-history {
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #3498db;
    color: #fff;
}

.rental-history img {
    max-width: 40%;
    height: auto;
    border-radius: 50%; 
    margin-bottom: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}

nav {
    background-color: #3498db;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background-color 0.3s ease;
}

nav:hover {
    background-color: #2980b9;
}

.logo {
    max-width: 80px; 
    height: auto;
    border-radius: 50%;
}

.boutique-name {
    color: #fff;
    font-size: 1.5em;
    font-weight: bold;
    margin-right: auto;
}

.nav-buttons {
    display: flex;
    align-items: center;
}

.navbtn {
    background-color: #e44d26;
    color: #fff;
    padding: 10px;
    margin-right: 20px; /* Adjusted margin */
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.navbtn:hover {
    background-color: #27ae60;
}

    </style>
</head>
<body>
<nav>
    <img src="v.png" alt="Logo" class="logo">
    <div class="boutique-name">DRIDI CAR</div>
    <div class="nav-buttons">
    <form class="form" method="post" action="">
    <button type="submit" class="navbtn" name="espaceAdmin">Admin</button>
    <button type="submit" class="navbtn" name="Clients">Clients</button>
        </form>

    </div>
</nav><br><br><br><br><br><br>
<br><br><br><br><br><br>

    <header>
        <marquee>
        <h1>l'historique des locations pour chaque véhicule</h1>
    </marquee>
    </header>
    

    <?php
    $req000 = "SELECT DISTINCT  idV FROM location;";
    $stmt000 = $Connect->prepare($req000);
    if ($stmt000->execute()) {
        $result000 = $stmt000->get_result();
        if ($result000->num_rows > 0) {
            while ($row = $result000->fetch_assoc()) {
                $vehiculeId = $row['idV'];
                $req0011 = "SELECT marque, modele, annee, prixparjour,img FROM vehicules where idV=?";
                $stmt011 = $Connect->prepare($req0011);
                $stmt011->bind_param("i", $vehiculeId);


                if ($stmt011->execute()) {
                    $result011 = $stmt011->get_result();
                    if ($result011->num_rows > 0) {
                        echo '<br><div class="rental-history">
                        <h2>Historique de Location pour cette véhicule</h2>
                            <table>
                                <tr>
                                    <th>Image</th>
                                    <th>Marque</th>
                                    <th>Modèle</th>
                                    <th>Année</th>
                                    <th>Prix par Jour</th>
                                    
                                </tr>';
                        while ($row11 = $result011->fetch_assoc()) {
                            echo '<tr>
                            <td><img src=' . $row11["img"] . ' alt="Car Image"></td>
                            <td>' . $row11["marque"] . '</td>
                            <td>' . $row11["modele"] . '</td>
                            <td>' . $row11["annee"] . '</td>
                            <td>' . $row11["prixparjour"] . '</td>
                        </tr>';
                        }
                        echo '</table>
                        </div>';
                    }
                }

                $req022 = "SELECT l.idC, l.datedebut, l.datefin, l.prixtotal,
                    c.nom,
                    c.prenom,
                    c.adresse,
                    c.numtel,
                    c.email
                    FROM location l, clients c
                    WHERE l.idC = c.idC AND l.idV = ?;";
                $stmt022 = $Connect->prepare($req022);
                $stmt022->bind_param("i", $vehiculeId);
                if ($stmt022->execute()) {
                    $result022 = $stmt022->get_result();
                    if ($result022->num_rows > 0) {
                        while ($row02 = $result022->fetch_assoc()) {    
                            echo '
                            <div class="container">
                                <div class="client-info">
                                    <table>
                                        <tr>
                                            <th>Nom</th>
                                            <td>' . $row02["nom"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>prenom</th>
                                            <td>' . $row02["prenom"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>Adresse</th>
                                            <td>' . $row02["adresse"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>Numéro de Téléphone</th>
                                            <td>' . $row02["numtel"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>E-mail</th>
                                            <td>' . $row02["email"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>E-dateDate de débutdebut</th>
                                            <td>' . $row02["datedebut"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>E-Date de fin</th>
                                            <td>' . $row02["datefin"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>E-Prix total</th>
                                            <td>' . $row02["prixtotal"] . '</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>';
                        }

                        
                    }
                }

                $stmt011->close();
                $stmt022->close();
            }
        }   
    }

    ?>



    <header>
    <marquee>

        <h1> l'historique des locations pour chaque client. </h1>
    </marquee>

    </header>
    <?php
    $req00 = "SELECT DISTINCT  idC FROM location;";
    $stmt00 = $Connect->prepare($req00);

    if ($stmt00->execute()) {
        $result00 = $stmt00->get_result();
        if ($result00->num_rows > 0) {
            while ($row = $result00->fetch_assoc()) {
                $clientId = $row['idC'];

                $req01 = "SELECT nom, prenom, adresse, numtel, email FROM clients WHERE idC = ?;";
                $stmt01 = $Connect->prepare($req01);
                $stmt01->bind_param("i", $clientId);

                if ($stmt01->execute()) {
                    $result01 = $stmt01->get_result();

                    if ($result01->num_rows > 0) {
                        while ($row1 = $result01->fetch_assoc()) {
                            echo '
                            <div class="container">
                                <div class="client-info">
                                    <h2>Informations du Client</h2>
                                    <table>
                                        <tr>
                                            <th>Nom</th>
                                            <td>' . $row1["nom"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>prenom</th>
                                            <td>' . $row1["prenom"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>Adresse</th>
                                            <td>' . $row1["adresse"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>Numéro de Téléphone</th>
                                            <td>' . $row1["numtel"] . '</td>
                                        </tr>
                                        <tr>
                                            <th>E-mail</th>
                                            <td>' . $row1["email"] . '</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>';
                        }
                    }
                }

                $req02 = "SELECT l.idV, l.datedebut, l.datefin, l.prixtotal,
                    v.marque,
                    v.modele,
                    v.annee,
                    v.prixparjour,
                    v.img
                    FROM location l, vehicules v
                    WHERE l.idV = v.idV AND l.idC = ?;";
                $stmt02 = $Connect->prepare($req02);
                $stmt02->bind_param("i", $clientId);

                if ($stmt02->execute()) {
                    $result02 = $stmt02->get_result();

                    if ($result02->num_rows > 0) {
                        echo '<div class="rental-history">
                            <table>
                                <tr>
                                    <th>Image</th>
                                    <th>Marque</th>
                                    <th>Modèle</th>
                                    <th>Année</th>
                                    <th>Prix par Jour</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Prix total</th>
                                </tr>';

                        while ($row2 = $result02->fetch_assoc()) {
                            echo '<tr>
                            <td><img src=' . $row2["img"] . ' alt="Car Image"></td>
                            <td>' . $row2["marque"] . '</td>
                            <td>' . $row2["modele"] . '</td>
                            <td>' . $row2["annee"] . '</td>
                            <td>' . $row2["prixparjour"] . '</td>
                            <td>' . $row2["datedebut"] . '</td>
                            <td>' . $row2["datefin"] . '</td>
                            <td>' . $row2["prixtotal"] . '</td>
                        </tr>';
                        }

                        echo '</table>
                        </div>';
                    }
                }

                $stmt01->close();
                $stmt02->close();
            }
        }   
    }
    $Connect->close();

    ?>




</body>
</html>
