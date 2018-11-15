<?php
  
class Annonces{
	public $link;

	public function __construct(){
		$this->link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
	}
	
	public $annonces = array();

    
	public function recuperer_annonces($categorie, $region, $mot, $prixmin, $prixmax, $debat, $annee_min, $annee_max, $km_min, $km_max, $tri=0, $nba=20){
		$annos = array();
		$tables = "";

		/* Definition des tables où chercher */
		if($categorie == "1")
			$tables = $tables.",cat_auto";  

		$chaine="	SELECT distinct *
					FROM ANNONCES,USERS".$tables."
					where ANNONCES.id_user=USERS.id_user";

		/* Definitions des conditions where ... */
		if($mot != "Entrez votre recherche" && $mot != "")
			$chaine = $chaine." and (ANNONCES.titre_annonce LIKE '%".$mot."%' or ANNONCES.desc_annonce LIKE '%".$mot."%')";

		if($prixmin != "--" && $prixmin != "")
			$chaine = $chaine." and ANNONCES.prix_annonce >= ".$prixmin;

		if($prixmax != "--" && $prixmax != "")
			$chaine = $chaine." and ANNONCES.prix_annonce <= ".$prixmax;

		if($debat == "on")
			$chaine = $chaine." and ANNONCES.debat_annonce = '".$debat_annonce."'";

		if($categorie != "--" && $categorie != "")
			$chaine = $chaine." and ANNONCES.cat_annonce = ".$categorie;

		if($categorie == "1"){
			$chaine = $chaine." and ANNONCES.id_annonce=cat_auto.id_auto";
		  if($annee_min != "--" && $annee_min != "")
			$chaine = $chaine." and cat_auto.annee_annonce >= ".$annee_min;

		  $chaine = $chaine." and ANNONCES.id_annonce=cat_auto.id_auto";
		  if($annee_max != "--" && $annee_max != "")
			$chaine = $chaine." and cat_auto.annee_annonce <= ".$annee_max;

		  $chaine = $chaine." and ANNONCES.id_annonce=cat_auto.id_auto";
		  if($km_min != "--" && $km_min != "")
			$chaine = $chaine." and cat_auto.km_annonce >= ".$km_min;

		  $chaine = $chaine." and ANNONCES.id_annonce=cat_auto.id_auto";
		  if($km_max != "--" && $km_max != "")
			$chaine = $chaine." and cat_auto.km_annonce <= ".$km_max;
		}

		if($region != "--" && $region != "")
			$chaine = $chaine." and USERS.region_user = ".$region;

		$chaine = $chaine . " and ANNONCES.etat_annonce = 'validee' ";

		if($tri == 0)
			$chaine = $chaine." ORDER BY ANNONCES.date_annonce DESC";
		if($tri == 1)
			$chaine = $chaine." ORDER BY ANNONCES.date_annonce ASC";    
		if($tri == 2)
			$chaine = $chaine." ORDER BY ANNONCES.prix_annonce ASC";
		if($tri == 3)
			$chaine = $chaine." ORDER BY ANNONCES.prix_annonce DESC";

		$req = mysqli_query($this->link, $chaine);
        
		while ($data = mysqli_fetch_assoc($req)){
			$annos[] = $data;
		}

		foreach($annos as $a){
			$annonce = new Annonce();
			$annonce->init($a['id_annonce'],$a['titre_annonce'],$a['prix_annonce'],$a['desc_annonce'],$a['date_annonce'],$a['cat_annonce'],$a['map_annonce'],$a['debat_annonce'],$a['affiche_tel'],$a['affiche_adresse'],$a['etat_annonce'],$a['photos_annonce'],$a['id_user'],$a['prenom_user'],$a['adresse_user'],$a['ville_user'],$a['dep_user'],$a['region_user'],$a['tel_user'],$a['mail_user']);
			$this->annonces[] = $annonce;            
		}

		return $this->annonces;
  }
  
	//Cree le sitemap en fonctions des annonces existantes en base de donnees
	public function creerSitemap(){
		$this->recuperer_annonces("", "", "", "", "", "", "", "", "", "", 0);
		$chaine= '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc>http://www.prixdupro.fr/</loc>
		<changefreq>weekly</changefreq>
		<priority>1</priority>
	</url>

	<url>
		<loc>http://www.prixdupro.fr/france/informatique</loc>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url>

	<url>
		<loc>http://www.prixdupro.fr/ile-de-france</loc>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url>

	<url>
		<loc>http://www.prixdupro.fr/ile-de-france/informatique</loc>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url>	 
		 ';

		foreach ($this->annonces as $a){
			$chaine.='
	<url>
		<loc>http://www.prixdupro.fr/annonce/'.$a->id.'</loc>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url> 
		';
		}	
		$chaine.='
</urlset>';

		$file ="../sitemap.xml";
		$fileopen=(fopen("$file",'w'));
		fwrite($fileopen,$chaine);
		fclose($fileopen);
		echo "La création du fichier $file a reussi";
	}
	
	//Nettoie de manière logique toutes les annonces de plus de 10 mois
	function nettoyer_annonces_anciennes(){
		$date_now = date('Y\-m\-d H:i:s');
		$date_12mois_avant = date('Y\-m\-d H:i:s', strtotime('-12 month'));
		$annonces = array();
		
		$chaine = "SELECT distinct titre_annonce, id_annonce , date_annonce
			FROM ANNONCES
			WHERE '".$date_10mois_avant."'  > ANNONCES.date_annonce";
			
		$req = mysqli_query($this->link, $chaine);
		while ($data = mysqli_fetch_assoc($req))
			$annonces[] = $data;
			
		echo '<br> On supprime les annonces suivantes :';
		
		foreach($annonces as $a){
		  echo '<br> annonce numero :'.$a['id_annonce'];
		  expirer_annonce_script($a['id_annonce']);
		}
		
	}	
	
	//Met le statut d'une annonce a l'etat expiree
	function expirer_annonce($ref){ 
		$chaine="UPDATE ANNONCES set etat_annonce = 'expiree'
		WHERE ANNONCES.id_annonce ='".$ref."'";
		$req = mysqli_query($this->link, $chaine);
	}
	
	//Met le statut d'une annonce a l'etat validee
	function valider_annonce($ref){
		$chaine="UPDATE ANNONCES set etat_annonce = 'validee'
		WHERE ANNONCES.id_annonce ='".$ref."'";
		$req = mysqli_query($this->link, $chaine);
	}
  
	//Met le statut d'une annonce a l'etat en attente
	function mettre_en_attente_annonce($ref){
		$chaine="UPDATE ANNONCES set etat_annonce = 'en attente'
		WHERE ANNONCES.id_annonce ='".$ref."'";
		$req = mysqli_query($this->link, $chaine2);
	}

}    
  
?>
