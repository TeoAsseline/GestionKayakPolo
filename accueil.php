<?php
session_start();
if (!isset($_SESSION['nom'])){
    header("Location: index.php");
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
        <!--Lien-->
        <div class="DivHnav">
            <nav class="listH">
                <a href="./accueil.php">Accueil</a>
                <a href="./ListeJoueur.php">Liste des joueurs</a>
                <a href="./ListeMatch.php">Liste des matchs</a>
                <a href="./Statistiques.php">Statistiques</a>
            </nav>
        </div>
        <!--Deconnection-->
        <div class="DivHright">
            <div class="deconnecter">
                <a class="button64" name="Deconnexion" href='Logout.php'>Deconnexion</a>
            </div>
        </div>
    </div>       
 </header>
    <main class="accueil">
        <div class="grid">
            <div class="titre" id="At1">
                <h1> Gestionnaire d'une équipe de KayakPolo </h1>
            </div>
            <a href="./AjoutJoueur.php" class="button1" id="Aa1">Ajouter un Joueur</a>
            <a href="./AjoutMatch.php" class="button1" id="Aa2">Ajouter un Match</a> 
        </div>
    </main>
 </body>
</html>