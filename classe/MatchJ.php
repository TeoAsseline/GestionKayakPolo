<?php
include_once 'DataBase.php';
///Créer un match
class MatchJ
{
    private $datem;
    private $heurem;
    private $nomadv;
    private $lieu;
    private $resultat;
    private $id;
    private $adresse;
    private $ville;
    ///Constructeur
    public function __construct($datem,$heurem,$nomadv,$lieu,$resultat,$id,$adresse,$ville){
        $this->datem =$datem;
        $this->heurem =$heurem;
        $this->nomadv =$nomadv;
        $this->lieu =$lieu;
        $this->resultat =$resultat;
        $this->id =$id;
        $this->adresse =$adresse;
        $this->ville =$ville;
    }
    ///Retourne la date du match
    public function getDate(){
        return $this->datem;
    }
    ///Retourne la ville du match
    public function getVille(){
        return $this->ville;
    }
    ///Retourne l'heure du match
    public function getHeure(){
        return $this->heurem;
    }
    ///Retourne l'id du match
    public function getID(){
        return $this->id;
    }
    ///Retourne le nom de l'éauipe adverse du match
    public function getNomadv(){
        return $this->nomadv;
    }
    ///Retourne le lieu du match
    public function getLieu(){
        return $this->lieu;
    }
    ///Retourne le resultat du match
    public function getResultat(){
        return $this->resultat;
    }
    ///Retourne l'adresse du match
    public function getAdresse(){
        return $this->adresse;
    }
    ///Retourne la liste des infos du match
    public function listeInfo(): array
    {
        return array($this->datem,$this->heurem,$this->nomadv,$this->lieu,$this->ville,$this->adresse,$this->resultat);
    }
    ///Creer un match dans la BDD
    public function creerMatchJ(string $dateM, string $heureM, string $equipeA, string $lieu, string $adresse,string $ville)
    {
        Database::getInstance()->insert("MatchJ (DateM,HeureM,NomEquipeAdv,Lieu,Resultat,IDmatch,Adresse,Ville)", 8
         , array($dateM,$heureM,$equipeA,$lieu,"","",$adresse,$ville));
    }
    ///Mettre à jour les infos d'un match dans la BDD
    public function updateMatch(string $dateM, string $heureM, string $equipeA, string $lieu, string $resultat, string $adresse,string $ville,string $id)
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("UPDATE MatchJ SET DateM='$dateM',HeureM='$heureM',NomEquipeAdv='$equipeA',Lieu='$lieu',Resultat='$resultat',Adresse='$adresse',Ville='$ville' WHERE IDmatch='$id';");
            $res = $stmt->execute();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>