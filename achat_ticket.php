<!DOCTYPE html>
<?php
//On inclut le fichier qui établit la connexion
include('db_manager.php');
?>
<html lang="fr">
    <head>
         <meta charset="utf-8">

      <title>Ticket</title>
      <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
<body>
<script type="text/javascript"> 
	//Recharge la page^pour affichier d'autre horraire
	   function other_seance() { 
	   	window.location.reload(false); 
	   } 
</script>
<header>
  <img id = "logo" src="images/logo.png" />
 </header>
  <?php
  session_start();
  	function getData($element,$table,$condition){
		$request=("SELECT $element FROM $table WHERE $condition");
	   $result = getResults($request);
	   $array = array();
	   while ($row = $result -> fetch_array(MYSQLI_NUM)) {
	    array_push($array,$row);   
	   }
	   $element= $array[0][0];
	   return $element;

	} 



	function DateNonDisponible($annee,$mois,$day){
		$mois_non_disponible = $mois+1;
		if ($mois_non_disponible>12) {
			$mois_non_disponible -= 12;
			$mois_non_disponible = "0".$mois_non_disponible;
			$annee += 1;
		}
		$date_non_disponible = "$annee-$mois_non_disponible-$day";
		return $date_non_disponible;

	}

	function FilmNonDisponible($annee,$mois,$day){
		$mois_non_disponible = $mois-1;
		if ($mois_non_disponible<01) {
			$mois_non_disponible += 12;
			$annee -= 1;
		}
		$date_non_disponible = "$annee-$mois_non_disponible-$day";
		return $date_non_disponible;

	}

	function recupere($name_table,$table){
	      $request=("SELECT $name_table FROM $table");
	      $result = getResults($request);
	      $array = array();
	      while ($row = $result -> fetch_array(MYSQLI_NUM)) {
	        array_push($array,$row);   
	      }
	      return $array;
	    //print_r($creneau);

	    }

    function TotalReglement($prix_salle,$nbr_place,$prix_film){
      $total = ($prix_salle+$prix_film)*$nbr_place;
      return $total;
    }
    function Enregistrement_Reglement($montant_regle,$nbr_place,$id_salle,$id_horraire,$date_reservation,$id_user,$id_film){
	  $request = "INSERT INTO `reglement`(id_reglement,montant_regle,nbr_place,id_salle,id_horraire,date_reservation,id_user,id_film)
			VALUES (NULL,'$montant_regle','$nbr_place','$id_salle','$id_horraire','$date_reservation','$id_user','$id_film')";
       $enregistrement = getResults($request);
	}





