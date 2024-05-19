<?php
class Location {
    public $ID_Location;
    public $ID_Client;
    public $ID_Vehicule;
    public $DateDebut;
    public $DateFin;
    public $PrixTotal;
    public function __construct($ID_Client, $ID_Vehicule, $DateDebut, $DateFin, $PrixTotal ,$DB) {
        $this->ID_Client = $ID_Client;
        $this->ID_Vehicule = $ID_Vehicule;
        $this->DateDebut = $DateDebut;
        $this->DateFin = $DateFin;
        $this->PrixTotal = $PrixTotal;
        $bd = $DB;
        $Connect = $bd->connect();
        // $Connect fih connection mysqli class DB
        if ($Connect->connect_error) {
            die("Connection error: " . $Connect->connect_error);
        }
        $sql = "INSERT INTO location (idC, idV, datedebut, datefin, prixtotal) VALUES (?, ?, ?, ?, ?)";
        $stmt = $Connect->prepare($sql);
        $stmt->bind_param("iisss", $this->ID_Client, $this->ID_Vehicule, $this->DateDebut, $this->DateFin, $this->PrixTotal);

        if ($stmt->execute()) {
            echo "<script>alert('Operation location avec succès.')</script>";

        } else {
            $ch="Error: " . $stmt->error;
            echo "<script>alert(.$ch.)</script>";
        }

        $stmt->close();

        $sql = "UPDATE vehicules SET disponible=? WHERE idV=?";
        $stmt1 = $Connect->prepare($sql);
        $d = false ;
        $stmt1->bind_param("ii", $d ,$ID_Vehicule);    
        if ($stmt1->execute()) {
            echo "<script>alert('modidication avec succès.')</script>";
        } else {
            $ch="Error: " . $stmt1->error;
            echo "<script>alert(.$ch.)</script>";
        }
        //
        $stmt1->close();
        
        $Connect->close();
        header("Location: indexi.php");

    }

    public function getID_Location() {
        return $this->ID_Location;
    }
    public function setID_Location($id){
        $this->ID_Location =$id ;
    }

    public function getID_Client() {
        return $this->ID_Client;
    }

    public function setID_Client($ID_Client) {
        $this->ID_Client = $ID_Client;
    }

    public function getID_Vehicule() {
        return $this->ID_Vehicule;
    }

    public function setID_Vehicule($ID_Vehicule) {
        $this->ID_Vehicule = $ID_Vehicule;
    }

    public function getDateDebut() {
        return $this->DateDebut;
    }

    public function setDateDebut($DateDebut) {
        $this->DateDebut = $DateDebut;
    }

    public function getDateFin() {
        return $this->DateFin;
    }

    public function setDateFin($DateFin) {
        $this->DateFin = $DateFin;
    }

    public function getPrixTotal() {
        return $this->PrixTotal;
    }

    public function setPrixTotal($PrixTotal) {
        $this->PrixTotal = $PrixTotal;
    }


}

?>

