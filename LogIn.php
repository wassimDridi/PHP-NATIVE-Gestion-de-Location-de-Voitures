<?php
class LogIn {
    private $email;
    private $motDePasse;

    public function __construct($email, $motDePasse ,$Connecte) {
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        if($motDePasse == "adminadmin"){
            header("Location: espaceAdmin.php");
        }else{
            
        session_start();
        
        $sql = "SELECT idC, email, mdp FROM clients WHERE email = ? and mdp = ?";
        $stmt = $Connecte->prepare($sql);

        $stmt->bind_param("ss", $email,$motDePasse);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user > 0) {
            // Login successful
            $_SESSION["idclient"] = $user["idC"];
            echo "<script>alert('log in  avec succès.')</script>";
            $_SESSION["rowsF"] = [];
            header("Location: indexi.php");
            exit();
        } else {
            // Login failed
            echo "<script>alert('log in reffuser.')</script>";
        }

        $stmt->close();
        $Connecte->close();
        }


    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getMotDePasse() {
        return $this->motDePasse;
    }

    public function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
    }
}

?>