<?php
///Création de la connexion serveur
class Database {
    private static $instance = null;
    ///Connexion au serveur Mysql
    private $server = 'localhost';
    private $login = 'root';
    private $mdp = '';
    private $db = 'kayakpolo';
    private $linkpdo;
    ///Construction du lien
    private function __construct() {
        try {
            $this->linkpdo = new PDO("mysql:host=$this->server;dbname=$this->db", $this->login, $this->mdp);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    ///Recupération de l'instance
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    /// Récupération du lien
    public function getPDO(){
        return $this->linkpdo;
    }
    /// Commande SELECT toutes les lignes
    public function select(string $cols, string $tables, string $conditions=""){
        try {
            $pdo = $this->getPDO();
            $stmt = $pdo->prepare("select ".$cols." from ".$tables." ".$conditions);
            $stmt->execute(); 
            $data = $stmt->fetchAll();
            return $data; 
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    /// Commande SELECT récupération d'un tableau avec les colonnes
    public function selectL(string $cols, string $tables, string $conditions=""){
        try {
            $pdo = $this->getPDO();
            $stmt = $pdo->prepare("select ".$cols." from ".$tables." ".$conditions);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    /// Commande INSERT $table, $num le nb de valeur, $values les différentes valeurs
    public function insert(string $table, int $num, array $values){
        try {
            $pdo = $this->getPDO();
            $stmt = $pdo->prepare("INSERT INTO ".$table." VALUES (".str_repeat("?, ", $num-1).'?)');
            $res = $stmt->execute($values);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    /// Commande DELETE pour Participer $id du match et $idj du joueur
    public function delete(string $id,string $idj){
        try {
            $pdo = $this->getPDO();
            $stmt = $pdo->prepare("DELETE FROM Participer WHERE IDmatch='$id'AND NumLicense='$idj'");
            $res = $stmt->execute();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>