<?php
session_start();
if (!isset($_SESSION['nom'])){
    header("Location: index.php");
}
?>
<?php
if (isset($_POST['Envoyer'])) {
    header('Location: ListeJoueur.php');
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
            <!--Deconnexion-->
            <div class="DivHright">
                <div class="deconnecter">
                <a class="button64" name="Deconnexion" href='Logout.php'>Deconnexion</a>
                </div>
            </div>
        </div>       
    </header>
    <?php  
    include_once './classe/Joueur.php';
    ///Quand le bouton Envoyer est cliqué
    if (isset($_POST['Envoyer'])) {
    if ( isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['licence'])
    && isset($_POST['dateN']) && isset($_POST['poids']) && isset($_POST['taille']) ) {
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $licence=$_POST['licence'];
        $dateN=$_POST['dateN'];
        if($dateN > date('Y-m-d')){
            $dateN=date('Y-m-d');
        }
        if($dateN < '1950-01-01'){
            $dateN='1950-01-01';
        }
        $posteP=$_POST['posteP'];
        $statut=$_POST['statut'];
        $poids=$_POST['poids'];
        if($poids>300){
            $poids=300;
        } else if($poids<40){
            $poids=40;
        }
        $taille=$_POST['taille'];
        if($taille>220){
            $taille=220;
        } else if($taille<100){
            $taille=100;
        }
        if($_POST['commentaire']==""){
            $commentaire="";
        } else{
            $commentaire=$_POST['commentaire'];
        }
        $photo=$licence.'.'.strtolower(end(explode('.',$_FILES['image']['name'])));
        try {
            $Joueur= new Joueur($licence,$nom,$prenom,$photo,$dateN,$taille,$poids,$posteP,$statut,$commentaire);
            $Joueur -> creerJoueur($nom,$prenom,$photo,$licence,$dateN,$taille,$poids,$posteP,$statut,$commentaire);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        if(isset($_FILES['image'])){
            $errors= array();
            $file_name = $_FILES['image']['name'];
            $file_size =$_FILES['image']['size'];
            $file_tmp =$_FILES['image']['tmp_name'];
            $file_type=$_FILES['image']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
            $extensions= array("jpeg","jpg","png");
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            if($file_size > 2500000){
                $errors[]='File size must be excately 2 MB';
            }
            if(empty($errors)==true){
                move_uploaded_file($file_tmp,"photo/".$licence.'.'.$file_ext);
            }else{
                print_r($errors);
            }
        }
        }
    }
    ?>
    <main class="main">
        <div class="boxajout">
            <div class="titre">
                <h1> Ajout d'un joueur </h1>
            </div>
            <div class="ajout">
                <!--Formulaire de création-->
                <form name="myForm" enctype = "multipart/form-data" action="#" method="post">
                    <div class="grid">
                        <div id="FLJd1">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required>
                        </div>
                        <div id="FLJd2">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>
                        </div>
                        <div id="FLJd3">
                            <label for="licence">Numéro de licence</label>
                            <input type="number" id="licence" name="licence" placeholder="Entrez votre licence" minlenght="10" maxlength="10" max="9999999999" min="0000000001" required>
                        </div>
                        <div id="FLJd4">
                            <label for="dateN">Date de naissance</label>
                            <input type="date" id="dateN" name="dateN" placeholder="Entrez votre date de naissance" required>
                        </div>
                        <div id="FLJd5">
                            <label for="posteP">Poste préféré : </label>
                            <select name="posteP" id="posteP" placeholder="Entrez votre poste préféré" required>
                                <option value="Attaquant">Attaquant</option>
                                <option value="Defenseur">Defenseur</option>
                                <option value="Milieu">Milieu</option>
                                <option value="Gardien">Gardien</option>
                            </select>
                        </div>
                        <div id="FLJd6">
                            <label for="statut">Statut : </label>
                            <select name="statut" id="statut" placeholder="Entrez votre status" required>
                                <option value="Actif">Actif</option>
                                <option value="Blessé">Blessé</option>
                                <option value="Suspendu">Suspendu</option>
                                <option value="Absent">Absent</option>
                            </select>
                        </div>
                        <div id="FLJd7">
                            <label for="poids">Poids (en kg)</label>
                            <input type="number" id="poids" name="poids" placeholder="Entrez votre poids" required>
                        </div>
                        <div id="FLJd8">
                            <label for="taille">Taille (en cm)</label>
                            <input type="number" id="taille" name="taille" placeholder="Entrez votre taille" required>
                        </div>
                        <div id="FLJd9">
                            <div id="previewimage">
                            </div>
                            <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                            <input type="file" id="avatar" name="image" accept="image/png, image/jpg" required>
                        </div>
                        <div id="FLJd10">
                            <label for="commentaire">Commentaire</label>
                            <textarea type="textarea" id="commentaire" name="commentaire" cols="30" rows="8" placeholder="Entrez votre commentaire"></textarea>
                        </div>
                        <!--Visualisation de l'img avant envoie-->
                        <script type="text/javascript">
                            function createThumbnail(sFile,sId) {
                                var oReader = new FileReader();
                                oReader.addEventListener('load', function() {
                                    var oImgElement = document.createElement('img');
                                    oImgElement.classList.add('imgPreview') 
                                    oImgElement.src = this.result;
                                    document.getElementById('preview'+sId).appendChild(oImgElement);
                                }, false);
                                oReader.readAsDataURL(sFile);
                                }//function
                                function changeInputFil(oEvent){
                                var oInputFile = oEvent.currentTarget,
                                    sName = oInputFile.name,
                                    aFiles = oInputFile.files,
                                    aAllowedTypes = ['png', 'jpg', 'jpeg', 'gif'],
                                    imgType;  
                                document.getElementById('preview'+sName).innerHTML ='';
                                for (var i = 0 ; i < aFiles.length ; i++) {
                                    imgType = aFiles[i].name.split('.');
                                    imgType = imgType[imgType.length - 1];
                                    if(aAllowedTypes.indexOf(imgType) != -1) {
                                    createThumbnail(aFiles[i],sName);
                                    }//if
                                }//for
                                }//function 
                                document.addEventListener('DOMContentLoaded',function(){
                                var aFileInput = document.forms['myForm'].querySelectorAll('[type=file]');
                                for(var k = 0; k < aFileInput.length;k++){
                                    aFileInput[k].addEventListener('change', changeInputFil, false);
                                }//for
                                });
                        </script>
                        <!--Liste des boutons-->
                        <input type="button" class="button1" id="FLJb1" value="Annuler" onclick="window.location.href ='./ListeJoueur.php';">
                        <input type="reset" class="button1" id="FLJb2" value="Vider">
                        <input type="submit" class="button1" id="FLJb3" name="Envoyer" value="Envoyer">
                    </div>
                </form>
            </div>
        </div>
    </main>
 </body>
</html>