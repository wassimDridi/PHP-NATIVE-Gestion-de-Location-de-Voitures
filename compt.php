<?php


if(isset($_POST['acl'])){
    $_SESSION["idclient"] = $userID;
    header("Location: indexi.php");
    exit();
}
if(isset($_POST['cpt'])){
    $_SESSION["idclient"] = $userID;
    header("Location: compt.php");
    exit();
}
session_start();
$userID = $_SESSION["idclient"];



$locationH = []; 
include 'DB.php';
$bd = new DB();
$Connect = $bd->connect();
if ($Connect->connect_error) {
    die("Connection error: " . $Connect->connect_error);
}

if(isset($_POST['submitModification'])){
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse = $_POST["adresse"];
    $numtel = $_POST["telephone"];
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];
    $sql = "UPDATE clients SET nom=?, prenom=?, adresse=?, numtel=?, email=?, mdp=? WHERE idC=?";
    $stmt = $Connect->prepare($sql);
    $stmt->bind_param("ssssssi", $nom, $prenom, $adresse, $numtel, $email, $mdp, $userID);    
        if ($stmt->execute()) {
            echo "<script>alert('modidication avec succès.')</script>";
        
        } else {
            $ch="Error: " . $stmt->error;
            echo "<script>alert(.$ch.)</script>";
        }
        //header('location:espaceClient.php');
        $stmt->close();
}


$nomR  ="";
$prenomR  ="";

$sql2 = "select * from clients where idC = ?";
$stmt2 = $Connect->prepare($sql2);
$stmt2->bind_param("i", $userID);
$client=[];
if ($stmt2->execute()) {
    $stmt2->bind_result($idC, $nom, $prenom, $adresse, $numtel, $email, $mdp);
        while ($stmt2->fetch()) {
        $client[] = [
            'idV' => $idC,
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'numtel' => $numtel,
            'email' => $email,
            'mdp' => $mdp,
            ];
            $nomR = $nom ;
            $prenomR = $prenom ;
    }
    


} else {
    $ch = "Error: " . $stmt2->error;
    echo "<script>alert('$ch')</script>";
}

// ferme  statement
$stmt2->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Boutique</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #d9d9d9;
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
            border-radius: 50%;
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
        
.container {
    display: flex;
    justify-content: space-between;
    width: 80%;
    margin: auto;
}

.form {
    width: 45%;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
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




.history-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .client-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .client-name {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        td img {
            max-width: 80px;
            max-height: 60px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<nav>
    <img src="v.png" alt="Logo" class="logo">
    <div class="boutique-name">DRIDI CAR</div>
    <div class="nav-buttons">
    <form class="" method="post" action="">

        <button type="submit" class="navbtn" name="acl">Accueil</button>
        <button type="submit" class="navbtn" name="cpt">Compt</button>
        </form>
    </div>
</nav><br><br><br><br><br><br>
<div class="history-container">
        <div class="client-info">
            <p class="client-name">Votre Historique Mr <?php echo $nomR." ". $prenomR; ?> </p>
        </div>
        <?php

                $sql = "SELECT l.idV, l.datedebut, l.datefin, l.prixtotal, v.marque, v.modele, v.annee, v.img
                        FROM location l
                        JOIN vehicules v ON l.idV = v.idV
                        WHERE l.idC = ?";
                $stmt = $Connect->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("i", $userID);

                    if ($stmt->execute()) {
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            $locationH[] = [
                                'idV' => $row['idV'],
                                'datedebut' => $row['datedebut'],
                                'datefin' => $row['datefin'],
                                'prixtotal' => $row['prixtotal'],
                                'marqueVR' => $row['marque'],
                                'modeleVR' => $row['modele'],
                                'anneeVR' => $row['annee'],
                                'imgVR' => $row['img'],
                            ];
                        }
                    } else {
                        $ch = "Error in execution: " . $stmt->error;
                        echo "<script>alert('$ch')</script>";
                    }

                    $stmt->close();
                } else {
                    $ch = "Error in prepare statement: " . $Connect->error;
                    echo "<script>alert('$ch')</script>";
                }
                ?>




        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Année</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Prix total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        foreach ($locationH as $row) {
                            
                            $datedebut = $row['datedebut'];
                            $datefin = $row['datefin'];
                            $prixtotal = $row['prixtotal'];
                            $marqueVR = $row['marqueVR'];
                            $modeleVR = $row['modeleVR'];
                            $anneeVR = $row['anneeVR'];
                            $imgVR = $row['imgVR'];
                ?>
                <tr>
                    <td><img src="<?php echo $imgVR; ?>" alt="Voiture 1"></td>
                    <td><?php echo $anneeVR; ?></td>
                    <td><?php echo $marqueVR; ?></td>
                    <td><?php echo $modeleVR; ?></td>
                    <td><?php echo $datedebut; ?></td>
                    <td><?php echo $datefin; ?></td>
                    <td><?php echo $prixtotal; ?> DT</td>
                </tr>

                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

<?php
        foreach ($client as $row){
            $prenom = $row['prenom'];
            $nom = $row['nom'];
            $adresse = $row['adresse'];
            $numtel = $row['numtel'];
            $email = $row['email'];

                 echo '<center>  <br><br><br><div class="container">
            <form id="inscription-form" class="form" method="post" action="">
                <h2>Modifier son donnee</h2>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value='.$nom.' required>
    
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value='.$prenom.' required>
    
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" value='.$adresse.' required>
    
                <label for="telephone">Numéro de téléphone:</label>
                <input type="tel" id="telephone" name="telephone" value='.$numtel.' required>
    
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value='.$email.' required>
    
                <label for="mdp">Mot de passe:</label>
                <input type="text" id="mdp" name="mdp" value='.$mdp.' required>
    
                <button type="submit" name="submitModification">Modifier</button>
            </form></div></center>' ;
        }
            
        ?>
        

</body>
</html>
