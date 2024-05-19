<?php

class Client {
    private $id;
    private $nom;
    private $prenom;
    private $adresse;
    private $numeroTelephone;
    private $email;
    private mdp ;
    public function __construct($id, $nom, $prenom, $adresse, $numeroTelephone, $email) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->numeroTelephone = $numeroTelephone;
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($idc){
        $this->id=$idc ;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getNumeroTelephone() {
        return $this->numeroTelephone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function setNumeroTelephone($numero) {
        $this->numeroTelephone = $numero;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
}

?>


