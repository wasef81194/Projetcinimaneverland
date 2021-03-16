<!DOCTYPE html>
<?php
	include('db_manager.php');
?>
<html>
<head>
	<title>Accueil CinemaNeverLand</title>
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
	</br>
	</br>
	<h1> Les films disponible actuellement</h1>
	</br>
	
	<?php 
	
	
	$month = date('m');
	$day = date('d');
	$years = date('Y');
	$dategte = $years.'-'.($month-1).'-'.$day;
	$datelte = $years.'-'.$month.'-'.$day;
	function genre($id_genre){
		if ($id_genre == 28){
			$genre = "Action";
		}
		elseif ($id_genre == 12){
			$genre = "Aventure";
		}
		elseif ($id_genre == 16){
			$genre = "Animation";
		}
		elseif ($id_genre == 35){
			$genre = "Comédie";
		}
		elseif ($id_genre == 80){
			$genre = "Crime";
		}
		elseif ($id_genre == 99){
			$genre = "Documentaire";
		}
		elseif ($id_genre == 18){
			$genre = "Drame";
		}
		elseif ($id_genre == 10751){
			$genre = "Familial";
		}
		elseif ($id_genre == 14){
			$genre = "Fantastique";
		}
		elseif ($id_genre == 36){
			$genre = "Histoire";
		}
		elseif ($id_genre == 27){
			$genre = "Horreur";
		}
		elseif ($id_genre == 10402){
			$genre = "Musique";
		}
		elseif ($id_genre == 9648){
			$genre = "Mystère";
		}
		elseif ($id_genre == 10749){
			$genre = "Romance";
		}
		elseif ($id_genre == 878){
			$genre = "Science-Fiction";
		}
		elseif ($id_genre == 10770){
			$genre = "Téléfilm";
		}
		elseif ($id_genre == 53){
			$genre = "Thriller";
		}
		elseif ($id_genre == 10752){
			$genre = "Guerre";
		}
		elseif ($id_genre == 37){
			$genre = "Western";
		}
		return $genre;


	}

	function MovieAdult($reponse){
		if ($reponse) {
			$categorie = "Adulte";
		}
		else{
			$categorie = "Tout public";
		}
		return $categorie;
	}

	function Prix($vote){
		if ($vote<=0) {
			$prix = 3;
		}
		elseif (0<$vote AND $vote<100) {
			$prix = 5;
		}
		elseif (100<$vote AND $vote<500) {
			$prix = 8;
		}
		elseif(500<$vote){
			$prix = 10;
		}
		return $prix;
	}
	function Enregistrement($id_film,$titre_film,$date_film,$genre_film,$prix_film,$categorie_age,$duree_film){
	  $request = "INSERT INTO `film`(id_film,titre_film,date_film,genre_film,prix_film,categorie_age,duree_film)
			VALUES ('$id_film','$titre_film','$date_film','$genre_film', '$prix_film' ,'$categorie_age' ,'$duree_film')";
        $enregistrement = getResults($request);
	}
	function Enregistrement_langue($langue,$id_film){
	  $request = "INSERT INTO `langue`(langue_pays,id_film)
			VALUES ('$langue','$id_film')";
        $enregistrement = getResults($request);
	}


	function MovieExist($titre_film){
	  $request_movie =  ("SELECT titre_film FROM film");
	  $verification_movie = getResults($request_movie);
	  while ($row = $verification_movie -> fetch_array( MYSQLI_NUM)) {
	      for ($i=0; $i <sizeof($row) ; $i++) { 
	        if ($row[$i]==$titre_film) {
	          return $MovieExist = TRUE;
	        }
	      }
	    }
	}

	function LangueExist($langue){
	  $request_langue =  ("SELECT langue_pays FROM langue");
	  $verification_langue = getResults($request_langue);
	  while ($row = $verification_langue -> fetch_array( MYSQLI_NUM)) {
	      for ($i=0; $i <sizeof($row) ; $i++) { 
	        if ($row[$i]==$langue) {
	          return $LangueExist = TRUE;
	        }
	      }
	    }
	}
	function Dureefilm($duree){
		if ($duree==0) {
			$duree = 150;
			$heure = $duree/60;
			$minute = number_format($duree/1440, 2, '.', ' ');
			$duree_film= $heure+$minute;
			return $duree_film;
		}
		else{
			$int = floor($duree/60);
			$heure = $duree/60;
			$minute = number_format(($heure-$int), 2, '.', ' ');
			if ($minute>0.60) {
				$int += 1;
				$minute = $minute-0.60;
			}
			$duree_film= $int+$minute;
			return $duree_film;
		}

	}





	$recup_data = file_get_contents('https://api.themoviedb.org/3/discover/movie?primary_release_date.gte='.$dategte.'&primary_release_date.lte='.$datelte.'&api_key=9e7ef272cd6e0e9b4d489464155ad1c6&language=fr');
	$data = json_decode($recup_data,true);// Récupre les donnnées json en php
	//var_dump($data);
	$number = count($data["results"]);

	//echo $number;
	for ($i=0; $i <$number ; $i++) {
		$image = $data["results"][$i]['backdrop_path'];
		$number_genre = count($data["results"][$i]['genre_ids']);//compte le nombre de genre par film
		$titre_film = $data["results"][$i]['title'];// titre
		$date_film = $data["results"][$i]['release_date']; //date de sortie
		$categorie_age = MovieAdult($data["results"][$i]['adult']);//Adulte ou Tout public
		$prix_film = Prix($data["results"][$i]['vote_count']);//Prix du film
		$description_film = $data["results"][$i]['overview'];//Description du film
		$id_film = $data["results"][$i]['id'];//id film
		//echo "$id_film";

		//recupere la durée du film
		$recup_runtime = file_get_contents('https://api.themoviedb.org/3/movie/'.$id_film.'?api_key=9e7ef272cd6e0e9b4d489464155ad1c6');
		$data_runtime = json_decode($recup_runtime,true);
		$runtime = $data_runtime["runtime"];



		$recup_data_langues = file_get_contents('https://api.themoviedb.org/3/movie/'.$id_film.'/translations?api_key=9e7ef272cd6e0e9b4d489464155ad1c6');
		$data_langues = json_decode($recup_data_langues,true);
		$number_langues = count($data_langues["translations"]);
		$pays = "";
		$langue = "";
		for ($l=0; $l <$number_langues ; $l++) { 
			$langue .= $data_langues["translations"][$l]["english_name"]." ";
		}
		//Evite les doublons
		if (LangueExist($langue)==FALSE) {
			Enregistrement_langue($langue,$id_film);
		}
		
		//Affichage
		echo "<div class='card'>
                <div class='hide'>";
                // image
  		echo "<img  class='image' src=https://image.tmdb.org/t/p/w500".$image.">"; 

  		echo "<div class='middle'>";
		if($description_film){
			echo "<p class='text'> Description : ".$description_film."</p>";
			echo "<br> <br>";
		}
		echo"</div>";
  		echo "</div>";
  		echo "<div class='container'>";
		echo "<br><div id='titre_film'>".$titre_film."</div><br>"; 
		echo "<br> <b>Date de Sortie : </b>".$date_film."<br>";//date de sortie
		echo " <b>Catégorie : </b>".$categorie_age."<br>";//Cetegorie age
		echo "<b>Durée : </b>".Dureefilm($runtime)." Heure <br>";//Durée du film 
		//genre
		if ($number_genre) {
			$genre_film =" ";
			for ($x=0; $x <$number_genre ; $x++) {
				$id_genre = $data["results"][$i]['genre_ids'][$x]; // genre
				$genre_film .= genre($id_genre)."  ";
			}
			echo "<b>Genre : </b>".$genre_film."<br>";
		}
		echo "<b>Prix : </b>".$prix_film ."€<br><br>";//Prix
		//echo "Pays : ".$pays."<br>";
		echo "<b>Langue : </b>".$langue."<br>";
		//Affiche les descriptions des films
		
		echo"</div>";
		echo "</div>";

		//Enregistrement des films dans la base de données
		if(MovieExist($titre_film)==FALSE){
			Enregistrement($id_film,$titre_film,$date_film,$genre_film,$prix_film,$categorie_age,Dureefilm($runtime));
		}
	}

	//langue https://api.themoviedb.org/3/movie/{movie_id}/translations?api_key=<<api_key>>
	// https://api.themoviedb.org/3/person/{person_id}?api_key=<<api_key>>&language=en-US Acteur
	//http://api.tmdb.org/3/search/person?api_key=9e7ef272cd6e0e9b4d489464155ad1c6&query=brad%20pitt
	 ?>

	 	
	</div>

</body>
<footer> 
	<p>Copyright © Développé par WASEF Alexandra et Thilleli BELHOCINE</p>
	<p ><a class="color--white" href="contact.php">CONTACT |||</a><a class="color--white" href="conditions.php"> CONDITIONS GÉNÉRALES D'UTILISATIONS</a></p>
</footer>

</html>