<?php
include_once "DataBase.php";
///Création de la connexion serveur
class Connexion {
    public function __construct() {
    }
    ///se connecter
    public function connecter($id,$mdp){
        $hash=password_hash('$iutinfo', PASSWORD_DEFAULT);
        if(password_verify($mdp,$hash)==1 && $id=='administrateur'){
          return 1;  
        } else {
            $_SESSION['nom']='';
            if(isset($_SESSION['nom'])){
                session_destroy();
            }
          return 0;
        }
    }
}
?>