if (isset($_SESSION['login'])) {
  if($_POST["formtype"] == "select_movie"){
    $film = $_POST["movie"];
    $nbr_place = $_POST["nbr_place"];
    $date_movie = $_POST["date"];
          // Recupreation des horraires dans un tableau
	  if (!empty($nbr_place) AND !empty($film) AND !empty($date_movie)) {
	    $creneau = recupere('debut_film','horraire');
	    $taille_tab = count($creneau);
	    echo $compter;
	    $alea = rand(0,$taille_tab-1);
	    $horraire = $creneau[$alea][0];
	    $seance = "Début de la séance à :".$horraire;


	    //recupreation salles
	    $salle = recupere('nom_salle','salle');
	    $taille_tab = count($salle);
	    echo $compter;
	    $alea = rand(0,$taille_tab-1);
	    $name_salle = $salle[$alea][0];
	    $salle = "<br>Dans la ".$name_salle;

	    $date = date("Y-m-d");
	    
	}

	else{
	  	$message_erreur = "Veuillez remplir tout les champs";
	  }

  }
      

	
 
  ?>

  <div>
    <?php 
      include('navb.php'); 
      $annee = date("Y");
      $mois = date("m");
      $day = date("d");
    ?>
  </div>
  <div classe="contenair" align="center">
   
    

    <form method="post" action="achat_ticket.php" class="ticket">
        <h2 id="h3">Commander votre place de cinéma </h2>
      <label><p>Sélectionner un film</p></label>
      <select name="movie" id="movie">
        <?php

          $request=("SELECT titre_film,date_film from film");
          $result = getResults($request);
          while ($row = $result -> fetch_array( MYSQLI_NUM)) {
          	//Si la date du film date de plus d'un mois le film n'est plus disponible dans notre cinéma
          	if ($row[1]>FilmNonDisponible($annee,$mois,$day)) {
          	
          ?>
          <option value="<?php echo $row[0]; ?>"> <?php echo $row[0]; ?></option>
          <?php
          	}
          }
          ?>
      </select>
          <label><p>Entrer le nombre de place:</p></label>
          <input type="number" name="nbr_place" required>
          <label><p>La date de la séance souhaiter</p></label>
          <input type="date" name="date" required>
          <p></p>
          <input type="hidden" name="formtype" value="select_movie" />
          <input type="submit" name="validez">    
    </form>

<?php


if (isset($seance) AND isset($film) AND isset($salle) AND ($date_movie)) {
	//echo DateNonDisponible($annee,$mois,$day);
	if ($date_movie<$date) {//Verifie que la date entrée n'est pas déja dépasser
	    	$message_erreur =  "Séance Expiré";
	}
	elseif ($date_movie>DateNonDisponible($annee,$mois,$day)) {
		$message_erreur =  "Date non disponible pour le moment";
	}
	elseif ($nbr_place<0) {
		$message_erreur =  "Nombre de place incorrecte";
	}
	else{
	  echo "<div id='ticket'><h3 id='h3'>".$film."</h3> <p>Date : $date_movie</p> <p>".$seance.$salle;
	  echo "</p><p>Nombre de place : ".$nbr_place."<p>";

	  //recupere le prix de la salle
	  $prix_salle = getData("prix_salle","salle","nom_salle='$name_salle'");
	   
	   //recupere id de la salle
	   $id_salle = getData("id_salle","salle","nom_salle='$name_salle'");

	   //recupere id_horraire
	   $id_horraire = getData("id_horraire","horraire","debut_film='$horraire'");


	  //recupere le prix du film 
	   $prix_film = getData("prix_film","film","titre_film='$film'");

	   //recuprer l'id du film
	   $id_film = getData("id_film","film","titre_film='$film'");
	   //recuperer le prix total du ticket
	   $total_prix = TotalReglement($prix_salle,$nbr_place,$prix_film);

	   echo "Le prix total est de : ".$total_prix."€";
	   ?>


	   <form action="./achat_ticket.php" method="post" class="seance">
	   	<input type="button" onclick="other_seance()" value="Autre Séance"/>
	   </form>
	</div>

	   <form action="./achat_ticket.php" method="post" class="achat">
	        <p id="h3">Informations CB</p>
	        <ol>
	        	
				<p>
		            <label for=numero_de_carte>N° de carte(16)</label>
		            <input minlength="16" id=numero_de_carte name=numero_de_carte type=number required>
				</p>
				<p>
		            <label for=securite>Date d'expiration</label>
		            <input id=date name=date type=date required>
				</p>
				<p>
		            <label for=securite>Code sécurité</label>
		            <input minlength="3" id=securite name=securite type=number required>
				</p>
				<p>
		            <label for=nom_porteur>Nom du porteur</label>
		            <input id=nom_porteur name=nom_porteur type=text placeholder="Même nom que sur la carte" required>
				</p>
	          	<p>
		            <input type="checkbox" id="scales" name="scales" required>
		            <label ><a href="conditions.php">Accepter les conditions d'utilisation</a></label>
	          	</p>
	        </ol>
	        <input type="hidden" name="nbr_place" value="<?php echo $nbr_place?>" />
	        <input type="hidden" name="id_salle" value="<?php echo $id_salle?>" />
	        <input type="hidden" name="id_horraire" value="<?php echo $id_horraire?>" />
	        <input type="hidden" name="total_prix" value="<?php echo $total_prix?>" />
	        <input type="hidden" name="date_movie" value="<?php echo $date_movie?>" />
	        <input type="hidden" name="id_film" value="<?php echo $id_film?>" />
	        <input type="submit" name="Valider" value="valider le paiement"> 
	      </form>


	    <?php  
	}
}
if (isset ($_POST["Valider"]) ){
	$nbr_place = $_POST["nbr_place"];
	$id_salle = $_POST["id_salle"];
	$id_horraire = $_POST["id_horraire"];
    $total_prix = $_POST["total_prix"];
    $id_film = $_POST["id_film"];
	$date = date("Y-m-d");
    $id_login = $_SESSION['id_user'];
    //si tout les champs sont remplies
    if (isset ($_POST["numero_de_carte"]) AND isset($_POST['date']) AND isset($_POST['securite'])) {
      // la longeur du numéro de la cb n'est pas égale à 16
      if (strlen($_POST["numero_de_carte"] )!=16) {
         $message_erreur = "Numero de Carte Incorrecte";
      }
      // la longeur du numéro de sécuriter n'est pas égale à 3
      elseif (strlen($_POST["securite"] )!=3) {
        $message_erreur = "Code de Sécurité Incorrecte";
      }
      elseif(!preg_match("#^(\pL+[- ']?)*\pL$#ui", $_POST["nom_porteur"])){
        $message_erreur = "Nom non conforme";
      }
      //si la date de la date à déja expirer
      elseif($_POST["date"]<$date){
       $message_erreur = "Votre carte à expiré";
      }
      //si non on enregistre les informtaion dans la base de données
      else{
       $date_movie = $_POST["date_movie"];
       Enregistrement_Reglement($total_prix,$nbr_place,$id_salle,$id_horraire,$date_movie,$id_login,$id_film);
       $message = "Un mail vous a été envoyer avec votre ticket de cinéma";
       header("refresh:7");
      }
    }

}

// affichage des messages 
if (isset($message)) {
    echo "<p id='mes'>".$message."</p>";
  }
elseif(isset($message_erreur)){
    echo "<p id='erreur'>".$message_erreur."</p>";
}


?>

   
  
</body>
<footer> 
	<p>Copyright © Développé par WASEF Alexandra et Thilleli BELHOCINE</p>
	<p ><a class="color--white" href="contact.php">CONTACT |||</a><a class="color--white" href="conditions.php"> CONDITIONS GÉNÉRALES D'UTILISATIONS</a></p>
</footer>
</html>
<?php 
}
else{
  header('Location: connexion.php');
}
?>