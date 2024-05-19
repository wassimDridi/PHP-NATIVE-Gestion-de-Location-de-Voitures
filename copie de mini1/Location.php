<?php
class Locations {
    public $ID_Location;
    public $ID_Client;
    public $ID_Vehicule;
    public $DateDebut;
    public $DateFin;
    public $PrixTotal;
    public function __construct(){}

/*
    public function __construct($ID_Location, $ID_Client, $ID_Vehicule, $DateDebut, $DateFin, $PrixTotal) {
        $this->ID_Location = $ID_Location;
        $this->ID_Client = $ID_Client;
        $this->ID_Vehicule = $ID_Vehicule;
        $this->DateDebut = $DateDebut;
        $this->DateFin = $DateFin;
        $this->PrixTotal = $PrixTotal;
    }*/

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

