<?php

class Annonce{
  
    public $id,$titre,$prix,$desc,$date,$cat,$map,$debat,$affiche_tel,$affiche_adresse,$etat,$photos,$annee,$km, $energie, $boite = "";
	public $id_user, $prenom_user, $adresse_user, $ville_user, $dep_user, $region_user, $tel_user, $mail_user = "";
	public $link;
 
    public function __construct(){
		$this->id = "";
		$this->titre = "";
		$this->prix = "";;
		$this->desc = "";
		$this->date = "";
		$this->id_user = "";
		$this->cat = "";
		$this->map = "";
		$this->debat = "";
		$this->affiche_tel = "";
		$this->affiche_adresse = "";
		$this->etat = "";
		$this->photos = ""; 
		$this->link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
    }
    
   public function init($id,$titre,$prix,$desc,$date,$cat,$map,$debat,$affiche_tel,$affiche_adresse,$etat,$photos,$id_user,$prenom_user,$adresse_user,$ville_user,$dep_user,$region_user,$tel_user,$mail_user){
      $this->id= $id;
      $this->titre = $titre;
      $this->prix = $prix;
      $this->desc= $desc;
      $this->date= $date;
      $this->cat= $cat;
      $this->map= $map;
      $this->debat= $debat;
      $this->affiche_tel= $affiche_tel;
      $this->affiche_adresse= $affiche_adresse;
      $this->etat= $etat;
      $this->photos= $photos;
     
      $this->id_user= $id_user;
      $this->prenom_user= $prenom_user;
      $this->adresse_user= $adresse_user;
      $this->ville_user= $ville_user;
      $this->dep_user= $dep_user;
      $this->region_user= $region_user; 
      $this->tel_user= $tel_user;
      $this->mail_user= $mail_user;      
    }
    
    public function copierAnnonce(Annonce $a){
      $this->init($a->id,$a->titre,$a->prix,$a->desc,$a->date,$a->cat,$a->map,$a->debat,$a->affiche_tel,$a->affiche_adresse,$a->etat,$a->photos,$a->id_user,$a->prenom_user,$a->adresse_user,$a->ville_user,$a->dep_user,$a->region_user,$a->tel_user,$a->mail_user);     
    }
      
   
    
    public function recuperer_une_annonce($ref){
		$annonces = array();
		$auto = array();
  
          if (is_numeric($ref)) 
          {
             $chaine = "SELECT *
                        FROM ANNONCES,USERS
                        where ANNONCES.id_user=USERS.id_user
                        and ANNONCES.id_annonce=".$ref; 
              
              echo $chaine;

			 $req = mysqli_query($this->link, $chaine); //depuis php5.3
             while ($data = mysqli_fetch_assoc($req)){
               $annonces = $data;
             }
               $this->id = $annonces['id_annonce'];
               //$this->id= "id_annonce";
               $this->titre= $annonces["titre_annonce"];
               $this->prix= $annonces['prix_annonce'];
               $this->desc= $annonces['desc_annonce'];
               $this->date= $annonces['date_annonce'];

               $this->cat= $annonces['cat_annonce'];
               $this->map= $annonces['map_annonce'];
               $this->debat= $annonces['debat_annonce'];
               $this->affiche_tel= $annonces['affiche_tel'];
               $this->affiche_adresse= $annonces['affiche_adresse'];
               $this->etat= $annonces['etat_annonce'];
               $this->photos= $annonces['photos_annonce'];
            
               $this->id_user= $annonces['id_user'];
               $this->prenom_user= $annonces['prenom_user'];
               $this->adresse_user= $annonces['adresse_user'];
               $this->ville_user= $annonces['ville_user'];
               $this->dep_user= $annonces['dep_user'];
               $this->region_user= $annonces['region_user']; 
               $this->tel_user= $annonces['tel_user'];
               $this->mail_user= $annonces['mail_user'];
                           
             if(isset($annonces['cat_annonce']) && $annonces['cat_annonce']==1){
                 $chaine2= "SELECT *
                            FROM cat_auto
                            where cat_auto.id_auto=".$ref;  
							
				$req2 = mysqli_query($this->link, $chaine2); //depuis php5.3
				while ($data = mysqli_fetch_assoc($req2)){
					$auto = $data;
				}
            
               $this->annee = $auto['annee_annonce'];
               $this->km = $auto['km_annonce'];
               $this->energie = $auto['energie_annonce'];
               $this->boite = $auto['boite_annonce'];    
             }
		}
       //return $annonces;
	}
	   
	   
	//fonction qui supprime une annonces, et les photos liées
	function supprimer_annonce(){
		$tab = Array();

		$chaine="DELETE FROM ANNONCES WHERE ANNONCES.id_annonce ='".$this->id."'";
		$req = mysqli_query($this->link,$chaine);
		$cat = $tab['infos']['cat_annonce'];

		// si c'est ds la categorie auto, on supprime les champs de la table cat_auto
		if($cat == 1 ){
			$chaine2="DELETE FROM cat_auto WHERE cat_auto.id_auto ='".$this->id."'";
			$req2= mysqli_query($this->link,$chaine2);
		}
		// s'il ya des photos, on supprime
		$chemin = dirname(__FILE__).'/../upload/'.$this->id.'/';
		if(is_dir($chemin))	
			Annonce::sup_repertoire($chemin);
		
	}  


