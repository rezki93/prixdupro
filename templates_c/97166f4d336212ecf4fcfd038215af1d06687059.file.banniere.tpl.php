<?php /* Smarty version Smarty-3.0.6, created on 2018-11-14 23:14:36
         compiled from "./templates/banniere.tpl" */ ?>
<?php /*%%SmartyHeaderCode:55077985bec9e4cf28b47-66079744%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97166f4d336212ecf4fcfd038215af1d06687059' => 
    array (
      0 => './templates/banniere.tpl',
      1 => 1478433057,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '55077985bec9e4cf28b47-66079744',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="banniere" style="">
	<div id="logo_site" style="float:left">
		<a href="<?php echo $_smarty_tpl->getVariable('RACINE')->value;?>
">
			<img id="imgPrixdupro" src="<?php echo $_smarty_tpl->getVariable('RACINE')->value;?>
images/banniere prixdupro.gif" style="" alt="Prixdupro : Le site de petites annonces géolocalisées"/>
		</a>
	</div>

	<div id="moduleConnexion" style="float:right; ">
		<div id="message_connexion" style=""></div>

		<div id = "connexion" style="">
			<?php if ($_SESSION['etat']=='connecte'){?>
			<div id="banniere_deconnexion">
				<div id="salutation" >Bonjour <?php echo $_SESSION['con_prenom'];?>
 <?php echo $_SESSION['con_nom'];?>
</div>
				<div style="float:right">
					<form method="POST" name="deconnexion_user" action="<?php echo $_smarty_tpl->getVariable('RACINE')->value;?>
index.php?page=deconnexion">
						<input type="submit" value="Deconnexion" style="cursor:pointer" />
					</form>
				</div>
				
				<div style="float:right;color:#EB8F00;">
					<form method="POST" name="gestion_compte_user" action="<?php echo $_smarty_tpl->getVariable('RACINE')->value;?>
gestion">
						<a href="<?php echo $_smarty_tpl->getVariable('RACINE')->value;?>
gestion"><input type="button" value="Mon Compte" style="cursor:pointer" /></a>
					</form>
				</div>
			</div>
			<?php }else{ ?>
			<div id="banniere_connexion">
				<form method="POST" name="connexion_user" action="<?php echo $_smarty_tpl->getVariable('RACINE')->value;?>
index.php?page=connexion">
					<div id="blocLogin" style="float:left">
						<div style="margin-left:10px">
							<div style="float:left;margin: 3px;width:50px">Email</div>
							<input type="text" class="zone-saisie" style="width:130px;font-size: 1em;" id="con_login" name="con_login" />
						</div>
					</div>
									   
					<div id="blocPassword" style="float:left">
						<div style="margin-left:10px">
							<div style="float:left;margin: 3px;width:50px">Password</div>
							<input type="password" class="zone-saisie" style="width:130px;font-size: 1em;" id="con_password" name="con_password" />
						</div>
						<div class="clear"></div>
					</div>
					
					<input type="submit" id="connexion_button" value="Connexion" style=""/>
				</form>
				<div id="motdepasse-oublie"  onclick="renvoyer_mdp()">Mot de passe oublié ?</div>
			</div>
			<?php }?>
		</div>
    </div>
</div>
<div class="clear"></div>