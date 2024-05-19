<?php

session_start();
$idVehicule = $_SESSION["IDV"];
$img = "";
include 'DB.php';
$bd = new DB();
$Connect = $bd->connect();
$Vehicule = [];
if ($Connect->connect_error) {
    die("Connection error: " . $Connect->connect_error);
}
$sql2 = "select * from vehicules where idV = ?";
$stmt2 = $Connect->prepare($sql2);
$stmt2->bind_param("i", $idVehicule);
$client=[];
if ($stmt2->execute()){
    $stmt2->bind_result($idV, $marque, $modele, $annee, $prixparjour, $disponible, $img);  
      while ($stmt2->fetch()) {
        $Vehicule[] = [
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
            $ch = "Error: " . $stmt2->error;
            echo "<script>alert('$ch')</script>";
            }

// ferme  statement
$stmt2->close();





if(isset($_POST['submitModifierVehicule'])){
    //header('location:espaceClient.php');
    $marque = $_POST["marque"];
    $modele = $_POST["modele"];
    $annee = $_POST["annee"];
    $prixParJour = $_POST["prix"];
    $dispo = $_POST["disponible"];
    $img=$Vehicule [0] ['img'];

    
        // Check if a file was successfully uploaded
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
            // Temporary location of the uploaded file
            $tmpFilePath = $_FILES["image"]["tmp_name"];
    
            // Check if the file is an image
            if (getimagesize($tmpFilePath)) {
                // Destination directory to save the uploaded file
                $uploadDir = "uploads/";
    
                // Create the directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
    
                // Generate a unique filename based on the current timestamp
                $fileName = time() . "_" . $_FILES["image"]["name"];
    
                // Full path of the file in the destination directory
                $filePath = $uploadDir . $fileName;
    
                // Move the uploaded file to the destination directory
                if (move_uploaded_file($tmpFilePath, $filePath)) {
                    // Display the uploaded image on the HTML page
                    $img= $filePath;
                } else {
                    echo "Error moving the file. Check file permissions.";
                }
            } else {
                echo "The uploaded file is not a valid image.";
            }
        } else {
            echo $_FILES["image"]["error"];
        }


        
        
        $disponible = ($dispo == "oui");


        $sql = "UPDATE vehicules SET marque=?, modele=?, annee=?, prixparjour=?, disponible=?, img=? WHERE idV=?";
        $stmt = $Connect->prepare($sql);
        $stmt->bind_param("ssssssi", $marque, $modele, $annee, $prixParJour, $disponible, $img ,$idVehicule);    
        if ($stmt->execute()) {
            echo "<script>alert('modidication avec succès.')</script>";
            header('location: espaceAdmin.php');
        } else {
            $ch="Error: " . $stmt->error;
            echo "<script>alert(.$ch.)</script>";
        }
        //
        $stmt->close();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Formulaire de Véhicule</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

form {
    max-width: 400px;
    margin: auto;
}

h2 {
    color: #333;
}

label {
    display: block;
    margin: 10px 0 5px;
}

input,
select,
button {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

.radio-group {
    display: flex;
    justify-content: space-around;
    margin-bottom: 10px;
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

    </style>
</head>
<body>
    <div class="container">
        <?php

        foreach ($Vehicule as $row){
            $marque = $row['marque'];
            $modele = $row['modele'];
            $annee = $row['annee'];
            $prixparjour = $row['prixparjour'];
            $disponible = $row['disponible'];
            $img = $row['img'];

            echo '<form id="vehicle-form" method="POST" action="" enctype="multipart/form-data">
            <h2>Modifier de Véhicule</h2>

            <label for="marque">Marque :</label>
            <input type="text" id="marque" value='.$marque.' name="marque" required>

            <label for="modele">Modèle :</label>
            <input type="text" id="modele" value='.$modele.' name="modele" required>

            <label for="annee">Année :</label>
            <input type="number" id="annee" value='.$annee.' name="annee" required>

            <label for="prix">Prix par jour :</label>
            <input type="number" id="prix" value='.$prixparjour.' name="prix" required>

            <label>Disponible :</label>
            <div class="radio-group">
                <label for="disponible-oui">Oui</label>
                <input type="radio" id="disponible-oui" name="disponible" value="oui" required>

                <label for="disponible-non">Non</label>
                <input type="radio" id="disponible-non" name="disponible" value="non" required>
            </div>

            <label for="image">Saisir une image :</label>
            <input type="file" id="image" name="image" accept="image/*" >

            <button type="submit" name="submitModifierVehicule">Soumettre</button>
        </form>';


        }
        ?>
    </div>
</body>
</html>