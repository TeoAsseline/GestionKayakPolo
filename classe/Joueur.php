<?php
include_once 'DataBase.php';
///Création d'un joueur
class Joueur
{
    private $numlicence;
    private $nom;
    private $prenom;
    private $photo;
    private $dateN;
    private $taille;
    private $poids;
    private $postpref;
    private $statut;
    private $commentaire;
    ///Constructeur
    public function __construct($numlicence,$nom,$prenom,$photo,$dateN,$taille,$poids,$postepref,$statut,$commentaire){
        $this->numlicence =$numlicence;
        $this->nom =$nom;
        $this->prenom =$prenom;
        $this->photo =$photo;
        $this->dateN =$dateN;
        $this->taille =$taille;
        $this->poids =$poids;
        $this->postepref =$postepref;
        $this->statut =$statut;
        $this->commentaire =$commentaire;
    }
    ///Retourne le Nom du Joueur
    public function getNom(){
        return $this->nom;
    }
    ///Retourne le Prenom du Joueur
    public function getPrenom(){
        return $this->prenom;
    }
    ///Retourne le commentaire du Joueur
    public function getCommentaire(){
        return $this->commentaire;
    }
    ///Retourne la Licence du Joueur
    public function getID(){
        return $this->numlicence;
    }
    ///Retourne la Photo du Joueur
    public function getPhoto(){
        return $this->photo;
    }
    ///Retourne la Date de naissance du Joueur
    public function getDateN(){
        return $this->dateN;
    }
    ///Retourne la Taille du Joueur
    public function getTaille(){
        return $this->taille;
    }
    ///Retourne le Poids du Joueur
    public function getPoids(){
        return $this->poids;
    }
    ///Retourne le Poste Préféré du Joueur
    public function getPostepref(){
        return $this->postepref;
    }
    ///Retourne le Statut du Joueur
    public function getStatut(){
        return $this->statut;
    }
    ///Retourne la liste des Infos du Joueur
    public function listeInfo(): array
    {
        return array($this->nom,$this->prenom,$this->photo,$this->numlicence,$this->dateN,$this->taille,$this->poids,$this->postepref,$this->statut,$this->commentaire);
    }
    ///Créer un Joueur dans la BDD
    public function creerJoueur(string $nom, string $prenom, string $photo, string $numlicenc, string $dateN, string $taille,string $poids,string $postepref,string $statut,string $commentaire)
    {
        Database::getInstance()->insert("Joueur (Nom,Prenom,Photo,NumLicense,DateNaissance,Taille,Poids,PostePref,Statut,commentaire)",10
         , array($nom,$prenom,"photo/".$photo,$numlicenc,$dateN,$taille,$poids,$postepref,$statut,$commentaire));
    }
    ///Mettre à jour les Infos du Joueur dans la BDD
    public function updateJoueur(string $nom, string $prenom, string $photo, string $numlicence, string $dateN, string $taille,string $poids,string $postepref,string $statut,string $commentaire)
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("UPDATE Joueur SET Nom='$nom',Prenom='$prenom',Photo='$photo',NumLicense='$numlicence',DateNaissance='$dateN',Taille='$taille',Poids='$poids',PostePref='$postepref',Statut='$statut',commentaire='$commentaire' WHERE NumLicense='$numlicence';");
            $res = $stmt->execute();  
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>