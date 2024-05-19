
<?php

session_start();
$userID = $_SESSION["idclient"];
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
if(isset($_POST['logOut'])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
if(isset($_POST['reserver'])){
    $idVR = $_POST['idVR'];
    session_start();
    $_SESSION["idclientR"] = $userID;
    $_SESSION["idVR"] = $idVR;
    $_SESSION["PRIXT"]=0;
    $_SESSION["RETURNDATE"]="";
    $_SESSION["PICKUPDATE"]= "";
    header("Location: reservation.php");
    exit();
    

    
}



include 'DB.php';
$bd = new DB();
$Connect = $bd->connect();

if ($Connect->connect_error) {
    die("Connection error: " . $Connect->connect_error);
}
$sql2 = "select * from clients where idC = ?";
$stmt2 = $Connect->prepare($sql2);
$stmt2->bind_param("i", $userID);
$client=[];
if ($stmt2->execute()) {
    $stmt2->bind_result($idC, $nom, $prenom, $adresse, $numtel, $email, $mdp);    while ($stmt2->fetch()) {
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

// ferme  statement
$stmt2->close();


$rows =[];

if (isset($_POST['submitFilter'])) {
    $selectedMarques = $_POST['marque'];
    $marquesFilter = implode("', '", (array) $selectedMarques);

    $selectedAnnees = $_POST['annee'];
    $anneesFilter = implode("', '", (array) $selectedAnnees);

    $tabV = [];
    $sql3 = "SELECT idV, marque, modele, annee, prixparjour, disponible, img FROM vehicules
            WHERE marque IN ('$marquesFilter') AND annee IN ('$anneesFilter')";

    $stmt3 = $Connect->prepare($sql3);

    if (!$stmt3) {
        $ch = "Error in prepare statement: " . $Connect->error;
        echo "<script>alert('$ch')</script>";
    } else {
        if ($stmt3->execute()) {
            $stmt3->bind_result($idV, $marque, $modele, $annee, $prixparjour, $disponible, $img);

            while ($stmt3->fetch()) {
                $tabV[] = [
                    'idV' => $idV,
                    'marque' => $marque,
                    'modele' => $modele,
                    'annee' => $annee,
                    'prixparjour' => $prixparjour,
                    'disponible' => $disponible,
                    'img' => $img,
                ];
            }
            $_SESSION["rowsF"] = $tabV;
           // echo "<script>alert('Number of rows: " . count($tabV) . "')</script>";
        } else {
            $ch = "Error: " . $stmt3->error;
            echo "<script>alert('$ch')</script>";
        }

        // Close the statement
        $stmt3->close();
    }
}




session_start();
$rowsF = $_SESSION["rowsF"];
//echo "<script>alert('Number of rows: " . count($rowsF) . "')</script>";
if(count($rowsF) == 0){
    
$sql = "SELECT idV, marque, modele, annee, prixparjour, disponible,img FROM vehicules";
//$sql2 = "select * from clients where idC = ?";

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
}else{
    $rows = $rowsF ;
}


$Connect->close();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            
            background-color: #f8f8f8; /* Background color of the store */
            
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
            background-color: #c1c4bc;
        }

        .product {
            position: relative;
            width: 300px;
            margin: 20px;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s;
            overflow: hidden; /* Hide overflow for rounded corners */
            border-radius: 10px; /* Add border radius */
        }

        .product:hover {
            transform: scale(1.05);
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            border-top-left-radius: 10px; /* Adjust border radius for top left */
            border-top-right-radius: 10px; /* Adjust border radius for top right */
        }

        .product-label {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #e44d26; /* Orange background color */
            color: #fff;
            padding: 5px;
            border-radius: 5px;
            font-weight: bold;
            z-index: 2; /* Ensure the label is on top */
        }

        .product-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .product-info span {
            flex: 1;
            text-align: center;
        }

        .product-price {
            font-size: 1.4em;
            color: #e44d26; /* Orange color for price */
        }

        .buy-button {
            background-color: #e44d26;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 1.2em;
            border-radius: 5px;
        }
        .product-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px; /* Add padding for spacing */
            border-top: 1px solid #ddd; /* Add a top border for separation */
        }

        .product-info span {
            flex: 1;
            text-align: center;
            font-size: 1em; /* Adjust font size as needed */
            color: #555; /* Adjust text color as needed */
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

        
        
.welcome-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 60vh;
}

.welcome-message {
    background-color: #3498db;
    color: #fff;
    padding: 20px;
    border-radius: 8px;
    font-size: 24px;
    animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

        .filter-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center; /* Ajout de l'alignement central pour le texte */
        }

        .filter-group {
            margin-bottom: 15px;
            margin-left: 450px; 
            display: flex; /* Utilisation de flexbox pour aligner les éléments horizontalement */
            align-items: center; /* Centrage vertical des éléments dans le groupe */
        }

        .filter-group label {
            margin-right: 10px;
        }

        .btnfltr {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btnfltr:hover {
            background-color: #2980b9;
        }

        .h2fltr {
            color: #3498db;
        }
        

    </style>
</head>
<body>
<nav>
    <img src="v.png" alt="Logo" class="logo">
    <div class="boutique-name">DRIDI CARS</div>
    <div class="nav-buttons">
    <form class="form" method="post" action="">
        <button type="submit" class="navbtn" name="acl">Accueil</button>
        <button type="submit" class="navbtn" name="cpt">Compte</button>
        <button type="submit" class="navbtn" name="logOut">log out</button>
        </form>

    </div>
</nav><br><br><br><br><br><br>


<div class="welcome-container">
        <?php
        foreach ($client as $row){
            $prenom = $row['prenom'];
            $nom = $row['nom'];
            $adresse = $row['adresse'];
            $numtel = $row['numtel'];
            $email = $row['email'];

            echo "<div class='welcome-message'>
                    <p>Bienvenue, $prenom $nom !</p>
                    <p>Nous sommes ravis de vous accueillir à l'adresse suivante :</p>
                    <p>$adresse</p>
                    <p>Vous pouvez nous contacter au numéro de téléphone : $numtel</p>
                    <p>Votre adresse email enregistrée est : $email</p>
                 </div>";
        }
            
        ?>
    </div>


    <div class="filter-container">
        <form method="post" action="">
            <h2 class="h2fltr">Filtrage des Véhicules</h2>
            
            <div class="filter-group">
                <label>Marques :</label>
                <input type="checkbox" id="toyota" name="marque[]" value="Toyota" checked>
                <label for="toyota">Toyota</label>

                <input type="checkbox" id="honda" name="marque[]" value="Honda" checked>
                <label for="honda">Honda</label>

                <input type="checkbox" id="ford" name="marque[]" value="Ford" checked>
                <label for="ford">Ford</label>

                <input type="checkbox" id="peugeot" name="marque[]" value="Peugeot" checked>
                <label for="peugeot">Peugeot</label>
            </div>

            <div class="filter-group">
                <label>Années :</label>
                <input type="checkbox" id="annee2021" name="annee[]" value="2021" checked>
                <label for="annee2021">2021</label>

                <input type="checkbox" id="annee2022" name="annee[]" value="2022" checked>
                <label for="annee2022">2022</label>

                <input type="checkbox" id="annee2023" name="annee[]" value="2023" checked>
                <label for="annee2023">2023</label>
            </div>

            <button type="submit" name="submitFilter" class="btnfltr">Filtrer</button>
        </form>
    </div>


<div class="product-container">
<?php
foreach ($rows as $row) {
    $idV = $row['idV'];
    $marque = $row['marque'];
    $modele = $row['modele'];
    $annee = $row['annee'];
    $prixparjour = $row['prixparjour'];
    $disponible = $row['disponible'];
    $img = $row['img'];

    $disableSubmitButton = ($disponible == false) ? true : false;

    echo "<div class='product'>";
    echo "    <div class='product-label'>" . ($disponible == true ? 'disponible' : 'non disponible') . "</div>";
    echo "    <img src='$img' alt='Product $idV'>";
    echo "    <div class='product-info'>";
    echo "        <span>Marque: $marque</span>";
    echo "        <span>Modele: $modele</span>";
    echo "        <span>Annee: $annee</span>";
    echo "    </div>";
    echo "    <div class='product-price'>$prixparjour DT/Jour</div>";
    echo "<form class='form' method='post' action=''>
        <input type='hidden' name='idVR' value='$idV'>  
        <button class='buy-button' name='reserver' " . ($disableSubmitButton ? 'disabled' : '') . ">Reserve</button>
    </form>";
    echo "</div>";
}
?>

    
</div>

</body>
</html>