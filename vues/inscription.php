<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="fr-FR">
	<head>
		<title>Inscription - Prixdupro</title>
		<meta name="robots" content="noindex, follow" />
		<meta name="Description" content="Page d'inscription au site de petites annonces gratuites Prixdupro" />
		<?php include(dirname(__FILE__).'/../vues/head.php');	?>
		<link type="text/css" href="<?php echo RACINE; ?>/css/annonce.css" rel="stylesheet" />  
		<script type="text/javascript" src="http://gettopup.com/releases/latest/top_up-min.js"></script>
	</head>
	
	<body>    
	
		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-M39RRF" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-M39RRF');</script>
		<!-- End Google Tag Manager -->     
		
		<?php  
        $smarty->display('banniere.tpl'); 
        //$smarty->display('presentation.tpl');
		?>
		<div id="principal-annonce" class="ui-widget-content" style="">

	
	

<?php



if($user['reponse'] == 1 )
{
  $reg = array(1 =>"Alsace",2 =>"Aquitaine",3 =>"Auvergne",4 =>"Basse-Normandie",5 =>"Bourgogne",6 =>"Bretagne",7 =>"Centre",8 =>"Champagne-Ardenne",9 =>"Corse",10 =>"Franche-Comté",11 =>"Haute-Normandie",12 =>"Ile-de-France",13 =>"Languedoc-Roussillon",14 =>"Limousin",15 =>"Lorraine",16 =>"Midi-Pyrénés",17 =>"Nord-Pas-De-Calais",18 =>"Pays de la Loire",19 =>"Picardie",20 =>"Poitou-Charentes",21 =>"Alpes-Côte d'Azur",22 =>"Rhône-Alpes",23 =>"Departements d'outre Mer");
?>

	<div>
		<div style="float:left;margin-left:40px;">
			<span class="text blue bold" style="float:left;margin-top:20px;">
				<h1>FELICITATIONS ! Votre compte a été créé avec succes !</h1>
			</span>

			<span class="text blue bold" style="float:left;margin-top:20px;">
				<h2>Les informations liées à votre compte sont :</h2>
			</span>
		</div>

		<div style="float:left;margin-top:20px;margin-left:40px">
			<div class="text bold" style="margin-top:20px;">Votre prenom : 				<span class="green"><?php echo $user['prenom']?></span></div>
			<div class="text bold" style="margin-top:20px;">Votre nom : 				<span class="green"><?php echo $user['nom']?></span></div>
			<div class="text bold" style="margin-top:20px;">Votre region : 				<span class="green"><?php echo $reg[$user['region']]?></span></div>
			<div class="text bold" style="margin-top:20px;">Votre departement : 		<span class="green"><?php echo $user['departement']?></span></div>
			<div class="text bold" style="margin-top:20px;">Votre ville : 				<span class="green"><?php echo $user['ville']?></span></div>                                                                                               
			<div class="text bold" style="margin-top:20px;">Votre adresse : 			<span class="green"><?php echo $user['adresse']?></span></div>                                                                                          
			<div class="text bold" style="margin-top:20px;">Votre numero de telephone : <span class="green"><?php echo $user['tel']?></span></div>
			<div class="text bold" style="margin-top:20px;">Votre adresse mail : 		<span class="green"><?php echo $user['mail']?></span></div>
			<div class="text bold" style="margin-top:20px;">Votre mot de passe : 		<span class="green">(consultez votre boite mail)</span></div>
		</div>
	</div>
<?php
}
else if($user['reponse'] == 2 )
{
?>
	<div>
		<div style="float:left;margin-left:40px;">
			<span class="text blue bold" style="float:left;margin-top:20px;">
				<h1>Désolé l'inscription a échoué !</h1>
			</span>

			<span class="text blue bold" style="float:left;margin-top:20px;">
				<h2>L'adresse e-mail entrée correspond déjà à un utilisateur</h2>
			</span>
		</div>
	  
	</div>
<?php

}
else
{
?>
      <div>
          <div style="float:left;margin-left:40px;">
            <span class="text blue bold" style="float:left;margin-top:20px;">
				<h1>  Désolé l'inscription a échoué !</h1>
            </span>
            
            <span class="text blue bold" style="float:left;margin-top:20px;">
				<h2>Re-essayez avec des valeurs correctes</h2>
            </span>
          </div>
      </div>
<?php
}
?>
<div class="clear"></div></div>
<?php $smarty->display('footer.tpl'); ?>
</body>
