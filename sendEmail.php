<?php
include 'DB.php';

$bd = new DB();
$Connect = $bd->connect();

if ($Connect->connect_error) {
    die("Connection error: " . $Connect->connect_error);
}
if(isset($_POST['espaceAdmin'])){
    header("Location: espaceAdmin.php");
}
if(isset($_POST['Clients'])){
    header("Location: Clientss.php");
}

if(isset($_POST['historique'])){
    header("Location: historique.php");
}
if (isset($_POST['sendAllEmail'])) {
    $req022 = "SELECT l.idC, l.datedebut, l.datefin, l.prixtotal,
                c.nom,
                c.prenom,
                c.adresse,
                c.numtel,
                c.email
                FROM location l
                INNER JOIN clients c ON l.idC = c.idC
                WHERE DATE_ADD(CURDATE(), INTERVAL 1 DAY) = DATE(l.datefin);";

    $stmt022 = $Connect->prepare($req022);

    if ($stmt022->execute()) {
        $result022 = $stmt022->get_result();

        if ($result022->num_rows > 0) {
            while ($row02 = $result022->fetch_assoc()) {
                $email = $row02['email'];
                $nom = $row02['nom'];
                $prenom = $row02['prenom'];
                $datefin = $row02['datefin'];
                

                sendEmail($email, $nom ,$prenom ,$datefin);
            }
        } else {
            echo "No records found.";
        }
    } else {
        echo "Error executing query: " . $stmt022->error;
    }

    $stmt022->close();
}
function sendEmail($toEmail, $nom, $prenom, $datefin)
{
    
    $subject = "Rappel de restitution de voiture";
    $message = "Cher {$nom} {$prenom}" .
    "Nous vous rappelons de restituer votre voiture louée avant la date limite de retour le {$datefin}" .
    "Merci de votre coopération" .
    "Cordialement,<br>Votre équipe Dridi Cars";


    
    echo "<script type='text/javascript'>
        Email.send({
            SecureToken: '0cd25265-cbc3-49c0-9310-6af48cdb12a3',
            To: '{$toEmail}',
            From: 'wassimdridi724@gmail.com',
            Subject: '{$subject}',
            Body: '{$message}'
        }).then(
            function(message) {
                alert('Message envoyé à {$nom} {$prenom} : ' + message);
                console.log('Message envoyé à {$nom} {$prenom} : ' + message);
            }
        );
    </script>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #c1c4bc;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        td {
            background-color: #f8f8f8;
        }

        tbody tr:hover {
            background-color: #e0e0e0;
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

        /* Your existing styles for form and button */
.form {
    text-align: center; /* Center-align the button within the form */
}

.sendAllEmail {
    background-color: #3498db; /* Button background color */
    color: #fff; /* Button text color */
    padding: 10px 20px; /* Padding for the button */
    border: none; /* Remove button border */
    border-radius: 5px; /* Add a slight border-radius for rounded corners */
    cursor: pointer; /* Add a pointer cursor on hover */
    font-size: 16px; /* Adjust font size */
}

.sendAllEmail:hover {
    background-color: #2980b9; /* Button background color on hover */
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
        <button type="submit" class="navbtn" name="historique">historique</button>
        </form>

    </div>
</nav><br><br><br><br><br><br>
    <?php
    $req022 = "SELECT l.idC, l.datedebut, l.datefin, l.prixtotal,
    c.nom,
    c.prenom,
    c.adresse,
    c.numtel,
    c.email
    FROM location l
    INNER JOIN clients c ON l.idC = c.idC
    WHERE DATE_ADD(CURDATE(), INTERVAL 1 DAY) = DATE(l.datefin);";

$stmt022 = $Connect->prepare($req022);

if ($stmt022->execute()) {
$result022 = $stmt022->get_result();

if ($result022->num_rows > 0) {
echo "<table>
    <thead>
        <tr>
            <th>ID Client</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Adresse</th>
            <th>Numéro de téléphone</th>
            <th>Email</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Prix total</th>
        </tr>
    </thead>
    <tbody>";

while ($row02 = $result022->fetch_assoc()) {
echo "<tr>
        <td>{$row02['idC']}</td>
        <td>{$row02['nom']}</td>
        <td>{$row02['prenom']}</td>
        <td>{$row02['adresse']}</td>
        <td>{$row02['numtel']}</td>
        <td>{$row02['email']}</td>
        <td>{$row02['datedebut']}</td>
        <td>{$row02['datefin']}</td>
        <td>{$row02['prixtotal']}</td>
    </tr>";
}

echo "</tbody></table>";
} else {
echo "No records found.";
}
} else {
echo "Error executing query: " . $stmt022->error;
}

$stmt022->close();

    ?>
    <form class="form" method="post" action="">
        <button type="submit" class="sendAllEmail" name="sendAllEmail">send all Email</button>
        </form>
</body>
</html>