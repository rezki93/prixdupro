<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xml:lang="fr-FR">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Annonce <?php if(isset($annonce->id))  echo $annonce->titre ?> - Prixdupro</title>
		<meta name="robots" content=<?php if($annonce->etat == "validee") echo '"index, follow"'; else echo '"noindex, nofollow"'; ?> />
		<meta name="Description" content=<?php echo "'".htmlentities($annonce->desc, ENT_NOQUOTES)."'" ?> />
		
		<meta name="twitter:card" content="summary"/>
		<meta name="twitter:site" content="@rezki93"/>
		<meta name="twitter:title" content=<?php if(isset($annonce->titre))  echo "\"".$annonce->titre."\""; ?> />
		<meta name="twitter:description" content=<?php if(isset($annonce->desc))  echo "\"".substr(htmlentities($annonce->desc),0,199)." ...\""; ?> />
		<meta name="twitter:image" content=<?php if(isset($annonce->photos))  echo "\"".$annonce->photos."\""; ?> />

		<?php include(dirname(__FILE__).'/../vues/head.php');	?>
		<link type="text/css" href="<?php echo RACINE; ?>css/annonce.css" rel="stylesheet" />  
		<script type="text/javascript" src="http://gettopup.com/releases/latest/top_up-min.js"></script>
	</head>
  
	<body>
		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-M39RRF"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-M39RRF');</script>
		<!-- End Google Tag Manager -->
		<?php
		$smarty->display('templates/banniere.tpl');
		$categories = array(1  => 'auto', 2 => 'moto', 3 => 'caravaning',4 => 'utilitaires',5 => 'equipement-auto',6 => 'equipement-moto',7 => 'equipement-caravaning',8 => 'image-son',9 => 'informatique',
							10  => 'consoles-jeux-video', 11  => 'telephonie', 12 => 'immobilier', 13 => 'ameublement',14 => 'electromenager',15 => 'bricolage-jardinage',16 => 'vetements',17 => 'accessoires-bagagerie',18 => 'montres-bijoux',19 => 'equipement-bebe', 
							20  => 'dvd', 21  => 'cd', 22 => 'blueray', 23 => 'livres',24 => 'animaux',25 => 'sports-hobbies',26 => 'collection',27 => 'jeux-jouets',28 => 'vins-gastronomie',29 => 'billeterie',
							30  => 'evenements', 31  => 'services', 32 => 'emplois', 33 => 'cours-particuliers',34 => 'recherche',35 => 'autre'
							);
      
		if(isset($annonce->id))
		{   
			$ojd = date('m\-d');$hier = date('m\-d',strtotime('-1 day'));$jour_annonce = substr($annonce->date,5,5);$heure_annonce = substr($annonce->date,11,5); 
			if($ojd == $jour_annonce)$jour = "Aujourd'hui";
			else if($hier == $jour_annonce)$jour = "Hier";
			else $h = explode("-", $jour_annonce);$moi = $h[0]; $jou = $h[1];$jour = 'le '.$jou.'/'.$moi;
			
		?>
		<div id="principal-annonce" class="ui-widget-content" style="">
			<div id="bloc-titre-annonce" style="">
				<div style=""  itemscope itemtype="http://schema.org/Product">
					<div style="">
						<h1 id="titre-annonce" style="">
						<?php 
						echo '<span itemprop="name"> '.$annonce->titre.'</span>'; 
						$explod = (explode(";", $annonce->photos));
						if(!empty($annonce->photos))
						   echo '<span itemprop="image" content="'.$_SERVER['SERVER_NAME'] . DIRECTORY_SEPARATOR . $explod[0].'"/>'; 
						?>
						- <span itemprop="category"> <?php echo '<i>'.$categories[$annonce->cat] .'</i>'; ?> </span>
						</h1>
					</div>	   
					<div style="" itemprop='offers' itemscope itemtype="http://schema.org/Offer">
						<h2 id="prix-annonce" style="">
							<span itemprop='price'><?php echo $annonce->prix;  ?></span>&#8364;
							<?php 
							if($annonce->debat == 'on')
								echo '(à débattre) ';
							?>

						</h2>
					   <meta itemprop="priceCurrency" content="EUR"/>
					   <meta itemprop="seller" content=<?php echo '"'.$annonce->prenom_user.'"'; ?>/>   
					</div>
				</div>
			</div> 
			  
			<div id="infos-annonceurs" style="">
				<img src="<?php echo RACINE?>images/report_user.png" style="float:left;"/>
				<span id="bluetitle" style="">Informations annonceur</span>
				<div class="clear"></div>
				<div class="" style="margin-top:0px;">Date de parution : <span class="text bold"><?php echo $jour.' à '.$heure_annonce ?></span></div>
				<div class="" style="margin-top:5px;">Ville et departement : <span class="text bold"><?php echo $annonce->ville_user.' '.$annonce->dep_user?></span></div>
				<div class="" style="margin-top:5px;">Annonceur : <span class="text bold"><?php echo $annonce->prenom_user?></span></div>
				<?php
				if($annonce->affiche_tel== "on")
				  echo '
					   <div class="text" style="20px;margin-top:5px;width:270px">Telephone : <span class="text blue bold">'.$annonce->tel_user.'</span></div>
				  ';
				if(isset($_SESSION['con_id'])){
					echo '<div id="bloc-fav" onclick="ajout_favoris('.$_SESSION['con_id'].','.$annonce->id.')">
						  <div class="text"> Ajouter à vos favoris :
							<img src="'.RACINE.'images/etoile.png" style="margin-left:20px">
						  </div>
						</div>
					  ';
				} 
				?> 
			</div>
			  
			  <div class="clear"></div>                         
			
		<?php              
			if($annonce->photos != ""){
			  $photos = (explode(";", $annonce->photos,-1));
			?>
			  <div id="bloc-photos-annonce" style="">
				<ul class="jcarousel-skin-tango">
				  <?php
				foreach($photos as $p) {  
				  $chemin_photo = pathinfo($p);
				  echo '
					<li style="float:left; margin-right:10px;">
					  <a href="'.RACINE.$chemin_photo['dirname'].'/'.$chemin_photo['basename'].'" class="top_up" toptions="effect = clip, overlayClose = 1,resizable =1,layout = quicklook">
						<img class="images-annonce" itemprop="image" src="'.RACINE.$chemin_photo['dirname'].DIRECTORY_SEPARATOR.$chemin_photo['basename'].'" alt="'.$annonce->titre.'" style="" />
					  </a>
																								 
					  
					  <script type="text/javascript">
						TopUp.addPresets({
						".jcarousel-skin-tango li a": {
						  title: "Image {alt} ({current} sur {total})",
						  group: "examples",
						  readAltText: 1,
						}
						});
																																		
					   TopUp.host = "http://www.prixdupro.fr/";                                                                                                                 
					   TopUp.players_path = "/images ";
					  </script>
					  
					</li>                                                                                     
					';
				}
			  ?>
				  <meta name="twitter:image" content=<?php if(isset($chemin_photo)) echo $_SERVER['SERVER_NAME'] . $chemin_photo['dirname'].DIRECTORY_SEPARATOR.$chemin_photo['basename']; ?> >
		<?php          
			echo '    </ul>
			  
				</div>
			  <div class="clear"></div>
			  <div>
				   <br>
			  <img src="'.RACINE.'images/agrandir.png" style="float:left;"/>
			  <span style="float:left;margin: 6px 0 0 10px;color:grey;font-size:11px;">Cliquez sur une photo pour l\'agrandir </span>
			  </div>
			';  
			}
		?>


			<div class="clear"></div>

			<?php
				if($annonce->cat==1){
				  echo '  
					<div style="">
					  <div class="text bold" style="float:left;">Annee : <span class="green">'.$annonce->annee.'</span></div>
					  <div class="text bold" style="float:left;margin-left:20px;">Kilometrage : <span class="green">'.$annonce->km.'</span></div>
					  <div class="text bold" style="float:left;margin-left:20px;">Energie : <span class="green">'.$annonce->energie.'</span></div>
					  <div class="text bold" style="float:left;margin-left:20px;">Boite : <span class="green">'.$annonce->boite.'</span></div>
					</div>
				  ';
				}
			
			

		   ?>     
		 
				  
			<div id="bloc-desc-annonce" class="text blue bold" ><?php echo $annonce->desc ?></div>
				  
			<div id="bloc-contact-user" style="">
			  <div id="envoi-message" style="">
				
				<form method="POST" name="envoi_message" enctype="multipart/form-data" action="/envoyer_message">
				  <div style="cursor:pointer" onclick="if ($('#bloc-msg').is(':hidden')) { $('#bloc-msg').slideDown();} else $('#bloc-msg').slideUp()" > 
					<img id="logoMessage" src="<?php echo RACINE; ?>images/mail.png"/>
					<span id="titre-bloc-msg" class="blue" style="" >Contactez l'annonceur</span>
				  </div>
				  <div class="clear"></div>
				  <div id="bloc-msg" style="display:none">
					<div style="float:left;margin: 0px 0 0 10px;">
					  <div style="float:left;margin: 3px;width:80px">Votre nom :</div>
					  <input type="text" class="" style="width:200px;" maxlength="30" id="sender_name" name="sender_name"  />
					</div>

					<div style="float:left;margin: 0 0 0 10px;">
					  <div style="float:left;margin: 3px;width:80px">Votre email:</div>
					  <input type="text" class="" style="width:200px;" id="sender_email" name="sender_email" />
					</div>

					<div style="float:left;margin: 0 0 0 10px;">
					  <div style="float:left;margin: 3px;width:80px">Votre telephone: (facultatif)</div>
					  <input type="text" class="" style="width:200px;" id="sender_tel" name="sender_tel" />
					</div>

					<div style="float:left;margin: 0 0 0 10px;">
					  <div style="float:left;margin: 3px;width:80px">Votre message :</div>
					  <div style="float:left">
						<TEXTAREA class="" style="width: 200px;" rows="2" cols="12" maxlength="200" id="sender_msg" name="sender_msg" onkeyup="this.value = this.value.substr(0,200);" ></TEXTAREA>
					  </div>
					</div>
			  <?php
		  echo '
					<input type="hidden" name="destinataire_msg" value="'.$annonce->mail_user.'" />
					<input type="hidden" name="ref_annonce" value="'.$annonce->id.'" />
					<div class="blue-button2" id="envoyer_message" name="envoyer_message" style="float:right;margin:5 13 5 0px;">Envoyer</div>  
				  </div>
				</form>
			  </div>
			</div>
			';

			  if($annonce->map == "on")
			  {

			  ?>  
				<div class="clear"></div>
				
				<div id="google-map" style="">
					<div id="bloc-nom-maps" style="">
						<img style="" src="<?php echo RACINE;?>images/localisation.png"  width="50"/>
						<span style="margin:15px;font-size:22px">Localisez l'annonce</span>
					</div>

					<div id="global" onunload="GUnload()" style="">      
				<?php
				
				$adresse_user = "";
				if($annonce->affiche_adresse == "on")
				  $adresse_user = $annonce->adresse_user.' '.$annonce->ville_user.' '.$annonce->dep_user;
				else
				  $adresse_user = $annonce->ville_user.' '.$annonce->dep_user;
				?>
		   
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBS8jlviXT8-I6OXgie2avxcF5t4AjfUF0&sensor=true&language=fr"></script>

				 
		<div id="container">
		  <div id="destinationForm">
			<form action="" method="get" name="direction" id="direction" style="margin-bottom: 0;">
			  <div style="float: left;width: 100%;">
				<label>Départ de</label>
				<input type="text" name="origin" id="origin" style="width:75%;float:right;">
			  </div>
			  
			  <br/>
			  <div style="float: left;clear:both;width: 100%;">
				<label>Destination</label>
				<input type="text" name="destination" id="destination" style="width:75%;float:right;" value="<?php echo $adresse_user ?>">
			  </div>
			  
			  <br/>
			  <input type="button" style="float:right" value="Calculer l'itinéraire" onclick="javascript:calculate()">
			  <div class="clear"></div>
			</form>
		  </div>
		  
		  <div id="map">
			<p>Veuillez patienter pendant le chargement de la carte...</p>
		  </div>
		  <div id="panel"></div>
		</div>


		<script type="text/javascript">
		var map;var panel;var initialize;var calculate;var direction;
		initialize = function(){
		  geocoder = new google.maps.Geocoder();
		  var latLng = new google.maps.LatLng(48.8566667, 2.3509871); // Correspond au coordonnées de Paris
		  var myOptions = {
			zoom      : 12, // Zoom par défaut
			//center    : latLng, // Coordonnées de départ de la carte de type latLng 
			mapTypeId : google.maps.MapTypeId.ROADMAP, // Type de carte, différentes valeurs possible HYBRID, ROADMAP, SATELLITE, TERRAIN
			maxZoom   : 20
		  };
		  
		  map      = new google.maps.Map(document.getElementById('map'), myOptions);
		  panel    = document.getElementById('panel');
		  
		  direction = new google.maps.DirectionsRenderer({
			map   : map,
			panel : panel // Dom element pour afficher les instructions d'itinéraire
		  });

		};

		calculate = function(){
			origin      = document.getElementById('origin').value; // Le point départ
			destination = document.getElementById('destination').value; // Le point d'arrivé
			if(origin && destination){
				var request = {
					origin      : origin,
					destination : destination,
					travelMode  : google.maps.DirectionsTravelMode.DRIVING // Mode de conduite
				}
				var directionsService = new google.maps.DirectionsService(); // Service de calcul d'itinéraire
				directionsService.route(request, function(response, status){ // Envoie de la requête pour calculer le parcours
					if(status == google.maps.DirectionsStatus.OK){
						direction.setDirections(response); // Trace l'itinéraire sur la carte et les différentes étapes du parcours
					}
				});
			}
		};
		  
		function codeAddress() {
		  var address = "<?php echo $adresse_user ?>";
		  geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
			  
			  map.setCenter(results[0].geometry.location);
			  var marker = new google.maps.Marker({
				  map: map,
				  position: results[0].geometry.location,
				  title    : "<?php echo $annonce->prenom_user; ?>"
			  });
			 
				
			  var contentMarker = ['<?php echo $annonce->titre .'<br/>Prix : '. $annonce->prix .' euros'; ?>'].join('');
			  var infoWindow = new google.maps.InfoWindow({
				content  : contentMarker,
				position : results[0].geometry.location
			  });
			
			  google.maps.event.addListener(marker, 'click', function() {
				infoWindow.open(map,marker);
			  });
			  
			  google.maps.event.addListener(infoWindow, 'domready', function(){ // infoWindow est biensûr notre info-bulle
				jQuery("#tabs").tabs();
			  });
			} else {
			  alert('Geocode was not successful for the following reason: ' + status);
			}
		  });
		}

		  initialize(); //Initialise un plan google map vierge
		  codeAddress(); //specifie le plan google map a la destination

		</script>


			</div>  
		</div>


		<!-- Module Facebook -->
		  <div id="module-facebook" >
				 <div id="bloc-nom-facebook" style="">
					   <img style="float:left" src="<?php echo RACINE; ?>images/facebook.png"  width="40"/>
					  <span style="float:left;margin:10px 0 0 20px;font-size:22px">Commentez l'annonce</span>
				 </div>
		  
		 
			  <script src="http://connect.facebook.net/fr_FR/all.js#xfbml=1"></script> 
		<?php
		echo "        
		  <fb:comments href=\"http://www.prixdupro.fr/index.php?page=annonce&ref=".$annonce->id."\" data-width=100%></fb:comments>
		  ";
		  ?>
			   <script>
				  FB.Event.subscribe('comments.add', function(resp) {
					  Log.info('Comment was added', resp);
				  });
			   </script>
		  </div>
		<?php
			
			}
		}
		else
		{
		  $smarty->display('search.tpl');
		  echo '
		  <div id="erreur-annonce" style="margin:20px">
			<h2 class="blue">
			  L\'annonce n\'a pas été trouvée...
			</h2>
			
			<div style="margin-top:20px">
			  <h3>
				<div>Il se peut que :</div>
				<div>- le chemin vers l\'annonce soit incorrect.</div>
				<div>- l\'annonceur en question ait retiré son annonce.</div>
				<div>- l\'annonce est arrivé à expiration.</div>
			  </h3>
			</div>
		  </div>'
		  ;
		}

		echo '  
			<div class="clear"></div>
		</div>';
		$smarty->display('footer.tpl');

?>  
  
<!-- AddThis Smart Layers BEGIN -->
<!-- Go to http://www.addthis.com/get/smart-layers to customize -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#async=1"></script>
<script type="text/javascript">
  var addthis_config = addthis_config||{};
  addthis_config.pubid = 'ra-530330b3451ac849';
  
  addthis.layers({
    'theme' : 'transparent',
    'share' : {
      'position' : 'left',
      'services' : 'facebook,twitter,google_plusone_share,email,more',
        //'numPreferredServices' : 5,
      'postShareTitle' : 'Merci d\'avoir partagé ^^',
      'postShareFollowMsg' : 'Suivez-moi ? (Allez vas-y on est pote now)'
    }, 
    'follow' : {
      'services' : [
        {'service': 'twitter', 'id': 'Rezki93'},
        {'service': 'google_follow', 'id': 'u/0/108228945793274709693/about'}
      ]
    },  
    'whatsnext' : {'title': 'On vous recommande cette page:'}  
  });
  
  //Chargement asynchrone de addthis
  addthis.init()
</script>
<!-- AddThis Smart Layers END -->

	</body>    
          
</html>
