<?php
include_once "Joueur.php";
include_once "DataBase.php";
///Créer la liste des Joueurs
class Joueurs
{
    private $joueurs;
    ///Constructeur
    function __construct(){
        $this->joueurs = array();
    }
    ///Retourne une selection de joueur de conditions $cond
    private function selectJoueur(string $cond=""){
        $mysql = Database::getInstance();
        $data = $mysql->select("J.Nom, J.Prenom, J.Photo, J.NumLicense, J.DateNaissance,
        J.Taille, J.Poids, J.PostePref, J.Statut, J.commentaire","Joueur J",$cond." ORDER BY 4");
        $this->misAJourListeJoueurs($data);
    }
    ///Retourne les différents joueurs de la liste créée
    public function getJoueurs(){
        return $this->joueurs;
    }
    ///Affiche toutes les informations des joueurs
    public function afficherJoueurs()
    {
        foreach ($this->joueurs as $ligneValue) {
            echo "<tr>";
            $joueur = $ligneValue->listeInfo();
            $index=0;
            foreach ($joueur as $colValue) {
                if($index==2){
                    echo "<td><img class='imgJ' src=".'./'.$colValue." alt='Photo'></img></td>";
                } else if($colValue==NULL){
                    echo "<td>X</td>"; 
                } else {
                    echo "<td>", $colValue, "</td>"; 
                }
                $index++;
            }
            echo "<td><a href='./ModifJoueur.php?ID=".'where NumLicense ='. $ligneValue->getID()."'><img class='imgB' src='./img/modifier.png' alt='Modif'></a></td>";
            echo "<td><a href='./Suppression.php?TB=Joueur&ID=".'where NumLicense ='. $ligneValue->getID()."'><img class='imgB' src='./img/supprimer.png' alt='Supprimer'></a></td>";
            echo "</tr>";
        }
    }
    ///Met à jour la liste des joueurs $data
    private function misAJourListeJoueurs($data){
        $this->joueurs = array();
        foreach ($data as $ligne) {
            $this->joueurs[] = new Joueur($ligne['NumLicense'],$ligne['Nom'], $ligne['Prenom'],
            $ligne['Photo'], $ligne['DateNaissance'], $ligne['Taille'], $ligne['Poids'],
            $ligne['PostePref'],$ligne['Statut'],$ligne['commentaire']
            );
        }
    }
    ///Retourne la selection de tous les joueurs créés
    public function tousLesJoueurs()
    {
        $this->selectJoueur();
    }
    ///Retourne le Nombre de match Titulaire d'un joueur $id
    public function NbMTitulaire($id)
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT Count(*) FROM MatchJ M,Participer P,Joueur J 
            WHERE M.IDmatch=P.IDmatch AND J.NumLicense=P.Numlicense AND J.NumLicense=$id AND P.Titulaire='1';");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result; 
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Retourne le Nombre de match Remplaçant d'un joueur $id
    public function NbMRemplacant($id)
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT Count(*) FROM MatchJ M,Participer P,Joueur J 
            WHERE M.IDmatch=P.IDmatch AND J.NumLicense=P.Numlicense AND J.NumLicense=$id AND P.Titulaire='0';");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Retourne la Moyenne des Performances d'un joueur $id
    public function MoyPerformance($id)
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT avg(P.Performance) FROM MatchJ M,Participer P,Joueur J 
            WHERE M.IDmatch=P.IDmatch AND J.NumLicense=$id AND J.NumLicense=P.Numlicense;");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Retourne le Nombre de Victoire d'un joueur $id
    public function NbVicJ($id)
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT count(*) FROM MatchJ M,Participer P,Joueur J 
            WHERE M.IDmatch=P.IDmatch AND J.NumLicense=P.Numlicense AND J.NumLicense=$id AND M.Resultat='Gagné';");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result; 
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Retourne le Nombre de match joué d'un joueur $id
    public function NbMatch($id)
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT count(*) FROM MatchJ M,Participer P,Joueur J 
            WHERE M.IDmatch=P.IDmatch AND J.NumLicense=P.Numlicense AND J.NumLicense=$id AND M.Resultat!='';");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Affiche la liste des statistiques des joueurs
    public function afficherStats()
    {
        foreach ($this->joueurs as $ligneValue) {
            echo "<tr>";
            echo "<td>".$ligneValue->getNom()."</td>";
            echo "<td>".$ligneValue->getPrenom()."</td>";
            echo "<td>".$ligneValue->getPostepref()."</td>";
            echo "<td>".$ligneValue->getStatut()."</td>";
            echo "<td>".implode("",$this->NbMTitulaire($ligneValue->getID()))."</td>";
            echo "<td>".implode("",$this->NbMRemplacant($ligneValue->getID()))."</td>";
            echo "<td>";
            if(implode("",$this->MoyPerformance($ligneValue->getID()))==""){
                echo "0";
            } else {
                echo implode("",$this->MoyPerformance($ligneValue->getID()));
            }
            echo "</td>";
            echo "<td>".$this->cacul_pourcentage(implode("",$this->NbVicJ($ligneValue->getID())),
            implode("",$this->NbMatch($ligneValue->getID())))."%</td>";
            echo "</tr>";
        }
    }
    ///Retourne la selection de joueur participant au match $id
    public function JoueurMatch(string $id,string $cond=""){
        $mysql = Database::getInstance();
        $data = $mysql->select("J.Nom, J.Prenom, J.Photo, J.NumLicense, J.DateNaissance,
        J.Taille, J.Poids, J.PostePref, J.Statut, J.commentaire,P.Performance,P.Titulaire","Joueur J, Participer P,MatchJ M ",
        "WHERE M.IDmatch=P.IDmatch AND J.NumLicense=P.NumLicense AND M.IDmatch=".$id."".$cond." ORDER BY 1");
        $this->misAJourListeJoueurs($data);
    }
    ///Retourne la Performance d'un joueur $idj pour un match $idm
    public function getPerformance(string $idm,string $idj){
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT P.Performance FROM MatchJ M,Participer P,Joueur J 
            WHERE M.IDmatch=P.IDmatch AND J.NumLicense=P.NumLicense AND M.IDmatch='$idm' AND J.NumLicense='$idj'");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result; 
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Mettre à jour la Performance $p d'un joueur $idj pour un match $idm
    public function updatePerf(string $idm,string $idj,string $p){
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("UPDATE Participer P SET P.Performance='$p'
            WHERE P.IDmatch='$idm' AND P.NumLicense='$idj'");
            $stmt->execute();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Transforme des données en pourcentage
    public function cacul_pourcentage($nombre,$total)
    { 
      if($total==0){
        $resultat = ($nombre/1) * 100;
      } else {
        $resultat = ($nombre/$total) * 100;
      }
      return round($resultat); // Arrondi la valeur
    }
    ///Retourne la selection des joueurs qui ne participent pas au match $id
    public function JoueurNotParticiper(string $id){
        $mysql = Database::getInstance();
        $data = $mysql->select("J.Photo,J.Nom, J.Prenom, J.NumLicense,J.Taille,J.Poids,J.PostePref,J.commentaire","Joueur J",
        "WHERE J.Statut='Actif' AND J.NumLicense NOT IN( 
        SELECT J.NumLicense FROM Joueur J,MatchJ M, Participer P 
        WHERE J.NumLicense=P.NumLicense AND M.IDmatch=P.IDmatch AND M.IDmatch='$id') ORDER BY 1");
        $this->misAJourListeJoueurs($data);
    }
    ///Retourne la colonne Titulaire d'un joueur $idj pour un match $idm
    public function getTitulaire(string $idm,string $idj){
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT P.Titulaire FROM MatchJ M,Participer P,Joueur J 
            WHERE M.IDmatch=P.IDmatch AND J.NumLicense=P.NumLicense AND M.IDmatch='$idm' AND J.NumLicense='$idj'");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;  
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Met à jour la colonne Titulaire d'un joueur $idj pour un match $idm
    public function updateTit(string $idm,string $idj,string $p){
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("UPDATE Participer P SET P.Titulaire='$p'
            WHERE P.IDmatch='$idm' AND P.NumLicense='$idj'");
            $stmt->execute();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Ajoute un joueur $num pour un match $id avec les infos de Participer
    public function ParticiperJM(string $id,string $num,string $perf,string $titulaire)
    {
        Database::getInstance()->insert("Participer(IDmatch,NumLicense,Performance,Titulaire) ",
         4, array($id,$num,$perf,$titulaire));
    }
    ///Supprime un joueur $num pour un match $id avec les infos de Participer
    public function SupParticiperJM($id,$idj)
    {
        Database::getInstance()->delete($id,$idj);
    }
    ///Affiche le nb de participant dun match
    public function NbParticipant($id)
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT count(*) from MatchJ m, Joueur j,Participer p where m.IDmatch=p.IDmatch and
             j.NumLicense=p.NumLicense and p.Titulaire='1' and m.IDmatch='$id'");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data['count(*)'];
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    ///Retourne le nombre de joueurs total
    public function NbjoueursTotal()
    {
        try {
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Joueur;");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;   
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>