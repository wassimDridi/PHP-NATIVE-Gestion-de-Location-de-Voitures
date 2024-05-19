<?php
class Client {
    private $id;
    private $nom;
    private $prenom;
    private $adresse;
    private $numeroTelephone;
    private $email;
    private $mdp ;
    public function __construct($nom, $prenom, $adresse, $numeroTelephone, $email, $mdp ,$Connect) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->numeroTelephone = $numeroTelephone;
        $this->email = $email;
        $this->mdp = $mdp;
       
        $sql = "INSERT INTO clients (nom, prenom, adresse, numtel, email ,mdp) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $Connect->prepare($sql);
        $stmt->bind_param("ssssss",$this->nom, $this->prenom, $this->adresse, $this->numeroTelephone, $this->email,$this->mdp);
        if ($stmt->execute()) {
            echo "<script>alert('il est ajouter avec succès.')</script>";
            header("Location: index.php");
            exit();
        
        } else {
            $ch="Error: " . $stmt->error;
            echo "<script>alert(.$ch.)</script>";
        }
        //header('location:espaceClient.php');
        $stmt->close();
        $Connect->close();
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
    public function getMdp() {
        return $this->mdp;
    }

    public function setMdp($mdp) {
        $this->mdp = $mdp;
    }
}

?>


