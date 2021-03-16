<!DOCTYPE html>
<html>
<head>
	<title>Profil</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<div>
	<header>
		<img id = "logo" src="images/logo.png" />
		<?php 
			session_start();
			include('navb.php'); 

		include('db_manager.php');
		?>
	</header>
</div>

<div id="profil">
	<p>
	<img src="images\user.png">
	</p>
<?php 
if (isset($_SESSION['login'])) {
	echo "Login : ".$_SESSION['login'];
	echo "<br>";
	echo "Nom : ".$_SESSION['nom'];
	echo "<br>";
	echo "Prenom : ".$_SESSION['prenom'];
	echo "<br>";
	echo "Age : ".$_SESSION['age'];
	echo "<br>";
	echo "Mail :".$_SESSION['mail'];

	if(isset($_POST["desinscrire"])){
		$login= $_SESSION['login'];
		$request= ("DELETE FROM user WHERE login_user='$login'");
  		$result = getResults($request);
  		if($result){
	        header('Location: deconnexion.php');
    	}
    }
    elseif (isset($_POST["deconnexion"])) {
    	header('Location: deconnexion.php');
    }
}
else{
		header('Location: connexion.php');

}

?>
<p>
<form action="profil.php" method="post">
    <input type="hidden" name="formtype" value="profil" />
    <input type="submit" name="deconnexion" value="Se déconnecter"/>
    <input type="submit" name="desinscrire" value="Se désinscrire"/>
</form>
</p>
</div>
</body>
<footer> 
	<p>Copyright © Développé par WASEF Alexandra et Thilleli BELHOCINE</p>
	<p ><a class="color--white" href="contact.php">CONTACT |||</a><a class="color--white" href="conditions.php"> CONDITIONS GÉNÉRALES D'UTILISATIONS</a></p>
</footer>
</html>