<!DOCTYPE html>
<?php
	include('db_manager.php');
?>
<html lang="fr">
	<head>
		<title>Contact</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link href="css/style.css" rel="stylesheet">
	</head> 
<body> 
	
	<header>
		<img id = "logo" src="images/logo.png" />
		<?php 
			session_start();
			include('navb.php'); 
		?>
	</header>

	<div id="contact">
		<br>
		<br>
		
			<?php
				$request= ("SELECT nom_cinema,telephone_cinema, ad_cinema,ville_cinema,email_cinema FROM cinema ");
  				$result = getResults($request);
  				while ($row = $result -> fetch_array( MYSQLI_NUM)) {
  				?>
	  				<tr>
						<td>Vous avez des question? Contactez <strong><?php echo $row[0];?></strong></td>
					</tr>
					<br>
					
	  				<tr>
						<td><img id ="image" src="images/phone.png" width="50" height="50"/> </td>
					</tr>
					<br>
					<tr>
						<td>Par téléphone: (0033)<?php echo $row[1] ?> </td>
					</tr>
					<br>
					
					<tr>
						<td><img id ="image" src="images/courrier.jpg" width="50" height="50"/>
					</tr>
					<br>
					<tr>
						</td><td>Par courrier: <?php echo $row[2] ?> <br> <?php echo $row[3] ?></td></tr>
					</tr>
					<br>
					
					<tr>
						<td><img id ="image" src="images/courriel.png" width="50" height="50"/> 
					</tr>
					<br>
					<tr>
						</td><td>Par courriel: <?php echo $row[4]; ?></td>
					</tr>
  				<?php	
  				}
	
				?>

  		
  </div>
	
			
		
</body>
<footer> 
	<p>Copyright © Développé par WASEF Alexandra et Thilleli BELHOCINE</p>
	<p><a class="color--white" href="contact.php">CONTACT |||</a><a class="color--white" href="conditions.php"> CONDITIONS GÉNÉRALES D'UTILISATIONS</a></p>
</footer>
</html>