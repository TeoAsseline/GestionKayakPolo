<?php
session_start();
if (!isset($_SESSION['nom'])){
    header("Location: index.php");
}
?>
<?php
///Quand le bouton Modification est cliqué
    if (isset($_POST['Modification'])) {
        if (isset($_POST['dateM']) && isset($_POST['heureM']) && isset($_POST['equipeA'])
        && isset($_POST['lieu'])&& isset($_POST['adresse'])) {
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
                <h1> Modification d'un match </h1>
            </div>
            <?php    
                include_once './classe/MatchJ.php';
                include_once './classe/DataBase.php';
                error_reporting(E_ERROR | E_PARSE);
                ///Recupération des infos du match ID
                try {
                    $match = Database::getInstance()->selectL("M.DateM,M.HeureM,M.NomEquipeAdv,M.Lieu,M.Resultat,M.IDmatch,
                    M.Adresse,M.Ville","MatchJ M","where IDmatch=".$_GET["ID"]);
                    $dateM=$match['DateM'];
                    $heureM=$match['HeureM'];
                    $equipeA=$match['NomEquipeAdv'];
                    $lieu=$match['Lieu'];
                    $resultat=$match['Resultat'];
                    $id=$match['IDmatch'];
                    $adresse=$match['Adresse'];
                    $ville=$match['Ville'];
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                ///Quand le bouton Modification est cliqué
                if (isset($_POST['Modification'])) {
                    if (isset($_POST['dateM']) && isset($_POST['heureM']) && isset($_POST['equipeA'])
                    && isset($_POST['lieu'])&& isset($_POST['adresse'])) {
                        $dateM=$_POST['dateM'];
                        $heureM=$_POST['heureM'];
                        $equipeA=$_POST['equipeA'];
                        $lieu=$_POST['lieu'];
                        $adresse=$_POST['adresse'];
                        $ville=$_POST['ville'];
                        $resultat=$_POST['resultat'];
                        try {
                            $MatchJ= new MatchJ($dateM,$heureM,$equipeA,$lieu,$resultat,$id,$adresse,$ville);  
                            $MatchJ -> updateMatch($dateM,$heureM,$equipeA,$lieu,$resultat,$adresse,$ville,$id);
                        } catch (Exception $ex) {
                            echo $ex->getMessage();
                        }
                    }
	            }
            ?> 
            <div class="ajout">
                <!--Formulaire de modification de match-->
                <form name="myForm" action="#" method="post">
                    <div class="grid">
                        <div id="FMMd1">
                            <label for="dateM">Date</label>
                            <input type="date" id="dateM" name="dateM" value="<?= $dateM?>" required>
                        </div>
                        <div id="FMMd2">
                            <label for="heureM">Heure</label>
                            <input type="time" id="heureM" name="heureM" value="<?= $heureM?>" required>
                        </div>
                        <div id="FMMd3">
                            <label for="equipeA">Nom équipe adverse</label>
                            <input type="text" id="equipeA" name="equipeA" value="<?= $equipeA?>" required>
                        </div>
                        <div id="FMMd4">
                            <label for="lieu">Lieu</label>
                            <select name="lieu" id="lieu" placeholder="Entrez le lieu" required>
                                <option value="<?php echo $lieu?>">[<?php echo $lieu?>]</option>
                                <option value="Domicile">Domicile</option>
                                <option value="Exterieur">Exterieur</option>
                            </select>
                        </div>
                        <div id="FMMd5">
                            <label for="adresse">Adresse</label>
                            <input type="text" id="adresse" name="adresse" value="<?= $adresse?>">
                        </div>
                        <div id="FMMd6">
                            <label for="ville">Ville</label>
                            <input type="text" id="ville" name="ville" value="<?= $ville?>">
                        </div>
                            <?php if($dateM > date('Y-m-d')){
                                echo "<div id='FMMd9'>";
                                echo "<label for='resultat'>Resultat</label>";
                                echo "<input type='text' name='resultat' id='resultat' value='' placeholder='Match Non Terminé' readonly>";
                                echo "</div>";
                            }else if($resultat != ''){
                                echo "<div id='FMMd9'>";
                                echo "<label for='resultat'>Resultat</label>";
                                echo "<input type='text' name='resultat' id='resultat' value='$resultat' readonly>";
                                echo "</div>";
                            }else {
                                echo "<div id='FMMd7'>";
                                echo "<label for='resultat'>Resultat</label>";
                                echo "<select name='resultat' id='resultat' placeholder='Entrez le resultat' required>
                                    <option value='$resultat'>[$resultat]</option>
                                    <option value='Gagné'>Gagné</option>
                                    <option value='Perdu'>Perdu</option>
                                    <option value='Nul'>Nul</option>
                                </select>";
                                echo "</div>";
                             }
                            ?>
                        <table id="FMMd8">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Titulaire</th>
                                    <th>Note</th>
                                    <th>Nouvelle Note (0 à 5)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                include './classe/Joueurs.php';
                                $listeJoueurs = new Joueurs();
                                $listeJoueurs->JoueurMatch($_GET["ID"]);
                                $LjID= [];
                                $LjPerf= [];
                                $i=0;
                                foreach ($listeJoueurs->getJoueurs() as $ligneValue) {
                                    echo "<tr>";
                                    $LjID[$i]=$ligneValue->getID();
                                    echo "<td>".$ligneValue->getNom()."</td>";
                                    echo "<td>".$ligneValue->getPrenom()."</td>";
                                    echo "<td>";
                                    if($listeJoueurs->getTitulaire($_GET["ID"],$ligneValue->getID())['Titulaire']==1){ 
                                        echo "<img class='imgB' src='./img/check.png' alt='Check'>"; 
                                    }else{
                                        echo "<img class='imgB' src='./img/nocheck.jpg' alt='NoCheck'>";
                                    }
                                    echo "</td>";
                                    echo "<td>".$listeJoueurs->getPerformance($_GET["ID"],$ligneValue->getID())['Performance']."</td>";
                                    $LjPerf[$i]=$listeJoueurs->getPerformance($_GET["ID"],$ligneValue->getID())['Performance'];
                                    if($dateM <= date('Y-m-d')){
                                    echo "<td><input type='number' id='perf$i' name='perf$i' maxlenght='1'></td>";
                                    } else {
                                        echo "<td>Attendre $dateM</td>";
                                    }
                                    echo "</tr>";
                                    $i++;
                                }
                                ///Quand le bouton Modification est cliqué
                                if (isset($_POST['Modification'])) {
                                    if (isset($_POST['dateM']) && isset($_POST['heureM']) && isset($_POST['equipeA'])
                                    && isset($_POST['lieu'])&& isset($_POST['adresse'])) {
                                        for($a=0;$a<$i;$a++){
                                            if($_POST['perf'.$a]!=""){
                                                $LjPerf[$a]=$_POST['perf'.$a.''];
                                                if($LjPerf[$a]>5){
                                                    $LjPerf[$a]=5;
                                                }else if($LjPerf[$a]<0){
                                                    $LjPerf[$a]=0;
                                                }
                                                $listeJoueurs->updatePerf($_GET["ID"],$LjID[$a],$LjPerf[$a]);
                                            }
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <!--Liste des boutons-->
                        <input type="button" class="button1" id="FMMb1" value="Retour" onclick="window.location.href ='./ListeMatch.php';">
                        <input type="submit" class="button1" id="FMMb2" name="Modification" value="Modification">
                    </div>   
                </form>
        </div>
    </main>
 </body>
</html>