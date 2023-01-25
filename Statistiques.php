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
 <body class="stat">
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
                <a href="./Statistiques.php" class="menuA">Statistiques</a>
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
        <div>
            <div class="titre" id="STt1">
                <h1> Statistiques </h1>
            </div>
            <?php 
                include './classe/Matchs.php';
                $listeJoueurs = new Matchs();
                ///Selection de tous les matchs
                $listeJoueurs -> tousLesMatchs();
            ?>
            <div class="paragraphe" id="STd1">
                <div class="grid" id="Stat">
                    <div class="titre">
                        <label for="nb">Nombre de match Joué</label>
                        <input type="text" id="nb" name="nb" value="<?=
                        implode("",$listeJoueurs->NbmatchJouer());?>" readonly>
                    </div>
                    <div class="titre">
                        <label for="nbg">Pourcentage de match Gagné</label>
                        <input type="text" id="nbg" name="nbg" value="<?=
                        $listeJoueurs->cacul_pourcentage(implode("",$listeJoueurs->NbmatchGagné()),implode("",$listeJoueurs->NbmatchJouer()));?>%" readonly>
                    </div>
                    <div class="titre">
                        <label for="nbp">Pourcentage de match Perdu</label>
                        <input type="text" id="nbp" name="nbp" value="<?=
                        $listeJoueurs->cacul_pourcentage(implode("",$listeJoueurs->NbmatchPerdu()),implode("",$listeJoueurs->NbmatchJouer()));?>%" readonly>
                    </div>
                    <div class="titre">
                        <label for="nbn">Pourcentage de match Nul</label>
                        <input type="text" id="nbn" name="nbn" value="<?=
                        $listeJoueurs->cacul_pourcentage(implode("",$listeJoueurs->NbmatchNul()),implode("",$listeJoueurs->NbmatchJouer()));?>%" readonly>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Poste Préféré</th>
                            <th>Statut</th>
                            <th>Match Titulaire</th>
                            <th>Match Remplaçant</th>
                            <th>Moyenne évaluation</th>
                            <th>Match gagné</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $listeJoueurs = new Joueurs();
                            ///Selection de tous les joueurs
                            $listeJoueurs->tousLesJoueurs();
                            ///Afficher les statistiques
                            $listeJoueurs->afficherStats();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
 </body>
</html>