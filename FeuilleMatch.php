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
                <?php
                    include './classe/Joueurs.php';
                    include_once './classe/MatchJ.php';
                    include_once './classe/DataBase.php';
                    error_reporting(E_ERROR | E_PARSE);
                    ///Recuperation de l'id match
                    $IDM=$_GET["ID"];
                    try {
                        $match = Database::getInstance()->selectL("M.DateM","MatchJ M","where IDmatch=".$_GET["ID"]);
                        $dateM=$match['DateM'];
                    } catch (Exception $ex) {
                        echo $ex->getMessage();
                    }
                    $listeJoueurs = new Joueurs();
                    $NBJM=$listeJoueurs->NbParticipant($IDM);
                    if($NBJM<5){
                        echo '<a href="">Accueil</a>';
                        echo '<a href="">Liste des joueurs</a>';
                        echo '<a href="">Liste des matchs</a>';
                        echo '<a href="">Statistiques</a>';
                    }else{
                        echo '<a href="./accueil.php">Accueil</a>';
                        echo '<a href="./ListeJoueur.php">Liste des joueurs</a>';
                        echo '<a href="./ListeMatch.php">Liste des matchs</a>';
                        echo '<a href="./Statistiques.php">Statistiques</a>';
                    }
                ?>
            </nav>
            </div>
            <!--Deconnexion-->
            <div class="DivHright">
                <div class="deconnecter">
                    <?php
                        if($NBJM<5){
                            echo "<a class='button64' name='Deconnexion' href=''>Deconnexion</a>";
                        }else{
                            echo "<a class='button64' name='Deconnexion' href='Logout.php'>Deconnexion</a>";
                        }
                    ?>
                </div>
            </div>
        </div>       
    </header>
    
    <main class="feuilledematch">
        <!--Formulaire de feuille de match-->
        <form name="myForm" action="#" method="post">
        <div class="grid">
            <div class="titre" id="FMt1">
                <h1> Feuille de match </h1>
            </div>
            <div class="titre" id="FMl1">
                <?php
                    $listeJoueurs->JoueurNotParticiper($IDM);
                    $pdo = Database::getInstance()->getPDO();
                    $sqlP = $pdo->prepare("DELETE FROM Participer WHERE Participer.IDmatch=$IDM");
                    if(isset($_POST['Valider'])){
                        if($NBJM<5){
                            echo '<label class="errorL">Pas Assez de Joueurs Titulaires !</label>';
                        }else{
                            ?>
                            <script type="text/javascript">
                            window.location.href = "./ListeMatch.php";
                            </script>
                            <?php
                        }
                    }
                    if(isset($_POST['Annuler'])){ 
                        if($NBJM<5){
                            $sqlP->execute();
                            ?>
                            <script type="text/javascript">
                            window.location.href = "./ListeMatch.php";
                            </script>
                            <?php
                        }else{
                            ?>
                            <script type="text/javascript">
                            window.location.href = "./ListeMatch.php";
                            </script>
                            <?php
                        }
                    }
                ?>
                <div class="grid">
                    <div id="FMFd2">
                    <h3>LISTE DES JOUEURS</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>NumLicence</th>
                                <th>Taille(en cm)</th>
                                <th>Poids(en kg)</th>
                                <th>PostePref</th>
                                <th>Commentaire</th>
                                <th>MoyennePerf</th>
                                <th colspan="2">Ajouter <input type="submit" class="button1" name="Actualiser" value="Actualiser"></th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i=0;
                            foreach ($listeJoueurs->getJoueurs() as $ligneValue) {
                                echo "<tr>";
                                echo "<td><img class='imgJ' src=".'./'.$ligneValue->getPhoto()." alt='Photo'></img></td>";
                                echo "<td>".$ligneValue->getNom()."</td>";
                                echo "<td>".$ligneValue->getPrenom()."</td>";
                                echo "<td>".$ligneValue->getID()."</td>";
                                echo "<td>".$ligneValue->getTaille()."</td>";
                                echo "<td>".$ligneValue->getPoids()."</td>";
                                echo "<td>".$ligneValue->getPostepref()."</td>";
                                if($ligneValue->getCommentaire()==""){
                                    echo "<td>X</td>";
                                } else {
                                    echo "<td>".$ligneValue->getCommentaire()."</td>";
                                }
                                $moyperf=$listeJoueurs->MoyPerformance($ligneValue->getID())['avg(P.Performance)'];
                                if($moyperf==""){
                                    echo "<td>0</td>";
                                }else{
                                    echo "<td>".$listeJoueurs->MoyPerformance($ligneValue->getID())['avg(P.Performance)']."</td>";
                                }
                                if($dateM < date('Y-m-d')) {
                                    echo "<td>MATCH TERMINE</td>";
                                } else if($NBJM>=5){
                                    echo "<td>COMPLET</td>";
                                } else {
                                    echo "<td><input type='submit' name='AjouterT$i' value='Titulaire'></td>";
                                }
                                if($dateM < date('Y-m-d')) {
                                    echo "<td>MATCH TERMINE</td>";
                                } else {
                                    echo "<td><input type='submit' name='Ajouter$i' value='Remplaçant'></td>";
                                }
                                echo "</tr>";
                                ///Si le bouton Ajouter est cliqué
                                if (isset($_POST['AjouterT'.$i])) {
                                    $listeJoueurs->ParticiperJM($IDM,$ligneValue->getID(),"",1);
                                    ?>
                                        <script type="text/javascript">
                                        window.location.href = "./FeuilleMatch.php?ID=<?php echo $IDM;?>";
                                        </script>
                                    <?php
                                }
                                if (isset($_POST['Ajouter'.$i])) {
                                    $listeJoueurs->ParticiperJM($IDM,$ligneValue->getID(),"",0);
                                    ?>
                                        <script type="text/javascript">
                                        window.location.href = "./FeuilleMatch.php?ID=<?php echo $IDM;?>";
                                        </script>
                                    <?php
                                }
                                $i++;
                            }
                        ?>
                        </tbody>
                    </table>
                    </div>
                    <div id="FMFd3">
                        <!--Tableau des participants-->
                        <h3>PARTICIPANT - TITULAIRE <?php echo $NBJM?>/5</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th><input type="submit" class="button1" name="Actualiser" value="Actualiser"></th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>NumLicence</th>
                                    <th>Titulaire</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $LJoueurs = new Joueurs();
                                $LJoueurs->JoueurMatch($IDM);
                                $index=0;
                                foreach ($LJoueurs->getJoueurs() as $ligneValue) {
                                    echo "<tr>";
                                    if($dateM < date('Y-m-d')) {
                                        echo "<td>MATCH TERMINE</td>";
                                    } else {
                                        echo "<td><input type='submit' name='Supprimer$index' value='Supprimer'></td>";
                                    }
                                    echo "<td>".$ligneValue->getNom()."</td>";
                                    echo "<td>".$ligneValue->getPrenom()."</td>";
                                    echo "<td>".$ligneValue->getID()."</td>";
                                    echo "<td>";
                                    if($listeJoueurs->getTitulaire($IDM,$ligneValue->getID())['Titulaire']==1){ 
                                        echo "<img class='imgB' src='./img/check.png' alt='Check'>"; 
                                    }else{
                                        echo "<img class='imgB' src='./img/nocheck.jpg' alt='NoCheck'>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                    ///Quand le bouton Supprimer est cliqué
                                    if (isset($_POST['Supprimer'.$index])) {
                                        $LJoueurs->SupParticiperJM($IDM,$ligneValue->getID());
                                        ?>
                                        <script type="text/javascript">
                                        window.location.href = "./FeuilleMatch.php?ID=<?php echo $IDM;?>";
                                        </script>
                                        <?php
                                    }
                                    $index++;
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!--Liste des boutons-->
                    <input type="submit" class="button1" id="FMFd4" name="Annuler" value="Annuler/Retour">
                    <input type="submit" class="button1" id="FMFd5" name="Valider" value="Valider">
                </div> 
            </div>
        </div>
        </form>
    </main>
 </body>
</html>