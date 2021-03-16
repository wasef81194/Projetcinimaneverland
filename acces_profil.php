<!DOCTYPE html>

<html lang="fr">
	<head>
		<title>Acceder à mon profil</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link href="css/style.css" rel="stylesheet">
	</head> 
<body> 
	<header>
		<img id = "logo" src="images/logo.png" />
		<?php 
			include('navb.php'); 
		?>
	</header>

	<div id="access">
				<br>
				<br>
				<br>
				<h2>Acceder à mon profil</h2> 
				<p>Vous devez être connecté pour acceder à cette page</p>
				<br>
				<a href="connexion.php"><span class="conn">Connectez vous ici</span></a>
	</div>
</body>
<footer> 
	<p>Copyright © Développé par WASEF Alexandra et Thilleli BELHOCINE</p>
	<p ><a class="color--white" href="contact.php">CONTACT |||</a><a class="color--white" href="conditions.php"> CONDITIONS GÉNÉRALES D'UTILISATIONS</a></p>
</footer>
</html>