	public static function sup_repertoire($chemin) {
		if ($chemin[strlen($chemin)-1] != '/')
			$chemin .= '/';

		if (is_dir($chemin)) {
			$sq = opendir($chemin); // lecture
			while ($f = readdir($sq)) {
				if ($f != '.' && $f != '..'){
					$fichier = $chemin.$f; // chemin fichier
					if (is_dir($fichier))	
						sup_repertoire($fichier);
					else 	
						unlink($fichier);
				}
			}
			closedir($sq);
			rmdir($chemin); // sup le répertoire
		}
		else unlink($chemin);  // sup le fichier
	}

	
	
	public function creerMiniature($dossier,$fichier)
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


	public function redimensionner($dossier,$fichier)
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

	public function verifPhotos($photos){ // renvoi true si c ok, false sinon;
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

	public function envoiPhoto($dossier,$photo){
		$fichier = $photo['name'];
		$fichier = strtr($fichier,  'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
		$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
		
		if($fichier != ""){
			$chemin_fichier = $dossier.$fichier;
			$valid1 = move_uploaded_file($photo['tmp_name'], $chemin_fichier);
			$this->redimensionner($dossier,$fichier);
			$this->creerMiniature($dossier,$fichier);
			return true;
		}
		else
			return false;
	}




	function deposer_annonce(){
		$date_annonce = date('Y\-m\-d H:i:s');	
		$chaine4 = "SELECT id_annonce  
				FROM ANNONCES
				WHERE ANNONCES.id_user = '".$this->id_user."'
				AND ANNONCES.titre_annonce = '".$this->titre."'
				AND ANNONCES.desc_annonce = '".$this->desc."'
				AND ANNONCES.cat_annonce = '".$this->cat."'
				";
		
		$req4 = mysqli_query($this->link, $chaine4);
		$num_req4 = mysqli_num_rows($req4);
		//Verifie si l'annonce a deja été créé
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
		
		if( $this->verifPhotos($photos) == 1 )
		{
			// On insere ds la table
			$chaine = "INSERT INTO `ANNONCES` (`id_annonce`, `id_user`, `titre_annonce`, `desc_annonce`, `cat_annonce`, `prix_annonce`, `date_annonce`, `map_annonce`, `debat_annonce` , `etat_annonce`, `affiche_adresse` , `affiche_tel`)
			VALUES (NULL, '".$this->id_user."', '".$this->titre."', '".$this->desc."', '".$this->cat."', '".$this->prix."', '".$this->date."', '".$this->map."', '".$this->debat."' , 'en attente', '".$this->affiche_adresse."', '".$this->affiche_tel."')";	
			$req = mysqli_query($this->link,$chaine);
			if( $req == true )
			{
				$tab['reponse'] = 1;
				$tab['id_annonce'] = mysqli_insert_id($this->link);
				$tab['titre_annonce'] = $this->titre;
				$tab['desc_annonce'] = $this->desc;
				$tab['cat_annonce'] = $this->cat;
				$tab['prix_annonce'] = $this->prix;
				$tab['date_annonce'] = $this->date;
				$tab['map_annonce'] = $this->map;
				$tab['debat_annonce'] = $this->debat;
				
				$chaine2 = "SELECT id_annonce 
				FROM ANNONCES
				WHERE ANNONCES.id_user = '".$this->id_user."'
				AND ANNONCES.titre_annonce = '".$this->titre."'
				AND ANNONCES.desc_annonce = '".$this->desc."'
				AND ANNONCES.cat_annonce = '".$this->cat."'
				AND ANNONCES.date_annonce = '".$this->date."'
				AND ANNONCES.map_annonce = '".$this->map."'
				AND ANNONCES.debat_annonce = '".$this->debat."'
				";
				
				$req2 = mysqli_query($this->link,$chaine2);
				$res = Array();
				while ($data = mysqli_fetch_assoc($req2))
				{
					$res['annonce'] = $data;
				}
				$id_annonce = $res['annonce']['id_annonce'];
				$this->id =	$id_annonce;		
				
				if($this->cat == 1 ){
					$chaine3 = "INSERT INTO `cat_auto` (`id_auto` ,`annee_annonce` ,`km_annonce` ,`energie_annonce` ,`boite_annonce`)
								VALUES ('".$id_annonce."', '".$this->annee."', '".$this->km."', '".$this->energie."', '".$this->boite."');";
					$req3 = mysqli_query($this->link,$chaine3);
					
					$tab['annee_annonce'] = $this->annee;
					$tab['km_annonce'] = $this->km;
					$tab['energie_annonce'] = $this->energie;
					$tab['boite_annonce'] = $this->boite;
				}
				

				
				$chaine_chemins = "";
				$valid = true;
				
				if( !empty($photos))
				{
					/*Envoi de photos*/
					$dossier = 'upload/'.$id_annonce.'/';
					mkdir($dossier, 0777, true);
					
					foreach($photos as $p){
						$valid = $valid && $this->envoiPhoto($dossier,$p);
						if($valid)
							$chaine_chemins = $chaine_chemins.$dossier.preg_replace('/([^.a-z0-9]+)/i', '-', $p['name']).';';
					}

				}

				if($valid)
				{	
					$chaine3="UPDATE ANNONCES
					SET ANNONCES.photos_annonce = '".$chaine_chemins."'
					WHERE ANNONCES.id_annonce = ".$id_annonce;
					$req3 = mysqli_query($this->link,$chaine3);
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
			if( $this->verifPhotosverifPhotos($photos) == 2 )	$tab['reponse'] = 2;
			if( $this->verifPhotosverifPhotos($photos) == 3 )	$tab['reponse'] = 3;
		}

		return $tab;
	}





	
	   
	   
}   
?>