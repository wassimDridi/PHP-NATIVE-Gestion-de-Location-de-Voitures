<?php
include 'DB.php';


class Vehicule {
    private $id;
    private $marque;
    private $modele;
    private $annee;
    private $prixParJour;
    private $dispo;
    private $img;

    public function __construct($marque, $modele, $annee, $prixParJour ,$dispo ,$img ) {
        $this->marque = $marque;
        $this->modele = $modele;
        $this->annee = $annee;
        $this->prixParJour = $prixParJour;
        $this->dispo = $dispo ;
        $this->img = $img ;
        $bd = new DB();
        $Connect = $bd->connect();
        // $Connect fih connection mysqli class DB
        if ($Connect->connect_error) {
            die("Connection error: " . $Connect->connect_error);
        }
        $sql = "INSERT INTO vehicules (marque, modele, annee, prixparjour, disponible, img) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $Connect->prepare($sql);
        $stmt->bind_param("ssssss", $this->marque, $this->modele, $this->annee, $this->prixParJour, $this->dispo, $this->img);

        if ($stmt->execute()) {
            echo "<script>alert('vehicule est ajouter avec succès.')</script>";
            header("Location: espaceAdmin.php");

        } else {
            $ch="Error: " . $stmt->error;
            echo "<script>alert(.$ch.)</script>";
        }

        $stmt->close();
        $Connect->close();
    }

    public function getId() {
        return $this->id;
    }

    public function getMarque() {
        return $this->marque;
    }

    public function getModele() {
        return $this->modele;
    }

    public function getAnnee() {
        return $this->annee;
    }

    public function getPrixParJour() {
        return $this->prixParJour;
    }

    public function setMarque($marque) {
        $this->marque = $marque;
    }

    public function setModele($modele) {
        $this->modele = $modele;
    }

    public function setAnnee($annee) {
        $this->annee = $annee;
    }

    public function setPrixParJour($prix) {
        $this->prixParJour = $prix;
    }
    public function getDispo() {
        return $this->dispo;
    }

    public function setDispo($dispo) {
        $this->dispo = $dispo;
    }

    public function getImg() {
        return $this->img;
    }

    public function setImg($img) {
        $this->img = $img;
    }
}


?>