<?php
include 'Vehicule.php';
if(isset($_POST['submitAjouterVehicule'])){
    //header('location:espaceClient.php');
    $marque = $_POST["marque"];
    $modele = $_POST["modele"];
    $annee = $_POST["annee"];
    $prixParJour = $_POST["prix"];
    $dispo = $_POST["disponible"];
    $img="";




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
    $vehicul = new Vehicule($marque, $modele, $annee, $prixParJour, $disponible, $img);
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
    background: url('1.jpg') center/cover no-repeat;
            transition: background-image 1s ease;
            animation: changeBackground 16s infinite;
}
@keyframes changeBackground {
            0% { background-image: url('1.png'); }
            25% { background-image: url('2.png'); }
            50% { background-image: url('3.png'); }
            75% { background-image: url('4.png'); }
            100% { background-image: url('1.png'); }
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
        <form id="vehicle-form" method="POST" action="" enctype="multipart/form-data">
            <h2>Formulaire de Véhicule</h2>

            <label for="marque">Marque :</label>
            <input type="text" id="marque" name="marque" required>

            <label for="modele">Modèle :</label>
            <input type="text" id="modele" name="modele" required>

            <label for="annee">Année :</label>
            <input type="number" id="annee" name="annee" required>

            <label for="prix">Prix par jour :</label>
            <input type="number" id="prix" name="prix" required>

            <label>Disponible :</label>
            <div class="radio-group">
                <label for="disponible-oui">Oui</label>
                <input type="radio" id="disponible-oui" name="disponible" value="oui" required>

                <label for="disponible-non">Non</label>
                <input type="radio" id="disponible-non" name="disponible" value="non" required>
            </div>

            <label for="image">Saisir une image :</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit" name="submitAjouterVehicule">Soumettre</button>
        </form>
    </div>
</body>
</html>