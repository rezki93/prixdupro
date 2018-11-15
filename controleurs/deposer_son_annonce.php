<?php
 
//On inclut la vue
  //include(dirname(__FILE__).'/../vues/search.php');
  //$smarty->display('deposer_son_annonce.tpl');  
  
?>
<html>
  <head>
    <title>Déposez votre annonce</title>
    <meta name="Description" content="Déposer sans attendre votre petite annonce gratuitement." >
    <?php include(dirname(__FILE__).'/../vues/head.php');	?>
	<link type="text/css" href="<?php echo RACINE; ?>includes/bootstrap-3.3.6-dist/css/bootstrap.css" rel="stylesheet" />  

    <style>
		#bloc_choix_creation{width:770px;margin:auto;}
		#choix_creation_compte{float:left;border:2px solid grey;border-radius:10px;cursor:pointer;padding: 30px 0 30px 0;width:375px;}
		#choix_creation_compte:hover{background-color:#CCC;border:2px solid blue;}
		#choix_depot_direct{float:left;border:2px solid grey;border-radius:10px;cursor:pointer;padding: 30px 0 30px 0;width:375px;margin-left:10px}
		#choix_depot_direct:hover{background-color:#CCC;border:2px solid red;}
		.t300{width:360px;}
    </style>
    <! -- Mise en forme des boutons -->    
    <script type="text/javascript">
      $(function() {
        $( "#map_annonce" ).button();  
        $( "#affiche_adresse" ).button();     
        $( "#affiche_tel" ).button();  
        $( "#debat_annonce" ).button();
        
      });
    </script>
    
  </head>
  
  <body>
    <?php $smarty->display('templates/banniere.tpl'); ?>   
	<link type="text/css" href="<?php echo RACINE; ?>includes/bootstrap-3.3.6-dist/css/bootstrap.css" rel="stylesheet" />  
	<script src="<?php echo RACINE; ?>includes/bootstrap-3.3.6-dist/js/jquery-1.12.0.min.js"></script> 
    <script src="<?php echo RACINE; ?>includes/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script> 
    
    <div id="contenu-principal" class="ui-widget-content" style="width:984px;min-height:500px;border-radius: 20px 20px 20px 20px;margin:auto;padding:20px">
		<h1 style="margin:auto;color:#52A1A0;font-size:25px" align="center" >Dépot d'annonce</h1>
		<p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;margin-top:20px">
		Le depôt d'annonce sur le site est totalement <b>GRATUIT</b>.<br/>
		Vous avez la possibilité de créer autant d'annonces que vous le souhaitez. Vos annonces devront être validé par nos équipes avant d'être mises en ligne. Le delai maximum est de 12 heures.<br/>
		<b>N'hésitez plus, Faites vous plaisir : Annoncez !</b>
		</p>
      
  <?php
  //Si l'utilisateur est déjà connecté
  if(isset($_SESSION["etat"]) && $_SESSION["etat"]=="connecte" && isset($_SESSION["con_id"]) && is_numeric($_SESSION["con_id"]) ){
    ?>
	
		<div class="row" style="margin:30px 0 0 0">
			<div class="col-md-9"> 
				<form method="POST" name="depot_annonce" enctype="multipart/form-data" action="./index.php?page=depot_annonce">
				
					<!-- Ajout Bloc Loader GIF -->
					<div id="loader" style="position:absolute; margin-left:300px;display:none">
						<img src="./images/loading.gif" >
					</div>
				  
				  
					<!-- Debut des inputs formulaires  -->
					
					<!-- Input Categorie -->
					<div class="input-group">
						<span class="input-group-addon">Categorie</span>
						<SELECT  class="form-control" id="cat_annonce" name="cat_annonce"  value="">
						  <OPTION  VALUE="--">Toutes</OPTION>
						  <optgroup label="Vehicules">
							<OPTION VALUE="1">Auto</OPTION>
							<OPTION VALUE="2">Moto</OPTION>
							<OPTION VALUE="3">Caravaning</OPTION>
							<OPTION VALUE="4">Utilitaires</OPTION>
							<OPTION VALUE="5">Equipement Auto</OPTION>
							<OPTION VALUE="6">Equipement Moto</OPTION>
							<OPTION VALUE="7">Equipement Caravaning</OPTION>
						  </optgroup>
						  
						  <optgroup label="Hi-Tech">
							<OPTION VALUE="34">Image/Son</OPTION>
							<OPTION VALUE="9">Informatique</OPTION>
							<OPTION VALUE="10">Consoles/Jeux video</OPTION>
							<OPTION VALUE="11">Telephonie</OPTION>
						  </optgroup>
						  
						  <optgroup label="Maison">
							<OPTION VALUE="8">Immobilier</OPTION>
							<OPTION VALUE="12">Ameublement</OPTION>
							<OPTION VALUE="13">Electromenager</OPTION>
							<OPTION VALUE="14">Decoration</OPTION>
							<OPTION VALUE="15">Bricolage/Jardinage</OPTION>
							<OPTION VALUE="16">Vetements</OPTION>
							<OPTION VALUE="17">Accessoire/Bagagerie</OPTION>
							<OPTION VALUE="18">Montres/Bijoux</OPTION>
							<OPTION VALUE="19">Equipement Bebe</OPTION>
						  </optgroup>
						  
						  <optgroup label="Loisirs">
							<OPTION VALUE="20">DVD</OPTION>
							<OPTION VALUE="21">CD</OPTION>
							<OPTION VALUE="22">Bluray</OPTION>
							<OPTION VALUE="23">Livres</OPTION>
							<OPTION VALUE="24">Animaux</OPTION>
							<OPTION VALUE="25">Sports/Hobbies</OPTION>
							<OPTION VALUE="26">Collection</OPTION>
							<OPTION VALUE="27">Jeux/Jouets</OPTION>
							<OPTION VALUE="28">Vins/Gastronomie</OPTION>
						  </optgroup>
						  
						  <optgroup label="Emplois & services">
							<OPTION VALUE="29">Billeterie</OPTION>
							<OPTION VALUE="30">Evenements</OPTION>
							<OPTION VALUE="31">Services</OPTION>
							<OPTION VALUE="32">Emplois</OPTION>
							<OPTION VALUE="33">Cours Particuliers</OPTION>
						  </optgroup>
						  <OPTION VALUE="35">Autre</OPTION>
						  
						</SELECT>
					</div>

			
					<!-- Input Region -->
					<!--
					<div class="input-group">
						<span class="input-group-addon">Region</span>
						<SELECT class="form-control" id="region" name="region" onchange="getDepartements(this.value,'','bloc_depot_departements');">
							<OPTION  VALUE="--">--</OPTION>
							<OPTION  VALUE="1">Alsace</OPTION>
							<OPTION  VALUE="2">Aquitaine</OPTION>
							<OPTION  VALUE="3">Auvergne</OPTION>
							<OPTION  VALUE="4">Basse-Normandie</OPTION>
							<OPTION  VALUE="5">Bourgogne</OPTION>
							<OPTION  VALUE="6">Bretagne</OPTION>
							<OPTION  VALUE="7">Centre</OPTION>
							<OPTION  VALUE="8">Champagne-Ardenne</OPTION>
							<OPTION  VALUE="9">Corse</OPTION>
							<OPTION  VALUE="10">Franche-Comté</OPTION>
							<OPTION  VALUE="11">Haute-Normandie</OPTION>
							<OPTION  VALUE="12">Ile-de-France</OPTION>
							<OPTION  VALUE="13">Languedoc-Roussillon</OPTION>
							<OPTION  VALUE="14">Limousin</OPTION>
							<OPTION  VALUE="15">Lorraine</OPTION>
							<OPTION  VALUE="16">Midi-Pyrénés</OPTION>
							<OPTION  VALUE="17">Nord-Pas-De-Calais</OPTION>
							<OPTION  VALUE="18">Pays de la Loire</OPTION>
							<OPTION  VALUE="19">Picardie</OPTION>
							<OPTION  VALUE="20">Poitou-Charentes</OPTION>
							<OPTION  VALUE="21">Alpes-Côte d'Azur</OPTION>
							<OPTION  VALUE="22">Rhône-Alpes</OPTION>
							<OPTION  VALUE="23">Departements d'outre Mer</OPTION>    
						</SELECT>
					</div>  
					-->
					
					<!-- Input Departement -->
					<!--
					<div class="input-group">
						<span class="input-group-addon">Département</span>
						<span id="bloc_depot_departements" class="form-control" ></span>
					</div>
					-->
					<!-- Input Ville -->
					<!--
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1">Ville</span>
					  <input type="text" class="form-control" placeholder="Tapez ici votre ville" aria-describedby="basic-addon1" id="ville_annonce" name="ville_annonce"> 
					</div>
					-->
					<!-- Input Année -->
					<div class="input-group" id="bloc_depot_annee" style="display:none">
						<span class="input-group-addon">Année</span>
						<input type="text" class="form-control" placeholder="Annee" id="annee_annonce" name="annee_annonce" onclick="" value="" />
					</div>
					
					<!-- Input KM -->
					<div class="input-group" id="bloc_depot_km" style="display:none">
						<span class="input-group-addon">KM</span>
						<input type="text" class="form-control" placeholder="Kilometres" id="km_annonce" name="km_annonce" onclick="" value="" />
					</div>
					
					<!-- Input Energie -->
					<div class="input-group" id="bloc_depot_energie" style="display:none">
						<span class="input-group-addon">Energie</span>
						<SELECT class="form-control" placeholder="Energie" id="energie_annonce" name="energie_annonce" >
							<OPTION id="" VALUE="--">--</OPTION>
							<OPTION id="" VALUE="Diesel">Diesel</OPTION>
							<OPTION id="" VALUE="Essence">Essence</OPTION>
							<OPTION id="" VALUE="Electrique">Electrique</OPTION>
							<OPTION id="" VALUE="GPL">GPL</OPTION>
						</SELECT>
					</div>
					
					<!-- Input Boite de vitesse -->
					<div class="input-group" id="bloc_depot_boite" style="display:none">
						<span class="input-group-addon">Boite</span>
						<SELECT class="form-control" placeholder="Boite" id="boite_annonce" name="boite_annonce" >
							<OPTION id="" VALUE="--">--</OPTION>
							<OPTION id="" VALUE="Automatique">Automatique</OPTION>
							<OPTION id="" VALUE="Manuelle">Manuelle</OPTION>
						</SELECT>
					</div>

					
									
					<!-- Input Titre annonce -->
					<div class="input-group">
						<span class="input-group-addon">Titre annonce</span>
						<input type="text" class="form-control" placeholder="Tapez ici votre titre" id="titre_annonce" name="titre_annonce" onclick="" value="" />
					</div>
					
					<!-- Input Description -->
					<div class="input-group" id="bloc_description">
						<span class="input-group-addon">Description</span>
						<TEXTAREA  class="form-control" id="desc_annonce" name="desc_annonce" onkeyup="this.value = this.value.substr(0,2000);" >	</TEXTAREA>
					</div>
					
					<!-- Input Prix -->
					<div class="input-group">
						<span class="input-group-addon">Prix €</span>
						<input type="text" class="form-control" placeholder="Tapez ici votre prix" id="prix_annonce" name="prix_annonce" onclick="" value="" />
					</div>
					
				  
					<!-- Input Pseudo -->
					<!--
					<div class="input-group">
						<span class="input-group-addon">Pseudo</span>
						<input type="text" class="form-control" placeholder="Tapez ici votre pseudo" id="pseudo_annonce" name="pseudo_annonce" onclick="" value="" />
					</div>
					-->
					<!-- Input Email -->
					<!--
					<div class="input-group">
						<span class="input-group-addon">Email</span>
						<input type="text" class="form-control" placeholder="Tapez ici votre Email" id="email_annonce" name="email_annonce" onclick="" value="" />
					</div>
					-->
					<!-- Input Téléphone -->
					<!--
					<div class="input-group">
						<span class="input-group-addon">Téléphone</span>
						<input type="text" class="form-control" placeholder="Tapez ici votre Téléphone" id="tel_annonce" name="tel_annonce" maxlength="30" onclick="" value="" />
					</div>
					-->
					<!-- Input Password -->
					<!--
					<div class="input-group">
						<span class="input-group-addon">Mot de passe</span>
						<input type="password" class="form-control" placeholder="Tapez ici votre mot de passe" id="mdp_annnonce" name="mdp_annnonce" onclick="" value="" />
					</div>				
					-->
				  
					<div class="checkbox">
						<label><input type="checkbox" class="checkbox" id="map_annonce" name="map_annonce"  checked="checked"> Vous souhaitez activer la localisation Google Map</label>
					</div>
					<div class="checkbox">
						<label><input type="checkbox" class="checkbox" id="affiche_adresse" name="affiche_adresse"  checked="checked"> Votre adresse complète est divulgée </label>
					</div>
					<div class="checkbox">
						<label><input type="checkbox" class="checkbox" id="debat_annonce" name="debat_annonce" > Votre prix est à débattre </label>	
					</div>
					<div class="checkbox">
						<label><input type="checkbox" class="checkbox" id="affiche_tel" name="debat_annonce"  checked="checked"> Vous souhaitez afficher votre numéro de téléphone</label>	
					</div>
					  

					<div id="bloc_photos" style="margin-top:30px;width: 100%;margin:0;">
						<div>
						  Les photos ne doivent pas dépasser 5mo
						</div>

						<!-- Input Photo 1 -->
						<div class="input-group">
							<span class="input-group-addon">Photo 1</span>
							<input type="file" class="form-control" placeholder="" id="photo1" name="photo1" onclick="" value="" />
							<input type="hidden" name="MAX_FILE_SIZE" value="10097152" /> 
						</div>	

						<!-- Input Photo 2 -->
						<div class="input-group">
							<span class="input-group-addon">Photo 2</span>
							<input type="file" class="form-control" placeholder="" id="photo2" name="photo2" onclick="" value="" />
							<input type="hidden" name="MAX_FILE_SIZE" value="10097152" /> 
						</div>	

						<!-- Input Photo 3 -->
						<div class="input-group">
							<span class="input-group-addon">Photo 3</span>
							<input type="file" class="form-control" placeholder="" id="photo3" name="photo3" onclick="" value="" />
							<input type="hidden" name="MAX_FILE_SIZE" value="10097152" /> 
						</div>	
					</div>        
				  
				  
				  
				  <div style="width:950px;">
					<div class="blue-button2" id="deposer_annonce" style="margin-right:0px;margin-bottom: 10px;">Deposer Annonce</div>
				  </div>
				
				</form>
			</div>
			<div class="col-md-3"> 
				<div id="indication_erreurs2" style="float:left;color:#CA0036;display:none;border:2px solid red;border-radius:10px; padding:5px ">
					<div><b>Veuillez verifier que :</b></div>
					<div>- les champs soient remplis</div>
					<div>- la categorie soit selectionnée</div>
					<div>- le prix soit un chiffre (sans le ?)</div>
				</div>
			</div>
		</div>
        <div class="clear"></div>
      

  
<?php
  }
  /* Si l'utilisateur n'est pas connecté */
  else{
    ?>
    <div id="bloc_choix_creation" align=center >
      <div id="choix_creation_compte" style="" onclick="if($('#form_creation_compte').is(':hidden')){$('#form_depot_direct').slideUp();$('#form_creation_compte').slideDown('');}">
        <span style="font-size:18px">Se créer un compte Annonceur</span>        
      </div>
      
      <div id="choix_depot_direct" style="" onclick="if($('#form_depot_direct').is(':hidden')){$('#form_creation_compte').slideUp();$('#form_depot_direct').slideDown('');}">
         <span style="font-size:18px">Déposer son Annonce sans compte</span>      
      </div>
    </div>
    
      <div class="clear"></div>
      
      <div id="form_creation_compte" style="width:750px;margin:auto;padding:10px;border:2px solid blue;border-radius:10px">
        <form method="POST" name="creation_compte" action="./index.php?page=inscription">
          <div style="float:left">
            <div class="t300" style="margin-left:10px">
              <div style="float:left;margin: 3px;width:100px">Prenom :</div>
              <input type="text" class="zone-saisie" style="width:150px;" maxlength="40" id="prenom" name="prenom"  value="" />
            </div>
            
            <div class="t300" style="margin-left:10px">
              <div style="float:left;margin: 3px;width:100px">Nom :</div>
              <input type="text" class="zone-saisie" style="width:150px;" maxlength="40" id="nom" name="nom"  value="" />
            </div>
            
            <div class="t300" style="margin-left:10px">
              <div style="float:left;margin: 3px;width:100px">Tel :</div>
              <input type="text" class="zone-saisie" style="width:150px;" id="tel" name="tel" value="" />
            </div>
            
   
            <div class="t300" style="margin-left:10px">
              <div style="float:left;margin: 3px;width:100px">Region :</div>
              <SELECT style="float:left;width:150px;" id="region" name="region" onchange="getDepartements(this.value,'','bloc_depot_departements');">
                <OPTION  VALUE="--">--</OPTION>
                <OPTION  VALUE="1">Alsace</OPTION>
                <OPTION  VALUE="2">Aquitaine</OPTION>
                <OPTION  VALUE="3">Auvergne</OPTION>
                <OPTION  VALUE="4">Basse-Normandie</OPTION>
                <OPTION  VALUE="5">Bourgogne</OPTION>
                <OPTION  VALUE="6">Bretagne</OPTION>
                <OPTION  VALUE="7">Centre</OPTION>
                <OPTION  VALUE="8">Champagne-Ardenne</OPTION>
                <OPTION  VALUE="9">Corse</OPTION>
                <OPTION  VALUE="10">Franche-Comté</OPTION>
                <OPTION  VALUE="11">Haute-Normandie</OPTION>
                <OPTION  VALUE="12">Ile-de-France</OPTION>
                <OPTION  VALUE="13">Languedoc-Roussillon</OPTION>
                <OPTION  VALUE="14">Limousin</OPTION>
                <OPTION  VALUE="15">Lorraine</OPTION>
                <OPTION  VALUE="16">Midi-Pyrénés</OPTION>
                <OPTION  VALUE="17">Nord-Pas-De-Calais</OPTION>
                <OPTION  VALUE="18">Pays de la Loire</OPTION>
                <OPTION  VALUE="19">Picardie</OPTION>
                <OPTION  VALUE="20">Poitou-Charentes</OPTION>
                <OPTION  VALUE="21">Alpes-Côte d'Azur</OPTION>
                <OPTION  VALUE="22">Rhône-Alpes</OPTION>
                <OPTION  VALUE="23">Departements d'outre Mer</OPTION>    
              </SELECT>
            </div>  
              
            <div class="t300" style="margin-left:10px" >
              <div class="" style="float:left;margin: 3px;width:100px">Departement :</div>
              <span id="bloc_depot_departements" style="width:150px">
                <input type="text" class="zone-saisie" style="width:150px;" maxlength="50" id="departement" name="departement"  value="" />
              </span>
            </div>
   
            <div class="t300" style="margin-left:10px;float:left">
              <div class="" style="float:left;margin: 3px;width:100px">Ville :</div>
              <input type="text" class="zone-saisie" style="width:150px;" maxlength="50" id="ville" name="ville"  value="" />
            </div>
            
            <div class="t300" style="margin-left:10px">
              <div class="" style="float:left;margin: 3px;width:100px">Adresse :</div>
              <input type="text" class="zone-saisie" style="width:150px;" maxlength="50" id="adresse" name="adresse"  value="" />
            </div>

                    
            <div class="t300" style="margin-left:10px">
              <div class="" style="float:left;margin: 3px;width:100px">E-mail :</div>
              <input type="text" class="zone-saisie" style="width:150px;" id="mail" name="mail"  value="" />
            </div>
            
            <div class="t300" style="margin-left:10px">
              <div class="" style="float:left;margin: 3px;width:100px">Mot de passe :</div>
              <input type="password" class="zone-saisie" style="width:150px;" id="password" name="password" />
            </div>
          </div>
          
          <div id="indication_erreurs" style="float:left;margin-left:30px;color:#CA0036;display:none">
            <div><b>Veuillez verifier que :</b></div>
            <div>- les champs soient remplis</div>
            <div>- le numero de telephone possède 10 chiffres</div>
            <div>- l'adresse mail soit valide</div>
            <div>- le mot de passe possède au moins 6 caractères</div>
          </div>
          
          <div class="clear"></div>
          <div class="blue-button2" id="inscription" style="margin-right:0px;margin-top:10px;">S'inscrire</div>
        </form>
        <div class="clear"></div>
      </div>
      
      <div class="clear"></div>
      
      <div id="form_depot_direct"  style="width:750px;margin:auto;padding:10px;border:2px solid red;border-radius:10px;display:none;">
        <form method="POST" name="form_depot_direct" enctype="multipart/form-data" action="index.php?page=deposer_son_annonce" >
          <div id="bloc_desc_user1" style="float:left;margin-left:10px;border:1px solid grey">
            <div class="t300" >
              <div style="float:left;margin: 3px;width:100px">Pseudo :</div>
              <input type="text" class="zone-saisie" style="width:150px;" maxlength="40" id="prenom" name="prenom"  value="" />
            </div>
            
            <div class="t300">
              <div style="float:left;margin: 3px;width:100px">Tel :</div>
              <input type="text" class="zone-saisie" style="width:150px;" id="tel" name="tel" value="" />
            </div>
            
            <div class="t300">
              <div class="" style="float:left;margin: 3px;width:100px">E-mail :</div>
              <input type="text" class="zone-saisie" style="width:150px;" id="mail" name="mail"  value="" />
            </div>
            
            <div class="t300" >
              <div class="" style="float:left;margin: 3px;width:100px">Mot de passe :</div>
              <input type="password" class="zone-saisie" style="width:150px;" id="password" name="password" />
            </div>      
          </div> 
          <!-- fin id="bloc_desc_user1" -->          
          
          <div id="bloc_desc_user2" style="float:left;border:1px solid green">   
            <div class="t300" >
              <div style="float:left;margin: 3px;width:100px">Region :</div>
              <SELECT style="float:left;width:150px;" id="region" name="region" onchange="getDepartements(this.value,'','bloc_depot_departements');">
                <OPTION  VALUE="--">--</OPTION>
                <OPTION  VALUE="1">Alsace</OPTION>
                <OPTION  VALUE="2">Aquitaine</OPTION>
                <OPTION  VALUE="3">Auvergne</OPTION>
                <OPTION  VALUE="4">Basse-Normandie</OPTION>
                <OPTION  VALUE="5">Bourgogne</OPTION>
                <OPTION  VALUE="6">Bretagne</OPTION>
                <OPTION  VALUE="7">Centre</OPTION>
                <OPTION  VALUE="8">Champagne-Ardenne</OPTION>
                <OPTION  VALUE="9">Corse</OPTION>
                <OPTION  VALUE="10">Franche-Comté</OPTION>
                <OPTION  VALUE="11">Haute-Normandie</OPTION>
                <OPTION  VALUE="12">Ile-de-France</OPTION>
                <OPTION  VALUE="13">Languedoc-Roussillon</OPTION>
                <OPTION  VALUE="14">Limousin</OPTION>
                <OPTION  VALUE="15">Lorraine</OPTION>
                <OPTION  VALUE="16">Midi-Pyrénés</OPTION>
                <OPTION  VALUE="17">Nord-Pas-De-Calais</OPTION>
                <OPTION  VALUE="18">Pays de la Loire</OPTION>
                <OPTION  VALUE="19">Picardie</OPTION>
                <OPTION  VALUE="20">Poitou-Charentes</OPTION>
                <OPTION  VALUE="21">Alpes-Côte d'Azur</OPTION>
                <OPTION  VALUE="22">Rhône-Alpes</OPTION>
                <OPTION  VALUE="23">Departements d'outre Mer</OPTION>    
              </SELECT>
            </div>  
              
            <div class="t300" >
              <div class="" style="float:left;margin: 3px;width:100px">Departement :</div>
              <span id="bloc_depot_departements" style="width:150px">
                <input type="text" class="zone-saisie" style="width:150px;" maxlength="50" id="departement" name="departement"  value="" />
              </span>
            </div>
   
            <div class="t300" >
              <div class="" style="float:left;margin: 3px;width:100px">Ville :</div>
              <input type="text" class="zone-saisie" style="width:150px;" maxlength="50" id="ville" name="ville"  value="" />
            </div>
            
            <div class="t300" >
              <div class="" style="float:left;margin: 3px;width:100px">Adresse :</div>
              <input type="text" class="zone-saisie" style="width:150px;" maxlength="50" id="adresse" name="adresse"  value="" />
            </div>      
          </div> 
          <!-- fin id="bloc_desc_user2" -->  
          
          <div class="clear"></div>
          
          <div id="bloc_desc_user3" class="t300" style="margin-top:20px;margin-left:10px;float:left;border:1px solid orange">   
            <div id="loader" style="position:absolute; margin-left:300px;display:none">
               <img src="/images/loading.gif" >
            </div>
        
            <div class="t300">
               <div class="" style="float:left;margin: 3px;width:100px">Titre</div>
               <input type="text" class="zone-saisie" style="width:150px;" maxlength="40" id="titre_annonce" name="titre_annonce"  value="" />
            </div>
        
            <div class="t300">
               <div class="" style="float:left;margin: 3px;width:100px">Prix</div>
               <input type="text" class="zone-saisie" style="width:150px;" id="prix_annonce" name="prix_annonce" onclick="" value="" />
             </div>
        
             <div class="t300">
               <div class="" style="float:left;margin: 3px;width:100px">Categorie</div>
               <SELECT style="width:150px;" id="cat_annonce" name="cat_annonce"  value="">
                 <OPTION  VALUE="--">Toutes</OPTION>
                 <optgroup label="Vehicules">
                   <OPTION VALUE="1">Auto</OPTION>
                   <OPTION VALUE="2">Moto</OPTION>
                   <OPTION VALUE="3">Caravaning</OPTION>
                   <OPTION VALUE="4">Utilitaires</OPTION>
                   <OPTION VALUE="5">Equipement Auto</OPTION>
                   <OPTION VALUE="6">Equipement Moto</OPTION>
                   <OPTION VALUE="7">Equipement Caravaning</OPTION>
                 </optgroup>
                 
                 
                 <optgroup label="Hi-Tech">
                   <OPTION VALUE="8">Image/Son</OPTION>
                   <OPTION VALUE="9">Informatique</OPTION>
                   <OPTION VALUE="10">Consoles/Jeux video</OPTION>
                   <OPTION VALUE="11">Telephonie</OPTION>
                 </optgroup>
                 
                 <optgroup label="Maison">
                   <OPTION VALUE="12">Immobilier</OPTION>
                   <OPTION VALUE="13">Ameublement</OPTION>
                   <OPTION VALUE="14">Electromenager</OPTION>
                   <OPTION VALUE="15">Bricolage/Jardinage</OPTION>
                   <OPTION VALUE="16">Vetements</OPTION>
                   <OPTION VALUE="17">Accessoire/Bagagerie</OPTION>
                   <OPTION VALUE="18">Montres/Bijoux</OPTION>
                   <OPTION VALUE="19">Equipement Bebe</OPTION>
                 </optgroup>
                 
                 <optgroup label="Loisirs">
                   <OPTION VALUE="20">DVD</OPTION>
                   <OPTION VALUE="21">CD</OPTION>
                   <OPTION VALUE="22">Bluray</OPTION>
                   <OPTION VALUE="23">Livres</OPTION>
                   <OPTION VALUE="24">Animaux</OPTION>
                   <OPTION VALUE="25">Sports/Hobbies</OPTION>
                   <OPTION VALUE="26">Collection</OPTION>
                   <OPTION VALUE="27">Jeux/Jouets</OPTION>
                   <OPTION VALUE="28">Vins/Gastronomie</OPTION>
                 </optgroup>
                 
                 <optgroup label="Emplois & services">
                   <OPTION VALUE="29">Billeterie</OPTION>
                   <OPTION VALUE="30">Evenements</OPTION>
                   <OPTION VALUE="31">Services</OPTION>
                   <OPTION VALUE="32">Emplois</OPTION>
                   <OPTION VALUE="33">Cours Particuliers</OPTION>
                 </optgroup>
                 <OPTION VALUE="34">Recherche</OPTION>
                 <OPTION VALUE="35">Autre</OPTION>
                 
               </SELECT>
             </div>
          </div>
          <!-- fin id="bloc_desc_user3" --> 
          
          <div id="bloc_auto" style="float:left;margin-top:20px;border:1px solid black">
            <div id="bloc_depot_annee" class="t300" style="display:none;">
              <div class="" style="float:left;margin: 3px;width:100px">Annee</div>
              <input type="text" class="zone-saisie" style="width:150px;" id="annee_annonce" name="annee_annonce" onclick="" value="" />
            </div>
            
            <div id="bloc_depot_km" class="t300" style="display:none;">
              <div class="" style="float:left;margin: 3px;width:100px">Km</div>
              <input type="text" class="zone-saisie" style="width:150px;" id="km_annonce" name="km_annonce" onclick="" value="" />
            </div>
            
            
            <div id="bloc_depot_energie" class="t300" style="display:none;">
              <div class="" style="float:left;margin: 3px;width:100px">Energie</div>
              <SELECT style="width:150px;" id="energie_annonce" name="energie_annonce" >
                <OPTION id="" VALUE="--">--</OPTION>
                <OPTION id="" VALUE="Diesel">Diesel</OPTION>
                <OPTION id="" VALUE="Essence">Essence</OPTION>
                <OPTION id="" VALUE="Electrique">Electrique</OPTION>
                <OPTION id="" VALUE="GPL">GPL</OPTION>
              </SELECT>
            </div>
            
            <div id="bloc_depot_boite" class="t300" style="display:none;">
              <div class="" style="float:left;margin: 3px;width:100px">Boite</div>
              <SELECT style="width:150px;" id="boite_annonce" name="boite_annonce" >
                <OPTION id="" VALUE="--">--</OPTION>
                <OPTION id="" VALUE="Automatique">Automatique</OPTION>
                <OPTION id="" VALUE="Manuelle">Manuelle</OPTION>
              </SELECT>
            </div>
            
          </div>
          <!-- fin id="bloc_auto" -->  
          
          <div class="clear"></div>
      
          <div id="bloc_description"  style="margin-left:10px;">
            <div style="float:left" class="t300"  style="">
              <div style="margin: 3px;width:100px">Description</div>
              <div style="">
                <TEXTAREA width="200px" id="desc_annonce" name="desc_annonce" onkeyup="this.value = this.value.substr(0,2000);" >
                </TEXTAREA>
              </div>
            </div>

            <div id="bloc_visibilite" class="t300" style="border:1px solid blue;float:left;text-align:center">
              Cliquez sur une mention pour la desactiver :
              <div style="">
                <!--<div style="float:left">Afficher votre telephone :</div>-->
                <input style="" type="checkbox" id="affiche_tel" name="affiche_tel" checked="checked" />
                <label for="affiche_tel" style="width:250px;">Affichage de votre téléphone</label>
              </div>
              
              <div style="">
                <!--<div style="float:left">Prix à débattre :</div>-->
                <input style="" type="checkbox" id="debat_annonce" name="debat_annonce" checked="checked"  />
                <label for="debat_annonce" style="width:250px;">Prix à débattre</label>
              </div>
              
              
              <div style="">
                <!--<div style="float:left;">Localisation Google Map :</div>-->
                <input style="" type="checkbox" id="map_annonce" name="map_annonce" checked="checked" />
                <label for="map_annonce" style="width:250px;">Localisation Google Map de votre ville</label>
              </div>
              
              <div style="">
                <!--<div style="float:left">Localisation avec votre adresse exact:</div>-->
                <input style="" type="checkbox" id="affiche_adresse" name="affiche_adresse" checked="checked" />
                <label for="affiche_adresse" style="width:250px;">Localisation Google Map de votre adresse</label>
              </div>
            </div>
            <div class="clear"></div>
          </div>
          <!-- Fin bloc description -->
          
          <div id="bloc_photos" style="margin-left:10px;border:1px solid yellow">
            <div id="bloc_photo1" style="margin-left:30px">
              <div style="margin: 3px;width:80px">Photo 1</div>
              <input type="file" name="photo1" id="photo1" />
              <input type="hidden" name="MAX_FILE_SIZE" value="10097152" />  
            </div>
            
            <div id="bloc_photo2" style="margin-left:30px;display:none">
              <div style="margin: 3px;width:80px">Photo 2</div>
              <input type="file" name="photo2" id="photo2" />
              <input type="hidden" name="MAX_FILE_SIZE" value="10097152" />  
            </div>
            
            <div id="bloc_photo3" style="margin-left:30px;display:none">
              <div style="margin: 3px;width:80px">Photo 3</div>
              <input type="file" name="photo3" id="photo3" />
              <input type="hidden" name="MAX_FILE_SIZE" value="10097152" />  
            </div>
            <script type="text/javascript">
              $('#photo1').customFileInput();  
            </script>
            
            <div style="margin-left:30px">
              <div style="margin: 3px;width:230px">Les photos ne doivent pas depasser 4mo</div>
            </div>
          </div>
          <!-- Fin bloc photos -->

         
          
          <div  >
             <div id="indication_erreurs2" style="float:left;color:#CA0036;display:none;">
               <div><b>Veuillez v&eacute;rifier que :</b></div>
               <div>- Les champs soient remplis</div>
               <div>- La cat&eacute;gorie soit selectionn&eacute;e</div>
               <div>- Le prix soit un chiffre (sans le &#x20AC;)</div>
            </div>
            
            <div id="indication_erreurs" style="float:left;margin-left:30px;color:#CA0036;display:none">
              <div><b>Veuillez verifier que :</b></div>
              <div>- les champs soient remplis</div>
              <div>- le numero de telephone possède 10 chiffres</div>
              <div>- l'adresse mail soit valide</div>
              <div>- le mot de passe possède au moins 6 caractères</div>
            </div>
            <div class="blue-button2" id="deposer_annonce" style="">Deposer</div>
          </div>
          <div class="clear"></div>
        </form>
      </div>
    <?php
  }
  ?>
      </div>  
  <?php
  $smarty->display('templates/footer.tpl');
  ?>

  </body>
</html>


