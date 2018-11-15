<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Erreur 404 - Prixdupro</title>
		<meta name="Description" content="Erreur 404" />
		<?php include(dirname(__FILE__).'/../vues/head.php');	?>
	</head>
  
	<body>
		<?php $smarty->display('templates/banniere.tpl'); ?>

		<div id="principal" class="ui-widget-content" style="margin-top:5px;width:990px;margin-left:auto;margin-right:auto">
			<div style="padding:20px;font-size:15px;min-height:300px">
				<h1>Erreur 404 : Page introuvable !</h1><br/>
				<img src="/images/404-homer.jpg"/ style="width: 330px; margin-left: 280px;"/>
				<p style="margin-top:10px;margin-left:auto">
					<b>La page que vous désirez afficher n'existe pas...</b><br/> 
					Assurez vous que l'url tapée soit correcte et ressayez.<br/>
					<a href="http://www.prixdupro.fr">
						<input type="button" value="Revenir en page d'acceuil" style="width:400px;height:80px;margin:10px 0 0 250px;cursor:pointer";/>
					</a>           
				</p>
			</div>
		</div>
		<div class="clear"></div>

		<?php	$smarty->display('footer.tpl');   ?>
	</body>
</html>
