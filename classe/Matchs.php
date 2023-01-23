<?php
include_once "MatchJ.php";
include_once "DataBase.php";
///Créer la liste des matchs
class Matchs
{
    private $matchs;
    ///Constructeur
    function __construct(){
        $this->matchs = array();
    }
    ///Retourne la selection de matchs avec conditions $cond
    private function selectMatchJ(string $cond=""){
        $mysql = Database::getInstance();
        $data = $mysql->select("M.DateM, M.HeureM, M.NomEquipeAdv, M.Lieu, M.Resultat,
        M.IDmatch, M.Adresse, M.Ville","MatchJ M",$cond."ORDER BY 1,2");
        $this->misAJourListeMatchs($data);
    }
    ///Affiche les infos des matchs
    public function afficherMatchs()
    {
        foreach ($this->matchs as $ligneValue) {
            echo "<tr>";
            $matchj = $ligneValue->listeInfo();
            $index=0;
            foreach ($matchj as $colValue) {
                if($colValue==NULL){
                    echo "<td>X</td>";
                } else {
                    echo "<td>", $colValue, "</td>";
                }
            }
            echo "<td><a href='./ModifMatch.php?ID=". $ligneValue->getID()."'><img class='imgB' src='./img/modifier.png' alt='Supprimer'></a></td>";
            echo "<td><a href='./FeuilleMatch.php?ID=". $ligneValue->getID()."'><img class='imgB' src='./img/FeuilleM.png' alt='FeuilleM'></a></td>";
            echo "<td><a href='./Suppression.php?TB=MatchJ&ID=".'where IDmatch='. $ligneValue->getID()."'><img class='imgB' src='./img/supprimer.png' alt='Modif'></a></td>";
            echo "</tr>";
            $index++;
        }
    }
    ///Met à jour la liste des matchs $data
    private function misAJourListeMatchs($data){
        $this->matchs = array();
        foreach ($data as $ligne) {
            $this->matchs[] = new MatchJ($ligne['DateM'],$ligne['HeureM'], $ligne['NomEquipeAdv'],
            $ligne['Lieu'], $ligne['Resultat'], $ligne['IDmatch'], $ligne['Adresse'],$ligne['Ville']
            );
        }
    }
    ///Retourne la selection de tous les matchs
    public function tousLesMatchs()
    {
        $this->selectMatchJ();
    }
    ///Retourne le nombre de match gagné
    public function NbmatchGagné()
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM MatchJ WHERE Resultat='Gagné';");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;  
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Retourne le nombre de match perdu
    public function NbmatchPerdu()
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM MatchJ WHERE Resultat='Perdu';");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Retourne le nombre de match nul
    public function NbmatchNul()
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM MatchJ WHERE Resultat='Nul';");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data; 
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Retourne le nombre de match total
    public function NbmatchTotal()
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM MatchJ;");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;  
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Transforme des valeurs en pourcentage
    public function cacul_pourcentage($nombre,$total)
    { 
        if($total==0){
            $resultat = ($nombre/1) * 100;
        } else {
            $resultat = ($nombre/$total) * 100;
        }
        return round($resultat); // Arrondi la valeur
    } 
    ///Retourne le nombre de match joué
    public function NbmatchJouer()
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM MatchJ WHERE Resultat!='';");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;  
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>