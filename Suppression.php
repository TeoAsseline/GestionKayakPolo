<?php
session_start();
if (!isset($_SESSION['nom'])){
    header("Location: index.php");
}
?>
<?php   
    include_once './classe/DataBase.php';
    $table=$_GET["TB"];
    $id=$_GET["ID"];
    if (isset($_POST['Valider'])) {  
        if($table=='MatchJ'){
        ?>
        <script type='text/javascript'>document.location.replace('ListeMatch.php');</script>";
        <?php
        }else{
        ?>
        <script type='text/javascript'>document.location.replace('ListeJoueur.php');</script>";
        <?php
        }
    }
    try {
        $pdo = Database::getInstance()->getPDO();
        ///Si c'est un match on réalise
        if($table=='MatchJ'){
            $sqlP = $pdo->prepare("DELETE FROM Participer $id");
            $sqlM = $pdo->prepare("DELETE FROM $table $id");
        } else {
            $sqlJ = $pdo->prepare("DELETE FROM Participer $id");
            $stmt = $pdo->prepare("DELETE FROM $table $id");
            $sqlPhoto = $pdo->prepare("SELECT Photo FROM Joueur $id");
            $sqlPhoto->execute();
            $result = $sqlPhoto->fetch(PDO::FETCH_ASSOC);
        }
        ///Suppression des donnees
        if (isset($_POST['Valider'])) {  
            if($table=='MatchJ'){
                $sqlP->execute();
                $sqlM->execute();
            } else {
                $sqlJ->execute();
                $stmt->execute();
                $fichier = $result['Photo'];
                if(file_exists($fichier)){unlink($fichier);};
            }
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
?> 
<html>
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Monstyle.css" />
 </head>
 <body>
 <!--Menu de navigation-->
 <header>
        <div class="Menu">
            <!--Logo-->
            <div class="DivHdebut">
            </div>
            <!--Liste des liens-->
            <div class="DivHnav">
            <nav class="listH">
                <a href="./accueil.php">Accueil</a>
                <a href="./ListeJoueur.php">Liste des joueurs</a>
                <a href="./ListeMatch.php">Liste des matchs</a>
                <a href="./Statistiques.php">Statistiques</a>
            </nav>
            </div>
            <!--Deconnexion-->
            <div class="DivHright">
                <div class="deconnecter">
                <a class="button64" name="Deconnexion" href='Logout.php'>Deconnexion</a>
                </div>
            </div>
        </div>       
    </header>
    <main class="supression">
        <div class="grid">
            <div class="titre" id="St1">
                <h1> Supression de données </h1>
            </div>
            <div class="titre" id="St2">
            <form action="#" method="POST" id="St3">
                <label> Êtes-vous sûr de vouloir supprimer ? </label>
                <input type="submit" class="button1" id="Stb1" name="Valider" value="VALIDER">
                <input type="button" class="button1" id="Stb2" value="ANNULER" onclick="window.location.href ='javascript:history.go(-1)';">
            </form>
            </div>
        </div>
    </main>
 </body>
</html>