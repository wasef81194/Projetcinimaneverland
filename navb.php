<?php 
// On recupere l'URL de la page pour ensuite affecter class = "active" aux liens de nav
	

if (isset($_SESSION['login'])){
	$page = $_SERVER['REQUEST_URI'];



?>
<div>
		<nav class="barre">
			<ul class="navbar-nav" id="nav" >
					
					<li <?php if(strpos($page, "index.php") !== false){echo 'class="active"';} ?>><a href="index.php">Acceuil</a></li>
					<li <?php if(strpos($page, "achat_ticket.php") !== false){echo 'class="active"';} ?>><a href="achat_ticket.php">NeverLand Ticket</a></li>
					<li <?php if(strpos($page, "profil.php") !== false){echo 'class="active"';} ?>><a href="profil.php">Profil</a></li>
					<li <?php if(strpos($page, "contact.php") !== false){echo 'class="active"';} ?>><a href="contact.php">Contact</a></li>
					<li <?php if(strpos($page, "conditions.php") !== false){echo 'class="active"';} ?>><a href="conditions.php">Conditions générales d'utilisation</a></li>
					<li <?php if(strpos($page, "deconnexion.php") !== false){echo 'class="active"';} ?>><a href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</nav>
	</div>
<?php
}
else{
?>
<div>
		<nav class="barre" >
			<ul class="navbar-nav" id="nav" >
					
					<li <?php if(strpos($page, "index.php") !== false){echo 'class="active"';} ?>><a href="index.php">Acceuil</a></li>
					<li <?php if(strpos($page, "connexion.php") !== false){echo 'class="active"';} ?>><a href="connexion.php">Connexion/Inscription</a></li>
					<li <?php if(strpos($page, "acces_ticket.php") !== false){echo 'class="active"';} ?>><a href="acces_ticket.php">NeverLand Ticket</a></li>
					<li <?php if(strpos($page, "acces_profil.php") !== false){echo 'class="active"';} ?>><a href="acces_profil.php">Profil</a></li>
					<li <?php if(strpos($page, "contact.php") !== false){echo 'class="active"';} ?>><a href="contact.php">Contact</a></li>
					<li <?php if(strpos($page, "conditions.php") !== false){echo 'class="active"';} ?>><a href="conditions.php">Conditions générales d'utilisation</a></li>

			</ul>
		</nav>

		
	</div>
<?php
}
?>