<?php
session_start();
if (isset($_SESSION['nom'])){
   header("Location: accueil.php");
}
//si le bouton "Connexion" est cliqué
if(isset($_POST['submit'])){
    // on vérifie que le champ "Pseudo" n'est pas vide
    if(empty($_POST['username'])){
        session_unset();
        echo '<label class="errorL">Le champ Identifiant est vide.</label>';
    } else {
        // on vérifie maintenant si le champ "Mot de passe" n'est pas vide"
        if(empty($_POST['mdp'])){
            session_unset();
            echo '<label class="errorL">Le champ Mot de passe est vide.</label>';
        } else {
            include_once './classe/Connexion.php';
            $id=$_POST['username'];
            $mdp=$_POST['mdp'];
            $Conn= new Connexion();
            $result=$Conn -> connecter($id,$mdp);
            if($result==1){
               $_SESSION['nom']='admin';
               ?>
               <script type='text/javascript'>document.location.replace('accueil.php');</script>";
               <?php
            } else {
               session_unset();
               echo '<label class="errorL">Identifiant et Mot de passe invalide !</label>';
            }
        }
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
 <body class="index">
   <div class="signin"> <!--signin-->
      <div class="backimg"> <!--img-->
         <div class="signinTitre">
            <h2 class="active">CONNEXION</h2>
         </div>
         <div class="ligne">
         </div>
      </div> <!--fin img-->
      <div class="form-section">
         <form id="formConnect" action="" method="POST"> <!--form-->
            <!--Email-->
            <div class="Cform">
               <label class="Clabel">Identifiant</label>
               <input class="" type="text" id="username" name="username" placeholder="Veuillez entrer votre identifiant">
            </div>
            <!--Password-->
            <div class="Cform">
               <label class="Clabel">Mot de Passe</label>
               <input class="" type="password" id="mdp" name="mdp" placeholder="Veuillez entrer votre mot de passe">
            </div>
            <input type="submit" name="submit" for="formConnect" class="signinBtn" value="SE CONNECTER"></input>
         </form> <!--fin form-->
      </div>
   </div><!--fin signin-->
 </body>
</html>