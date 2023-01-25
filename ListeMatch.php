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
                <a href="./ListeMatch.php" class="menuA">Liste des matchs</a>
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
        include './classe/Matchs.php';
        $listeMatchs = new Matchs();
        ///Selection de tous les matchs
        $listeMatchs->tousLesMatchs();
    ?>
    <main class="listematch">
        <div class="grid">
            <div id="LMd1">
            <label for="nb">Nombre de match Total</label>
            <input type="text" id="nb" name="nb" value="<?=implode("",$listeMatchs->NbmatchTotal());?>" readonly>
            </div>
            <div class="titre" id="LMt1">
                <h1> Liste des Matchs </h1>
            </div>
            <div class="paragraphe" id="LMl1">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Nom Adversaire</th>
                            <th>Lieu</th>
                            <th>Ville</th>
                            <th>Adresse</th>
                            <th>Resultat</th>
                            <th>Modifier</th>
                            <th>Feuille Match</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            ///Afficher tous les matchs
                            $listeMatchs->afficherMatchs();
                        ?>
                    </tbody>
                </table>
            <div class="titre" id="LMt2">
                <img class='imgA' src='./img/modifierrouge.png' alt='ModifierInterdit'>Résultat Match Impossible
                <img class='imgA' src='./img/modifierorange.png' alt='ModifierAFaire'> Résultat Modifiable
                <img class='imgA' src='./img/modifierN.png' alt='ModifierFini'> Résultat Noté
                <img class='imgA' src='./img/FeuilleMorange.png' alt='FeuilleMAFaire'> Feuille Match à faire
                <img class='imgA'src='./img/FeuilleMvert.png' alt='FeuilleMFait'> Feuille Match Notée
                <img class='imgA' src='./img/FeuilleM.png' alt='FeuilleMFini'> Feuille Match Passée
            </div>
            </div>
            <a href="./AjoutMatch.php" class="button1" id="LMb1">Ajouter un Match</a> 
        </div>
    </main>
 </body>
</html>