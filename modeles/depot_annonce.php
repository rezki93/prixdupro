<?php

function creerMiniature($dossier,$fichier)
{
	$ext ="";
	if(strtolower(strrchr($fichier, '.')) == ".png" ){
		$ext = ".png";
		$source = imagecreatefrompng($dossier.$fichier);
	}
	
	if(strtolower(strrchr($fichier, '.')) == ".jpg" || strtolower(strrchr($fichier, '.')) == ".jpeg"){
		$source = imagecreatefromjpeg($dossier.$fichier);
		$ext = ".jpg";
	}
	
	if(strtolower(strrchr($fichier, '.')) == ".gif"){
		$source = imagecreatefromjpeg($dossier.$fichier);
		$ext = ".gif";
	}
	
	
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	
	$l = $largeur_source;
	$h = $hauteur_source;
	
	$pourcent = $l / $h ;
	
	while( !($l <= 100 && $h <= 80)){
		$l = $l - ($pourcent * 1);
		$h = $h - (1);
	}
	
	$destination = imagecreatetruecolor($l, $h); // On crée la miniature vide
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);
	imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
	
	if($ext == ".png")
		imagepng($destination, $dossier.'mini_'.$fichier);
	if($ext == ".jpg" )
		imagejpeg($destination, $dossier.'mini_'.$fichier);
	if($ext == ".gif")
		imagegif($destination, $dossier.'mini_'.$fichier);
}

function redimensionner($dossier,$fichier)
{
	$ext ="";
	if(strtolower(strrchr($fichier, '.')) == ".png" || strtolower(strrchr($fichier, '.')) == ".PNG"){
		$ext = ".png";
		$source = imagecreatefrompng($dossier.$fichier);
	}
	
	if(strtolower(strrchr($fichier, '.')) == ".jpg" ||  strtolower(strrchr($fichier, '.')) == ".jpeg" ){
		$source = imagecreatefromjpeg($dossier.$fichier);
		$ext = ".jpg";
	}
	
	if(strrchr($fichier, '.') == ".gif" ){
		$source = imagecreatefromgif($dossier.$fichier);
		$ext = ".gif";
	}
	
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	
	$l = $largeur_source;
	$h = $hauteur_source;
	$pourcent = $l / $h ;
	
	while( !($l <= 600 && $h <= 450)){
		$l = $l - ($pourcent * 1);
		$h = $h - (1);
	}
	
	$destination = imagecreatetruecolor($l, $h); // On crée la miniature vide
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);
	imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
	
	if($ext == ".png")
		imagepng($destination, $dossier.$fichier);
	if($ext == ".jpg")
		imagejpeg($destination, $dossier.$fichier);
	if($ext == ".gif")
		imagegif($destination, $dossier.$fichier);
}


function verifPhotos($photos){ // renvoi true si c ok, false sinon;
	$extensions = array('.png','.PNG','.gif','.GIF' ,'.jpg','.JPG' ,'.jpeg','.JPEG');
	$taille_maxi = 32000000; // 32MO
	$resultat = true;
	
	$res = false;
	foreach($photos as $p){
		if($p['error'] == 0){
			if(!in_array(strtolower(strrchr($p['name'], '.')), $extensions)){
				$resultat = true;
				$erreur = 3; //probleme extension;		
				return false;	
			}		
			if($p['size'] > $taille_maxi){
				$resultat = true;
				$erreur = 2;//Le fichier est trop gros
				echo $erreur;
				return false;
			}
		}	
	}
		
	return $resultat;
}


