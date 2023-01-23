<?php
session_start();
if (!isset($_SESSION['nom'])){
    header("Location: index.php");
}
?>
<?php
///Quand le bouton envoyer est cliqué
if (isset($_POST['Envoyer'])) {
    if (isset($_POST['dateM']) && isset($_POST['heureM']) && isset($_POST['equipeA'])
    && isset($_POST['lieu'])) {
        header('Location: ListeMatch.php');
    }
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
    <main class="main">
        <div class="boxajout">
            <div class="titre">
                <h1> Ajout d'un match </h1>
            </div>
            <?php    
                include_once './classe/MatchJ.php';
                ///Quand le bouton envoyer est cliqué
                if (isset($_POST['Envoyer'])) {
                    if (isset($_POST['dateM']) && isset($_POST['heureM']) && isset($_POST['equipeA'])
                    && isset($_POST['lieu'])) {
                        $dateM=$_POST['dateM'];
                        $heureM=$_POST['heureM'];
                        $equipeA=$_POST['equipeA']; 
                        $lieu=$_POST['lieu'];
                        if(empty($_POST['lieuM'])){
                            $lieuM="";
                        } else {
                            $lieuM=$_POST['lieuM'];
                        }
                        if(empty($_POST['ville'])){
                            $ville="";
                        } else {
                            $ville=$_POST['ville'];
                        }
                        try {
                            $MatchJ= new MatchJ($dateM,$heureM,$equipeA,$lieu,NULL,NULL,$lieuM,$ville);   
                            $MatchJ -> creerMatchJ($dateM,$heureM,$equipeA,$lieu,$lieuM,$ville);
                        } catch (Exception $ex) {
                            echo $ex->getMessage();
                        }
                    }
	            }
            ?> 
            <div class="ajout">
                <!--Formulaire de création--> 
                <form action="#" method="POST">
                    <div class="grid">
                        <div id="FLMd1">
                            <label for="dateM">Date</label>
                            <input type="date" id="dateM" name="dateM" placeholder="Entrez la date" required>
                        </div>
                        <div id="FLMd2">
                            <label for="heureM">Heure</label>
                            <input type="time" id="heureM" name="heureM" placeholder="Entrez l'heure" required>
                        </div>
                        <div id="FLMd3">
                            <label for="equipeA">Nom équipe adverse</label>
                            <input type="text" id="equipeA" name="equipeA" placeholder="Entrez le nom de l'équipe" required>
                        </div>
                        <div id="FLMd4">
                            <label for="lieu">Lieu : </label>
                            <select name="lieu" id="lieu" placeholder="Entrez le lieu" required>
                                <option value="Domicile">Domicile</option>
                                <option value="Exterieur">Exterieur</option>
                            </select>
                        </div>
                        <div id="FLMd5">
                            <label for="ville">Ville</label>
                            <input type="text" id="ville" name="ville" placeholder="Entrez la ville">
                        </div>
                        <div id="FLMd6">
                            <label for="lieuM">Adresse</label>
                            <input type="text" id="lieuM" name="lieuM" placeholder="Entrez l'adresse">
                        </div>
                        <!--Liste des boutons-->
                        <input type="button" class="button1" id="FLMb1" value="Annuler" onclick="window.location.href ='./ListeMatch.php';">
                        <input type="reset" class="button1" id="FLMb2" value="Vider">
                        <input type="submit" class="button1" id="FLmb3" name="Envoyer" value="Envoyer">
                    </div>
                </form>
            </div>
        </div>
    </main>
 </body>
</html>