<?php
include 'DB.php';


if (isset($_POST['espaceAdmin'])) {
    header("Location: espaceAdmin.php");
}

if (isset($_POST['historique'])) {
    header("Location: historique.php");
}

$bd = new DB();
$Connect = $bd->connect();

if ($Connect->connect_error) {
    die("Connection error: " . $Connect->connect_error);
}

$sql2 = "SELECT * FROM clients";
$stmt2 = $Connect->prepare($sql2);
$client = [];

if ($stmt2->execute()) {
    $stmt2->bind_result($idC, $nom, $prenom, $adresse, $numtel, $email, $mdp);

    while ($stmt2->fetch()) {
        $client[] = [
            'idC' => $idC,
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'numtel' => $numtel,
            'email' => $email,
        ];
    }
} else {
    $ch = "Error: " . $stmt2->error;
    echo "<script>alert('$ch')</script>";
}

$stmt2->close();




if (isset($_POST['supprime']) && isset($_POST['idC'])) {
    $idC = $_POST['idC'];
    $sql = "DELETE FROM clients WHERE idC = ?";
    $stmt = $Connect->prepare($sql);
    $stmt->bind_param("i", $idC);
    if ($stmt->execute()) {
        header("Location: Clientss.php");
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$blocModify = "";
$userID =0 ;
if(isset($_POST['modifier'])){
    $userID = $_POST['idCmodifier'];
            
        $sql2 = "select * from clients where idC = ?";
        $stmt2 = $Connect->prepare($sql2);
        $stmt2->bind_param("i", $userID);
        
        if ($stmt2->execute()) {
            $stmt2->bind_result($idC, $nom, $prenom, $adresse, $numtel, $email, $mdp);
            $blocModify = '<div class="custom-container">
            <form id="inscription-form" class="custom-form" method="post" action="">
            <input type="hidden" name="idCmodifier" value='.$idC.'>

                <h2 class="custom-h2">Modifier son donnee</h2>
                <label for="nom" class="custom-label">Nom:</label>
                <input type="text" id="nom" name="nom" class="custom-input" value='.$nom.' required>
        
                <label for="prenom" class="custom-label">Prénom:</label>
                <input type="text" id="prenom" name="prenom" class="custom-input" value='.$prenom.' required>
        
                <label for="adresse" class="custom-label">Adresse:</label>
                <input type="text" id="adresse" name="adresse" class="custom-input" value='.$adresse.' required>
        
                <label for="telephone" class="custom-label">Numéro de téléphone:</label>
                <input type="tel" id="telephone" name="telephone" class="custom-input" value='.$numtel.' required>
        
                <label for="email" class="custom-label">Email:</label>
                <input type="email" id="email" name="email" class="custom-input" value='.$email.' required>
        
                <label for="mdp" class="custom-label">Mot de passe:</label>
                <input type="text" id="mdp" name="mdp" class="custom-input" value='.$mdp.' required>
        
                <button type="submit" name="submitModification" class="custom-button">Modifier</button>
            </form>
        </div>';
        


        } else {
            $ch = "Error: " . $stmt2->error;
            echo "<script>alert('$ch')</script>";
        }

        // ferme  statement
        $stmt2->close();

}


if(isset($_POST['submitModification'])){
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse = $_POST["adresse"];
    $numtel = $_POST["telephone"];
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];
    $userID = $_POST["idCmodifier"];
    $sql = "UPDATE clients SET nom=?, prenom=?, adresse=?, numtel=?, email=?, mdp=? WHERE idC=?";
    $stmt = $Connect->prepare($sql);
    $stmt->bind_param("ssssssi", $nom, $prenom, $adresse, $numtel, $email, $mdp, $userID);
    if ($stmt->execute()) {
        header("Location: Clientss.php");
    } else {
        $ch = "Error: " . $stmt->error;
        echo "<script>alert('$ch')</script>";
    }
    $stmt->close();
}


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

        .custom-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .custom-form {
        width: 50%;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    .custom-h2 {
        color: #333;
    }

    .custom-label {
        display: block;
        margin: 10px 0 5px;
    }

    .custom-input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    .custom-button {
        background-color: #3498db;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .custom-button:hover {
        background-color: #2980b9;
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
        <button type="submit" class="navbtn" name="historique">historique</button>
        </form>

    </div>
</nav><br><br><br><br><br><br>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Adresse</th>
            <th>Numéro de téléphone</th>
            <th>Email</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($client as $c) : ?>
            <tr>
                <td><?php echo $c['idC']; ?></td>
                <td><?php echo $c['nom']; ?></td>
                <td><?php echo $c['prenom']; ?></td>
                <td><?php echo $c['adresse']; ?></td>
                <td><?php echo $c['numtel']; ?></td>
                <td><?php echo $c['email']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="idCmodifier" value="<?php echo $c['idC']; ?>">
                        <button type="submit" class="blue-button" name="modifier">Modifier</button>
                    </form>
                </td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="idC" value="<?php echo $c['idC']; ?>">
                        <button type="submit" class="red-button" name="supprime" >Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php 
if($blocModify != ""){
    echo $blocModify ;
}
?>

</body>
</html>
