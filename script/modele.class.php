<?php
  
  class Url { 
    public $url = "";  
    public $mots_a_enlever=array("alors","a","aux","au","aucuns","aussi","autre","avant","avec","bon","ca","car","ce","cela","ces","ceux","chaque","comme","dans","des","du","dedans","dehors","depuis","deux","devrait","doit","donc","dos","elle","elles","est","eu","et","en","fait","faites","fois","font","hors","ici","il","ils","je","juste","l","la","le","les","leur","leurs","ma","mes","maintenant","mais","mon","mot","meme","ni","nos","notre","nous","que","qui","ou","par","pour","parce","pas","sa","sans","ses","si","sien","son","tous","tout","trop","tu","ta","un","une","votre","vos","vous","vu"); //Liste des stop words
          
    public function __construct($lien)
    {
      $this->url = $lien;
    }
    
    public function affiche(){
      echo "<br/>Je suis un objet Url avec un lien &eacute;tant : ".$this->url;  
    }
    
    /** Renvoi le basename sans extension d'une url **/
    public function last(){
      $info = pathinfo($this->url);
	  if(isset($info['extension']))
      	$res =  basename($this->url,'.'.$info['extension']);
	  else
	    $res =  basename($this->url);
		
      if(strlen($res) <= 3 || dirname($this->url)=="http:"){
        return "";
      }
      else  
        return $res;
    }
    
    
    /** pour un texte etant a-b-c  renvoie le tableau [a, b, c, ab, abc] **/
    public function renvoie_mots(){
      $mots=array();
      $explod = ( explode("-", strtolower ($this->url)));
      $chaine = "";
      
      /** Initialise la chaine avec le premier mots s'il n'est pas un stop words **/
      if(!in_array($explod[0], $this->mots_a_enlever) && strlen($explod[0]) >= 3){
        $chaine = $explod[0];
        $mots[] = $explod[0];
      }

      /** Traite chaque mot supplémentaires **/
      for($i=1; $i< sizeof($explod); $i++){
        if(!in_array($explod[$i], $this->mots_a_enlever) && strlen($explod[$i]) >= 3){
          $mots[] = $explod[$i]; // recupération du mot actuel
		  	if( $chaine != ""){
				$chaine .= '-';
			}

          $chaine .= $explod[$i]; // recupération de la suite des mots
          $mots[] = $chaine;
        }
      }

      return($mots);
    }
    
  }
    
    
  
  class Csv {
   public $fichier = "";
    
   public function __construct($url_fichier){
    $this->fichier = $url_fichier;
   }
  
  
    /** Renvoie un tableau de mots_clefs d'un fichier contenant des urls **/
    function renvoie_mots_clefs( $separ=";")
    {
      $mots_clefs=array();
      $fic = fopen($this->fichier, "a+"); // ouverture du fichier
      while($tab=fgetcsv($fic,1024,';'))
      {
        foreach($tab as $t)
        {
          $t2 = new Url(strtolower($t));
          $last = new Url($t2->last());
          $mots = $last->renvoie_mots();
          $tmp = $mots;
          if($tmp != ""){
              $mots_clefs = array_merge($mots_clefs,$tmp);  
          }            
          
        }
      }
      $mots_clefs_standards = array();
      //$mots_clefs_standards = array("courrier","colis","suivi","aide","annuaire","lettres","remboursement-d-un-credit","paiement-du-loyer","travaux","particuliers","securite","international","france","mobile","accuse-de-reception","timbres","envoyer");
      $mots_clefs_avec_les_standards = array_merge($mots_clefs, $mots_clefs_standards);
      $mots_clefs_dedoublonnes = array_unique($mots_clefs_avec_les_standards);
      return $mots_clefs_dedoublonnes;
    }
    
    /** cherche un mot dans les urls contenues dans la colonne 1 d'un fichier csv **/
    function cherche($mot,$separ=";")
    {
      $chaine = array();
      $nb_match = 0;
      
      $fic = fopen($this->fichier, "a+"); // ouverture du fichier
      while($tab=fgetcsv($fic,1024,';'))
      {
        // pour chaque ligne du csv
        foreach($tab as $t)
        {
          /** cherche le mot dans la ligne **/
          $mot_petit = strtolower($mot); // on compare des minuscules
          $explod = (explode("-", $mot_petit));
          $result = true;
		   
          foreach($explod as $e){
            if( ($e !="") && (strpos(strtolower($t),strtolower($e)) !== false) ){
              $result = $result && true;
            	$nb_mots_trouves++;
			}else
              $result = $result && false;
          }
          if($result == true){
            $chaine[] = $t; //On ajoute la ligne qui matche
            $nb_match++;
          }
          
        }
      }
      array_unshift($chaine, $mot, $nb_match); //placer devant le tableau le mot et le  nb de fois ou ca a matché
      return $chaine;
    }
	
	/** cherche un mot dans les urls contenues dans la colonne 1 d'un fichier csv **/
    function cherche_avec_score($mot, $score_min=1 ,$separ=";")
    {
      $chaine = array();
      $nb_match = 0;
      
      $fic = fopen($this->fichier, "a+"); // ouverture du fichier
      while($tab=fgetcsv($fic,1024,';'))
      {
        // pour chaque ligne du csv
        foreach($tab as $t)
        {
          /** cherche le mot dans la ligne **/
          $mot_petit = strtolower($mot); // on compare des minuscules
          $explod = (explode("-", $mot_petit));
          $result = true;
		   $nb_mots_trouves = 0;
          foreach($explod as $e){
            if( ($e !="") && (strpos(strtolower($t),$e) !== false) ){
              $result = $result && true;
            	$nb_mots_trouves++;
			}else
              $result = $result && false;
          }
		   $score_mot = $nb_mots_trouves/count($explod);

          if($score_mot >= $score_min){
            $chaine[] = $t; //On ajoute la ligne qui matche
            $nb_match++;
			  //echo "</br>---------</br>Mots trouves : $nb_mots_trouves / " . count($explod)." => $score_mot";
          }
          
        }
      }
      array_unshift($chaine, $mot, $nb_match); //placer devant le tableau le mot et le  nb de fois ou ca a matché
      return $chaine;
    }
	
	


   /** Fonction de démarrage du traitement prenant en parametre les urls des 2 fichiers d'entrée **/
    function start($fichier_sous_domaine, $score=1){
	  $fic2 = new Csv($fichier_sous_domaine);
      $tabmots = $this->renvoie_mots_clefs();
      //var_dump($tabmots);
      echo "Nombre de mots cl&eacute;s r&eacute;cup&eacute;r&eacute;s = ".count($tabmots);
	  if(count($tabmots) == 0)
	  	echo "<br/><h2>Aucun mots cl&eacute;s trouv&eacute;s </h2>V&eacute;rifiez que le fichier en poss&egrave;de et v&eacute;rifiez que le fichier est au format <b>Windows avec s&eacute;parateur point-virgule</b>";
  
      $name_file_out ='file_out_'.date("Y-m-d_H-i-s").'.csv';
      $fp = fopen($name_file_out, 'w+');
      $delimiteur = ';';
      $n = 0;
      
      // pour chaque mot clé on va parcourir chaque ligne du fichier 2
	  $arr2 = array();//pour hypertree 
	  $arr_circle = array();//pour hypertree 
      foreach($tabmots as $mot){
        $n ++;
        //$csv = $fic2->cherche($mot);
		 $csv = $fic2->cherche_avec_score($mot,$score);
        echo "	<br/><br/>
          		$n : <span style='color:red'><b>$mot</b></span> : 
            	<br/>Nb liens trouv&eacute;s : <span style='color:blue'>".(count($csv)-2)."</span>";
          
        // print_r($csv);
		 $urls = array();
        for($i=2;$i<count($csv);$i++){
          echo "<br/>&emsp;&emsp;&emsp; ".$csv[$i];
		   $urls[] = array('id'=>$mot.$i,'name'=>$csv[$i]);  //pour tous les graph       
        }
        fputcsv($fp, $csv, $delimiteur);
		/* a la fin d'un mot */ 
		 $arr2[] 		= array('id'=>$n,'name'=>$mot,'children'=>$urls) ;//pour tous les graph 
		 
		 $arr_circle[] = array('name'=> $mot, 'size'=> count($csv)-2);//pour le graph4
      }
	  	/* apres tous les mots */
		$fin = array('id'=>0,'name'=>"START","children" =>$arr2 );//pour tous les graph 
      	$arr_json = json_encode($fin);//pour tous les graph 
		
		$fin_circle = array('name'=>"START","children" =>$arr_circle );//pour le graph4
      	$arr_json_circle = json_encode($fin_circle);//pour le graph4

	   ?>
		 <script>
		 	var json 					= <?php echo $arr_json; ?>;//pour hypertree
			var json_collapsible_tree	= <?php echo $arr_json; ?>;//pour graph2 
			var json_indented_tree 	= <?php echo $arr_json; ?>;//pour graph3
			var json_circle_packing 	= <?php echo $arr_json_circle; ?>;//pour graph4
		 </script>
        <?php
      fclose($fp);
	  ?>

			<!-- Boite flottante de resultat de traitement  -->
	  		<div style='position:fixed;z-index:999;float:right;top:1px;right:1px;border:4px solid green;border-radius:10px;background-color:#CCC;padding:3px'>
				<div id="choix-affi" onclick="if ($('#bulle').is(':hidden')) { $('#bulle').slideDown();$('#choix-affi').empty();$('#choix-affi').append('Reduire')} else { $('#bulle').slideUp();$('#choix-affi').empty();$('#choix-affi').append('Afficher')}" style="cursor:pointer;padding:5px;float:right">
					Reduire
				</div>
                
              <div id='bulle' style="display:block;width:280px;min-height:60px;background-color:#CCC;float:left">
					<span style="font-size:17px;margin:0 0 10px 0;"/><b>Le traitement est termin&eacute;</b></span><br/>
					Fichier cr&eacute;&eacute;: <?php echo $name_file_out ?><br/>
					<a href=<?php echo "'./$name_file_out'" ?> align=center>T&eacute;l&eacute;charger le</a>
				</div>
				
				
			</div>
           <script>
				$('#loader').css('display','none'); // Fin de defilement du Loader
			</script>
      <?php  
    }

      

  }      
?>
