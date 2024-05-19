<?php


class Vehicule {
    private $id;
    private $marque;
    private $modele;
    private $annee;
    private $prixParJour;
    private $dispo;

    public function __construct($id, $marque, $modele, $annee, $prixParJour ) {
        $this->id = $id;
        $this->marque = $marque;
        $this->modele = $modele;
        $this->annee = $annee;
        $this->prixParJour = $prixParJour;
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
}


?>


