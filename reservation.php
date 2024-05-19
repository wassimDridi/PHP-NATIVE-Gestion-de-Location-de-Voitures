<?php
include 'DB.php';
include 'Location.php';
$vehiculeR=[];
session_start();
$userID = $_SESSION["idclientR"];
$idVR = $_SESSION["idVR"];
$PRIXT = $_SESSION["PRIXT"] ;
$PPJ = 0 ;
$RETURNDATE = $_SESSION["RETURNDATE"];
$PICKUPDATE= $_SESSION["PICKUPDATE"];


if(isset($_POST['espaceClient'])){
    session_start();
    $_SESSION["idclient"] = $userID;
    header("Location: indexi.php");
    exit();
}

$bd = new DB();
$Connect = $bd->connect();

if ($Connect->connect_error) {
    die("Connection error: " . $Connect->connect_error);
}

$sql2 = "select * from vehicules where idV = ?";
$stmt2 = $Connect->prepare($sql2);
$stmt2->bind_param("i", $idVR);

if ($stmt2->execute()) {
    $stmt2->bind_result($idV, $marque, $modele, $annee, $prixparjour, $disponible, $img);
        while ($stmt2->fetch()) {
            $vehiculeR[] = [
                'idV' => $idV,
                'marque' => $marque,
                'modele' => $modele,
                'annee' => $annee,
                'prixparjour' => $prixparjour,
                'disponible' => $disponible,
                'img' => $img,
            ];
            $PPJ= $prixparjour ;
        }
    


} else {
    $ch = "Error: " . $stmt2->error;
    echo "<script>alert('$ch')</script>";
}

// ferme  statement
$stmt2->close();



if(isset($_POST['dateValider'])){
    if (isset($_POST['return-date']) && isset($_POST['pickup-date'])) {
        $returnDate = strtotime($_POST['return-date']);
        $pickupDate = strtotime($_POST['pickup-date']);
        $RETURNDATE = $returnDate ;
        $PICKUPDATE = $pickupDate ;
        if ($returnDate > $pickupDate) {
            // Valid dates, calculate the number of days
            $numberOfDays = floor(($returnDate - $pickupDate) / (60 * 60 * 24));
                $PRIXT = $PPJ * $numberOfDays;
                $RETURNDATE = $_POST['return-date'] ;
                $PICKUPDATE = $_POST['pickup-date'] ;
                session_start();
                $_SESSION["idclientR"] = $userID;
                $_SESSION["idVR"] = $idVR;
                $_SESSION["PRIXT"]= $PRIXT;
                $_SESSION["RETURNDATE"]=$RETURNDATE;
                $_SESSION["PICKUPDATE"]= $PICKUPDATE;
                header("Location: reservation.php");
                exit();

        } else {
            echo "Invalid dates. Return date should be greater than pickup date.";
        }
    }
}

if(isset($_POST['approve'])){
    if($PRIXT != 0){
        $location = new Location($userID , $idVR ,$PICKUPDATE ,$RETURNDATE ,$PRIXT ,$bd);
        
    }
    
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de location de voiture</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f5f5f5;
    margin: 0;
}

.car-rental-form {
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-section {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#total-price {
    display: inline-block;
    font-weight: bold;
    color: #27ae60;
}

.car-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.car-info p {
    flex-grow: 1;
}

.car-icon img {
    max-width: 50px;
    border-radius: 50%;
}

.approve-button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #27ae60;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.approve-button:hover {
    background-color: #219653;
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

        img {
            max-width: 30%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius : 50%;
        }
        .date-valider {
  
    right: 0;
    padding: 8px;
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.date-valider:hover {
    background-color: #2980b9;
}

    </style>
</head>
<body>
    <nav>
        <img src="v.png" alt="Logo" class="logo">
        <div class="boutique-name">DRIDI CAR</div>
        <div class="nav-buttons">
        <form class="form" method="post" action="">
            <button type="submit" class="navbtn" name="espaceClient">Admin</button>
            </form>
    
        </div>
    </nav><br><br><br><br><br><br>


    


    <form class="car-rental-form" method="post" action="">
        <div class="form-section">
            <label for="pickup-date">Date de prise :</label>
            <input type="date" id="pickup-date" name="pickup-date">

            <label for="return-date">Date de restitution :</label>
            <input type="date" id="return-date" name="return-date">
            <button type="submit" class="date-valider" name="dateValider">Valider la date</button>
        </div>

        <div class="form-section">
            <label>Total :</label>
            <span id="total-price"> <?php echo $PRIXT ; ?> DT</span>
        </div>
        

        <?php
        foreach ($vehiculeR as $row) {
            $img = $row['img'];
            $marque = $row['marque'];
            $modele = $row['modele'];
            $annee = $row['annee'];

        echo '<div class="form-section car-info">
                <p>Marque : '.$marque.'</p>
                <p>Modele : '.$modele.'s</p>
                <p>Année : '.$annee.'</p>
                <div class="car-icon">
                    <img src='.$img.' alt="Car Icon">
                </div>
            </div>';
        
    }
        ?>
        

        <button type="submit" class="approve-button" name="approve">Approuver la location</button>
    </form>
</body>
</html>
