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
    <?php 
        include './classe/Joueurs.php';
        $listeJoueurs = new Joueurs();
        ///Selection de tous les joueurs
        $listeJoueurs->tousLesJoueurs();
    ?>
    <main class="listejoueur">
        <div class="grid">
            <div id="LJd1">
            <label for="nb">Nombre de joueurs Total</label>
            <input type="text" id="nb" name="nb" value="<?=implode("",$listeJoueurs->NbjoueursTotal());?>" readonly>
            </div>
            <div class="titre" id="LJt1">
                <h1> Liste des Joueurs </h1>
            </div>
            <div class="paragraphe" id="LJl1">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Photo</th>
                            <th>NumLicense</th>
                            <th>Date de Naissance</th>
                            <th>Taille(en cm)</th>
                            <th>Poids(en kg)</th>
                            <th>Poste Préféré</th>
                            <th>Statut</th>
                            <th>Commentaire</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        ///Afficher les infos des joueurs
                        $listeJoueurs->afficherJoueurs();
                        ?>
                    </tbody>
                </table>
            </div>
            <a href="./AjoutJoueur.php" class="button1" id="LJb1">Ajouter un Joueur</a> 
        </div>
    </main>
 </body>
</html>