function envoiPhoto($dossier,$photo){
	$fichier = $photo['name'];
	$fichier = strtr($fichier,  'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
	$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
	
	if($fichier != ""){
		$chemin_fichier = $dossier.$fichier;
		$valid1 = move_uploaded_file($photo['tmp_name'], $chemin_fichier);
		redimensionner($dossier,$fichier);
		creerMiniature($dossier,$fichier);
		return true;
	}
	else
		return false;

}


function deposer_annonce()
{
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis php5.3
	$date_annonce = date('Y\-m\-d H:i:s');	
	$tab['reponse'] = 0 ; // 0 = erreur, 1 = OK, 2=photos trop grosse, 3=pb extension
	$id_user = $_SESSION['con_id'] ;
	$titre_annonce = $_POST['titre_annonce'];
	$desc_annonce = nl2br($_POST['desc_annonce']);
	$cat_annonce = $_POST['cat_annonce'];
	$prix_annonce = $_POST['prix_annonce'];
	
	if(isset($_POST['map_annonce']))	$map_annonce = $_POST['map_annonce'];
	else	$map_annonce = "off";
		
	if(isset($_POST['debat_annonce']))	$debat_annonce = $_POST['debat_annonce'];
	else	$debat_annonce = "off";
		
	if(isset($_POST['affiche_tel']))	$affiche_tel = $_POST['affiche_tel'];
	else	$affiche_tel = "off";
		
	if(isset($_POST['affiche_adresse']))	$affiche_adresse = $_POST['affiche_adresse'];
	else	$affiche_adresse = "off";
		
		
	
	if(isset($_POST['annee_annonce']) && $_POST['annee_annonce'] != "" )	$annee = $_POST['annee_annonce'];
	if(isset($_POST['km_annonce'])  && $_POST['km_annonce'] != "")		$km = $_POST['km_annonce'];	
	if(isset($_POST['energie_annonce'])  && $_POST['energie_annonce'] != "")	$energie = $_POST['energie_annonce'];
	if(isset($_POST['boite_annonce'])  && $_POST['boite_annonce'] != "")	$boite = $_POST['boite_annonce'];
	
	$chaine4 = "SELECT id_annonce  
			FROM ANNONCES
			WHERE ANNONCES.id_user = '".$id_user."'
			AND ANNONCES.titre_annonce = '".$titre_annonce."'
			AND ANNONCES.desc_annonce = '".$desc_annonce."'
			AND ANNONCES.cat_annonce = '".$cat_annonce."'
			";
	
	$req4 = mysqli_query($link, $chaine4);
	$num_req4 = mysqli_num_rows($req4);
	//Verifie si l'adresse a deja été créé
	if($num_req4 > 0)
	{
		$tab['reponse'] = 4;
		return $tab;
	}
	
	
	$photos = Array();
	
	for($i=1; $i<=3; $i++){
		if(isset($_FILES['photo'.$i]['error']) && $_FILES['photo'.$i]['error'] != 4){
			$photos[$i] = $_FILES['photo'.$i];
		} 
	}
	
	if( verifPhotos($photos) == 1 )
	{
		// On insere ds la table
		$chaine = "INSERT INTO `ANNONCES` (`id_annonce`, `id_user`, `titre_annonce`, `desc_annonce`, `cat_annonce`, `prix_annonce`, `date_annonce`, `map_annonce`, `debat_annonce` , `etat_annonce`, `affiche_adresse` , `affiche_tel`)
		VALUES (NULL, '".$id_user."', '".$titre_annonce."', '".$desc_annonce."', '".$cat_annonce."', '".$prix_annonce."', '".$date_annonce."', '".$map_annonce."', '".$debat_annonce."' , 'en attente', '".$affiche_adresse."', '".$affiche_tel."')";	
		$req = mysqli_query($link,$chaine);
		if( $req == true )
		{
			$tab['reponse'] = 1;
			$tab['id_annonce'] = mysqli_insert_id($link);
			$tab['titre_annonce'] = $titre_annonce;
			$tab['desc_annonce'] = $desc_annonce;
			$tab['cat_annonce'] = $cat_annonce;
			$tab['prix_annonce'] = $prix_annonce;
			$tab['date_annonce'] = $date_annonce;
			$tab['map_annonce'] = $map_annonce;
			$tab['debat_annonce'] = $debat_annonce;
			
			$chaine2 = "SELECT id_annonce 
			FROM ANNONCES
			WHERE ANNONCES.id_user = '".$id_user."'
			AND ANNONCES.titre_annonce = '".$titre_annonce."'
			AND ANNONCES.desc_annonce = '".$desc_annonce."'
			AND ANNONCES.cat_annonce = '".$cat_annonce."'
			AND ANNONCES.date_annonce = '".$date_annonce."'
			AND ANNONCES.map_annonce = '".$map_annonce."'
			AND ANNONCES.debat_annonce = '".$debat_annonce."'
			";
			
			$req2 = mysqli_query($link,$chaine2);
			$res = Array();
			while ($data = mysqli_fetch_assoc($req2))
			{
				$res['annonce'] = $data;
			}
			$id_annonce = $res['annonce']['id_annonce'];	
			
			if($cat_annonce == 1 ){
				$chaine3 = "INSERT INTO `cat_auto` (`id_auto` ,`annee_annonce` ,`km_annonce` ,`energie_annonce` ,`boite_annonce`)
							VALUES ('".$id_annonce."', '".$annee."', '".$km."', '".$energie."', '".$boite."');";
				$req3 = mysqli_query($link,$chaine3);
				
				$tab['annee_annonce'] = $annee;
				$tab['km_annonce'] = $km;
				$tab['energie_annonce'] = $energie;
				$tab['boite_annonce'] = $boite;
			}
			

			
			$chaine_chemins = "";
			$valid = true;
			
			if( !empty($photos))
			{
				/*Envoi de photos*/
				$dossier = 'upload/'.$id_annonce.'/';
				mkdir($dossier, 0777, true);
				
				foreach($photos as $p){
					$valid = $valid && envoiPhoto($dossier,$p);
					if($valid)
						$chaine_chemins = $chaine_chemins.$dossier.preg_replace('/([^.a-z0-9]+)/i', '-', $p['name']).';';
				}

			}

			if($valid)
			{	
				$chaine3="UPDATE ANNONCES
				SET ANNONCES.photos_annonce = '".$chaine_chemins."'
				WHERE ANNONCES.id_annonce = ".$id_annonce;
				$req3 = mysqli_query($link,$chaine3);
				$tab['photos_annonce'] = $chaine_chemins;
			}
			else{
				echo 'Erreurs d\'envoi des fichiers';
				$tab['reponse'] = 0;
			}
		}
	}
	else
	{
		if( verifPhotos($photos) == 2 )	$tab['reponse'] = 2;
		if( verifPhotos($photos) == 3 )	$tab['reponse'] = 3;
	}

	return $tab;
}































function deposer_annonce($titre_annonce,$prix_annonce,$desc_annonce,$cat_annonce,$map_annonce,$debat_annonce,$affiche_tel,$affiche_adresse,$photos,$id_user,$annee,$km,$energie,$boite){
	$date_annonce = date('Y\-m\-d H:i:s');	
	$chaine4 = "SELECT id_annonce  
			FROM ANNONCES
			WHERE ANNONCES.id_user = '".$id_user."'
			AND ANNONCES.titre_annonce = '".$titre_annonce."'
			AND ANNONCES.desc_annonce = '".$desc_annonce."'
			AND ANNONCES.cat_annonce = '".$cat_annonce."'
			";
	
	$req4 = mysqli_query($link, $chaine4);
	$num_req4 = mysqli_num_rows($req4);
	//Verifie si l'adresse a deja été créé
	if($num_req4 > 0)
	{
		$tab['reponse'] = 4;
		return $tab;
	}
	
	
	$photos = Array();
	
	for($i=1; $i<=3; $i++){
		if(isset($_FILES['photo'.$i]['error']) && $_FILES['photo'.$i]['error'] != 4){
			$photos[$i] = $_FILES['photo'.$i];
		} 
	}
	
	if( verifPhotos($photos) == 1 )
	{
		// On insere ds la table
		$chaine = "INSERT INTO `ANNONCES` (`id_annonce`, `id_user`, `titre_annonce`, `desc_annonce`, `cat_annonce`, `prix_annonce`, `date_annonce`, `map_annonce`, `debat_annonce` , `etat_annonce`, `affiche_adresse` , `affiche_tel`)
		VALUES (NULL, '".$id_user."', '".$titre_annonce."', '".$desc_annonce."', '".$cat_annonce."', '".$prix_annonce."', '".$date_annonce."', '".$map_annonce."', '".$debat_annonce."' , 'en attente', '".$affiche_adresse."', '".$affiche_tel."')";	
		$req = mysqli_query($link,$chaine);
		if( $req == true )
		{
			$tab['reponse'] = 1;
			$tab['id_annonce'] = mysqli_insert_id($link);
			$tab['titre_annonce'] = $titre_annonce;
			$tab['desc_annonce'] = $desc_annonce;
			$tab['cat_annonce'] = $cat_annonce;
			$tab['prix_annonce'] = $prix_annonce;
			$tab['date_annonce'] = $date_annonce;
			$tab['map_annonce'] = $map_annonce;
			$tab['debat_annonce'] = $debat_annonce;
			
			$chaine2 = "SELECT id_annonce 
			FROM ANNONCES
			WHERE ANNONCES.id_user = '".$id_user."'
			AND ANNONCES.titre_annonce = '".$titre_annonce."'
			AND ANNONCES.desc_annonce = '".$desc_annonce."'
			AND ANNONCES.cat_annonce = '".$cat_annonce."'
			AND ANNONCES.date_annonce = '".$date_annonce."'
			AND ANNONCES.map_annonce = '".$map_annonce."'
			AND ANNONCES.debat_annonce = '".$debat_annonce."'
			";
			
			$req2 = mysqli_query($link,$chaine2);
			$res = Array();
			while ($data = mysqli_fetch_assoc($req2))
			{
				$res['annonce'] = $data;
			}
			$id_annonce = $res['annonce']['id_annonce'];	
			
			if($cat_annonce == 1 ){
				$chaine3 = "INSERT INTO `cat_auto` (`id_auto` ,`annee_annonce` ,`km_annonce` ,`energie_annonce` ,`boite_annonce`)
							VALUES ('".$id_annonce."', '".$annee."', '".$km."', '".$energie."', '".$boite."');";
				$req3 = mysqli_query($link,$chaine3);
				
				$tab['annee_annonce'] = $annee;
				$tab['km_annonce'] = $km;
				$tab['energie_annonce'] = $energie;
				$tab['boite_annonce'] = $boite;
			}
			

			
			$chaine_chemins = "";
			$valid = true;
			
			if( !empty($photos))
			{
				/*Envoi de photos*/
				$dossier = 'upload/'.$id_annonce.'/';
				mkdir($dossier, 0777, true);
				
				foreach($photos as $p){
					$valid = $valid && envoiPhoto($dossier,$p);
					if($valid)
						$chaine_chemins = $chaine_chemins.$dossier.preg_replace('/([^.a-z0-9]+)/i', '-', $p['name']).';';
				}

			}

			if($valid)
			{	
				$chaine3="UPDATE ANNONCES
				SET ANNONCES.photos_annonce = '".$chaine_chemins."'
				WHERE ANNONCES.id_annonce = ".$id_annonce;
				$req3 = mysqli_query($link,$chaine3);
				$tab['photos_annonce'] = $chaine_chemins;
			}
			else{
				echo 'Erreurs d\'envoi des fichiers';
				$tab['reponse'] = 0;
			}
		}
	}
	else
	{
		if( verifPhotos($photos) == 2 )	$tab['reponse'] = 2;
		if( verifPhotos($photos) == 3 )	$tab['reponse'] = 3;
	}

	return $tab;
}