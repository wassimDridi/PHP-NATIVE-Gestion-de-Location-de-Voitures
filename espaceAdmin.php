<?php
include 'DB.php';

$bd = new DB();
$Connect = $bd->connect();

if ($Connect->connect_error) {
    die("Connection error: " . $Connect->connect_error);
}
$idVehicule = 0 ;
if(isset($_POST['espaceAdmin'])){
    header("Location: espaceAdmin.php");
}
if(isset($_POST['logOut'])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
}
if(isset($_POST['Clients'])){
    header("Location: Clientss.php");
}
if(isset($_POST['sendEmail'])){
    header("Location: sendEmail.php");
}
if(isset($_POST['historique'])){
    header("Location: historique.php");
}
if(isset($_POST['ajouter'])){
    header("Location: adminAjouterV.php");
}
if(isset($_POST['Modifier'])){
    $idVehicule = $_POST['idV'];
    session_start();
    $_SESSION["IDV"] = $idVehicule ;
    header("Location: Modifier.php");
    exit();
}
if(isset($_POST['Supprimer'])){
    $idVehicule = $_POST['idV'];
    $sql = "DELETE FROM vehicules WHERE idV = ?";
    $stmt = $Connect->prepare($sql);
    $stmt->bind_param("i", $idVehicule); 
    $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user > 0) {
            echo "<script>alert('vehicule suppremer  avec succès.')</script>";
        } else {
            // Login failed
            echo "<script>alert('log in refese.')</script>";
        }
        $stmt->close();
    header("Location: espaceAdmin.php");
}




$rows =[];
$resultatSelect = null;
$sql = "SELECT idV, marque, modele, annee, prixparjour, disponible,img FROM vehicules";
$stmt = $Connect->prepare($sql);
//$stmt->bind_param();
if (!$stmt) {
    $ch = "Error in prepare statement: " . $Connect->error;
    echo "<script>alert('$ch')</script>";
} else {
    if ($stmt->execute()) {
        $stmt->bind_result($idV, $marque, $modele, $annee, $prixparjour, $disponible, $img);
        while ($stmt->fetch()) {
            $rows[] = [
                'idV' => $idV,
                'marque' => $marque,
                'modele' => $modele,
                'annee' => $annee,
                'prixparjour' => $prixparjour,
                'disponible' => $disponible,
                'img' => $img,
            ];
        }
        


    } else {
        $ch = "Error: " . $stmt->error;
        echo "<script>alert('$ch')</script>";
    }

    // ferme  statement
    $stmt->close();
}

$Connect->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Table</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #c1c4bc;

        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        img {
            max-width: 30%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius : 50%;
        }

        th:nth-child(7), td:nth-child(7),
        th:nth-child(8), td:nth-child(8) {
            text-align: center;
        }

        .blue-button, .red-button {
            display: inline-block;
            padding: 8px 16px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-align: center;
            text-decoration: none;
            outline: none;
        }

        .blue-button {
            background-color: #3498db;
            color: #fff;
        }

        .red-button {
            background-color: #e74c3c;
            color: #fff;
        }

        @media screen and (max-width: 600px) {
            th, td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            th:nth-child(7), td:nth-child(7),
            th:nth-child(8), td:nth-child(8) {
                text-align: center;
            }

            .blue-button, .red-button {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }
            
        }
        nav {
            background-color: #3498db; /* Navbar background color */
            padding: 10px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Navbar box shadow */
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
            background-color: #2980b9; /* Navbar background color on hover */
        }

        .logo {
            max-width: 100px;
            height: auto;
        }

        .boutique-name {
            color: #fff;
            font-size: 1.5em;
            font-weight: bold;
            margin-right: auto;
        }
        .navbtn {
            background-color: #e44d26;
            color: #fff;
            padding: 10px;
            margin-right: 100px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .navbtn:hover {
            background-color: #27ae60;
        }


        .add-vehicle-block h2 {
            
        }
        .add-vehicle-block {
            background-color: #3498db; /* Blue background color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            animation: fadeInUp 0.5s ease-out;
            color: #fff; /* White text color */
        }

        .abutton {
            background-color: #e44d26; /* Orange button color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .abutton:hover {
            background-color: #c5371d; /* Darker orange on hover */
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<nav>
    <img src="v.png" alt="Logo" class="logo">
    <div class="boutique-name">DRIDI CARS</div>
    <div class="nav-buttons">
    <form class="form" method="post" action="">
        <button type="submit" class="navbtn" name="espaceAdmin">Admin</button>
        <button type="submit" class="navbtn" name="Clients">Clients </button>
        <button type="submit" class="navbtn" name="sendEmail">send Email </button>
        <button type="submit" class="navbtn" name="historique">historique</button>
        <button type="submit" class="navbtn" name="logOut">log out</button>
        </form>

    </div>
</nav><br><br><br><br><br><br>

<div class="add-vehicle-block">
    <h2>Ajouter une nouvelle véhicule...</h2>
    <form class="form" method="post" action="">
    <button type="submit" class="abutton" name="ajouter">Ajouter</button>
    </form>
</div>

<table>
    <tr>
        <th>Image</th>
        <th>Marque</th>
        <th>Modele</th>
        <th>Annee</th>
        <th>Prix par Jour</th>
        <th>Disponible</th>
        <th>Modifier</th>
        <th>Supprimer</th>
    </tr>

    <?php
    foreach ($rows as $row) {
        $idVehicule = $row['idV'];
        $img = $row['img'];
        $marque = $row['marque'];
        $modele = $row['modele'];
        $annee = $row['annee'];
        $prixparjour = $row['prixparjour'];
        $disponible = $row['disponible'];
        
        ?>

        <tr>
            <td><img src='<?php echo $img; ?>' alt='Product Image' ></td>
            <td><?php echo $marque; ?></td>
            <td><?php echo $modele; ?></td>
            <td><?php echo $annee; ?></td>
            <td><?php echo $prixparjour; ?></td>
            <td><?php echo ($disponible == true ? 'disponible' : 'non disponible'); ?></td>
            <td>    <form class="form" method="post" action="">
                <input type="hidden" name="idV" value="<?php echo $idVehicule; ?>">
                <button class="blue-button" type="submit"  name="Modifier">Modifier</button></form></td>
            <td>    <form class="form" method="post" action="">
                <input type="hidden" name="idV" value="<?php echo $idVehicule; ?>">
                <button class="red-button" type="submit"  name="Supprimer">Supprimer</button></form></td>
        </tr>

        <?php
    }
    
    ?>
</table>

</body>
</html>
