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
                <h1> Modification d'un joueur </h1>
            </div>
            <?php    
                include_once './classe/Joueur.php';
                include_once './classe/DataBase.php';
                ///Selection du joueur ID
                try {
                    $joueur = Database::getInstance()->selectL("J.Nom, J.Prenom, J.Photo, J.NumLicense, J.DateNaissance,
                    J.Taille, J.Poids, J.PostePref, J.Statut,J.commentaire","Joueur J","".$_GET["ID"]);
                    $nom=$joueur['Nom'];
                    $prenom=$joueur['Prenom'];
                    $licence=$joueur['NumLicense'];
                    $dateN=$joueur['DateNaissance'];
                    $posteP1=$joueur['PostePref'];
                    $statut1=$joueur['Statut'];
                    $poids=$joueur['Poids'];
                    $taille=$joueur['Taille'];
                    $photo1=$joueur['Photo'];
                    $commentaire=$joueur['commentaire'];
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
            ?> 
            <div class="ajout">
                <!--Formulaire de modification-->
                <form name="myForm" enctype="multipart/form-data" action="#" method="post">
                    <div class="grid">
                        <div id="FLJd1">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" value="<?= $nom?>" required>
                        </div>
                        <div id="FLJd2">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" value="<?= $prenom?>" required>
                        </div>
                        <div id="FLJd3">
                            <label for="licence">Numéro de licence</label>
                            <input type="number" id="licence" name="licence" value="<?= $licence?>" maxlength="10" readonly>
                        </div>
                        <div id="FLJd4">
                            <label for="dateN">Date de naissance</label>
                            <input type="date" id="dateN" name="dateN" value="<?= $dateN?>" required>
                        </div>
                        <div id="FLJd5">
                            <label for="posteP">Poste préféré : </label>
                            <select name="posteP" id="posteP" placeholder="Entrez votre poste préféré" required>
                                <option value="<?php echo $posteP1?>">[<?php echo $posteP1?>]</option>
                                <option value="Attaquant">Attaquant</option>
                                <option value="Defenseur">Defenseur</option>
                                <option value="Milieu">Milieu</option>
                                <option value="Gardien">Gardien</option>
                            </select>
                        </div>
                        <div id="FLJd6">
                            <label for="statut">Statut : </label>
                            <select name="statut" id="statut" placeholder="Entrez votre status" required>
                                <option value="<?php echo $statut1?>">[<?php echo $statut1?>]</option>
                                <option value="Actif">Actif</option>
                                <option value="Blessé">Blessé</option>
                                <option value="Suspendu">Suspendu</option>
                                <option value="Absent">Absent</option>
                            </select>
                        </div>
                        <div id="FLJd7">
                            <label for="poids">Poids (en kg)</label>
                            <input type="number" id="poids" name="poids" value="<?= $poids?>" required>
                        </div>
                        <div id="FLJd8">
                            <label for="taille">Taille (en cm)</label>
                            <input type="number" id="taille" name="taille" value="<?= $taille?>" required>
                        </div>
                        <div id="FLJd9">
                            <div id="previewimage">
                                <img src="<?= $photo1?>" alt='Photo'></img>
                            </div>
                            <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                            <input type="file" id="avatar" name="image" accept="image/png, image/jpg">
                        </div>
                        <div id="FLJd10">
                            <label for="commentaire">Commentaire</label>
                            <textarea type="textarea" id="commentaire" name="commentaire" cols="30" rows="8"><?= $commentaire?></textarea>
                        </div>
                        <script type="text/javascript">
                            //Afficher img avant envoie
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
                        <input type="button" class="button1" id="FLJb1" value="Retour" onclick="window.location.href ='./ListeJoueur.php';">
                        <input type="submit" class="button1" id="FLJb3" name="Envoyer" value="Modification">
                    </div> 
                    <?php
                        ///Quand le bouton valider est cliqué
                        if (isset($_POST['Envoyer'])) {
                            if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['licence'])
                            && isset($_POST['dateN'])&& isset($_POST['posteP'])&& isset($_POST['statut'])
                            && isset($_POST['poids'])&& isset($_POST['taille'])) {
                                $nom=$_POST['nom'];
                                $prenom=$_POST['prenom'];
                                $licence=$_POST['licence'];
                                if(iconv_strlen($licence)<10){
                                    while(iconv_strlen($licence)==10){
                                        $licence=$licence.rand(0,9);
                                    }
                                }
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
                                $commentaire=$_POST['commentaire'];
                                if($_FILES['image']['name']==""){
                                    $photo=$photo1;
                                } else {
                                    $photo='photo/'.$licence.'.'.strtolower(end(explode('.',$_FILES['image']['name'])));
                                }
                                try {
                                    $Joueur= new Joueur($licence,$nom,$prenom,$photo,$dateN,$taille,$poids,$posteP,$statut,$commentaire);   
                                    $Joueur -> updateJoueur($nom,$prenom,$photo,$licence,$dateN,$taille,$poids,$posteP,$statut,$commentaire);
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
                </form>
        </div>
    </main>
 </body>
</html>