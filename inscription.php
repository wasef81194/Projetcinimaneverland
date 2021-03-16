<!DOCTYPE html>
<?php
            
//On inclut le fichier qui établit la connexion
include('db_manager.php');
//Enregistrement des données dans la table test_projet

function MailExist($email){
  // Verifie que le mail entre n'existe pas dans la base de données 
  $request_mail =  ("SELECT mail_user FROM user ");
    $verification_mail = getResults($request_mail);
    while ($row = $verification_mail -> fetch_array( MYSQLI_NUM)) {
        for ($i=0; $i <sizeof($row) ; $i++) { 
          if ($row[$i]==$email) {
            return $MailExist = TRUE;
          }
        }
      }
}
function Inscription($nom,$prenom,$age,$email,$login,$password){
  $request = "INSERT INTO `user`(id_user,nom_user,prenom_user,age_user,mail_user,login_user,mdp_user)
              VALUES (NULL,'$nom', '$prenom','$age', '$email' ,'$login','$password')";
  $inscription = getResults($request);
}

function LoginExist($login){
  $request_login =  ("SELECT login_user FROM user ");
  $verification_login = getResults($request_login);
  while ($row = $verification_login -> fetch_array( MYSQLI_NUM)) {
      for ($i=0; $i <sizeof($row) ; $i++) { 
        if ($row[$i]==$login) {
          return $LoginExist = TRUE;
        }
      }
    }
}



 if($_POST["formtype"] == "inscription"){
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $age = $_POST['age'];
  $email = $_POST['email'];
  $login =  $_POST['login'];
  $password = $_POST['password'];
  $verification = $_POST['verification'];
  $hash=md5($password);

  if (!empty($nom) AND !empty($prenom) AND !empty($age) AND !empty($email) AND !empty($login) AND !empty($password) AND !empty($verification)) {
    //si le mail existe deja un message d'eerreur s'enregistre
    if(MailExist($email)){
      $message_erreur = $email." ce mail est déjà pris";
    }
    //si le login existe déja dans la base de données un message d'erreur s'enregistre
    elseif (LoginExist($login)) {
      $message_erreur = $login." ce login est déjà pris";
    }
    //Verifie que les deux mot de passe sont les même
    elseif($password!=$verification){
      $message_erreur = "Les deux mot de passe ne coresspondent pas";
    }
    //Verifi que le mot de passe doit contient des lettres miniscules et majuscules des chiffre et des caractères spéciaux
    elseif(!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#',$password)){
      $message_erreur = "Votre mot de passe doit contenir des lettres miniscules et majuscules des chiffre et des caractères spéciaux";
    }
    //Verifie le format du mail
    elseif (!preg_match('#^(?=.*[a-z])(?=.*[.])(?=.*[@])#',$email)) {
      $message_erreur = " Mail non conforme";
    }
    //Verifie le format du nom
    elseif (!preg_match("#^(\pL+[- ']?)*\pL$#ui", $nom) AND !preg_match("#^(\pL+[- ']?)*\pL$#ui", $prenom)) {
      $message_erreur = " Nom ou Prénom non conforme";
    }
    //Inscriptin de l'utilisateur dans la bas de données
    else{
      Inscription($nom,$prenom,$age,$email,$login,$hash);
      $message = "Vous êtes bien inscrit";
    }
  }
  else{
    $message_erreur = "Erreur, veuilliez remplir tout les champs";
  }
 }
    
?>

<html lang="fr">
    <head>
         <meta charset="utf-8">
      <title>Cinéma</title>
      <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
<body>
  <header>
    <img id = "logo" src="images/logo.png" />
    <?php 
      session_start();
      include('navb.php'); 
    ?>
  </header>
<div class="navbar">
 
 <div classe="contenair" align="center">
  <form action="./inscription.php" method="post" class="inscription">
    <div>
       <img  id="image" src="images/sing.jpg" width="100" height="100" />
       <h2 id="title_inscription">Inscription </h2>
    </div>
  
  <?php
  if (isset($message_erreur)) {
     echo '<div id="message_erreur">'.$message_erreur.'</div>';
   }
  elseif (isset($message)) {
     echo '<div id="message">'.$message.'</div>';
   } 
   ?>
  <div id="inscription">
  <p>Entrer votre Nom:</p><input type="text" name="nom" required/>
  
  <p>Entrer votre Prénom:</p>
  <input type="text" name="prenom" required/>
  <p>Entrer votre âge:</p>
  <input type="number" name="age" required/>
  <p>Entrer votre mail:</p>
  <input type="email" name="email" required/>
  <p>Entrer votre pseudo:</p>
  <input type="text" name="login" required/>
  <p> Entrer votre mot de passe :</p>
  <p>
  <input type="password" name="password" required/></p>
  <p> Verification de votre mot de passe :</p>
  <p>
  <input type="password" name="verification" required/>
  <p>

  <input type="hidden" name="formtype" value="inscription" />
  <input type="reset" value="recommancer" class="button" />
  <input type="submit" name="validez">
  </p>
  
  <p>Vous avez déja un compte ?
  <a href=connexion.php>cliquez ici pour vous connectez</a></p>
</div>
</form>

</div>
</body>
<footer> 
  <p>Copyright © Développé par WASEF Alexandra et Thilleli BELHOCINE</p>
  <p ><a class="color--white" href="contact.php">CONTACT |||</a><a class="color--white" href="conditions.php"> CONDITIONS GÉNÉRALES D'UTILISATIONS</a></p>
</footer>

</html>