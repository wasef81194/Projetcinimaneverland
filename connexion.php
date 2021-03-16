<!DOCTYPE html>
<?php
session_start();
//On inclut le fichier qui établit la connexion
include('db_manager.php');

		$doesUserExist = FALSE;

		if(isset($_POST["formtype"])){
  			
  			$login =  $_POST['login'];
  			$password = $_POST['password'];
        $hash = md5($password);
  			if ( !empty($login) AND !empty($password)) {
  				$request= ("SELECT login_user,mdp_user,nom_user,prenom_user,age_user,mail_user,id_user FROM user ");
  				$result = getResults($request);
  				while ($row = $result -> fetch_array( MYSQLI_NUM)) {
  					if ($row[0]==$login AND $row[1]==$hash){
              $_SESSION['login']=$row[0];
              $_SESSION['nom']=$row[2];
              $_SESSION['prenom']=$row[3];
              $_SESSION['age']=$row[4];
              $_SESSION['mail']=$row[5];
              $_SESSION['id_user']=$row[6];

  						$doesUserExist = TRUE;
  					}

  				}
  				if( $doesUserExist == TRUE )
				{      
	  				header('Location: profil.php');
				}
				else{
					header('Location: connexion.php?erreur=connexionErreur');  
					exit();  
				}
  			}
  		}



?>
<html lang="fr">
		<head>
   			 <meta charset="utf-8">

			<title>Identification</title>
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
	<div classe="contenair" align="center">
		

  <div id="connexion">
 		<form action="connexion.php" method="post" class="connexion" >
      <div class = "erreur-connexion">
              <?php
                $matchFound = (isset($_GET["erreur"]) && trim($_GET["erreur"]) == 'connexionErreur');
                if($matchFound){
                  echo "<div id='message_erreur'>Login ou mot de passe incorrect</div>";
                }
              
              ?>
            </div>
      <div>
            <img  id ="image" src="images/login.png" width="125" height="125" />
            <h2 id="title_inscription">Identification </h2>
          </div>
  			
  				<div id="connexion">
  					<p>Entrer votre pseudo:</p>
  					<input type="text" name="login"required/>
  
  					<p>Entrer votre mot de passe:</p>
  					<input type="password" name="password" required/>
            <p>
  					<input type="hidden" name="formtype" value="connexion" />
  					<input type="reset" value="recommancer" class="button" />
  					<input type="submit" name="validez">
            </p>
  
  					<p>Vous n'avez pas de un compte?
  					<a href=inscription.php>Inscrivez vous ici.</a></p>
				</div>
		</form>
  </div>
</body>
<footer> 
  <p>Copyright © Développé par WASEF Alexandra et Thilleli BELHOCINE</p>
  <p ><a class="color--white" href="contact.php">CONTACT |||</a><a class="color--white" href="conditions.php"> CONDITIONS GÉNÉRALES D'UTILISATIONS</a></p>
</footer>

</html>