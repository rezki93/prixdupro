<div id="banniere" style="">
	<div id="logo_site" style="float:left">
		<a href="{$RACINE}">
			<img id="imgPrixdupro" src="{$RACINE}images/banniere prixdupro.gif" style="" alt="Prixdupro : Le site de petites annonces géolocalisées"/>
		</a>
	</div>

	<div id="moduleConnexion" style="float:right; ">
		<div id="message_connexion" style=""></div>

		<div id = "connexion" style="">
			{if $smarty.session.etat == 'connecte'}
			<div id="banniere_deconnexion">
				<div id="salutation" >Bonjour {$smarty.session.con_prenom} {$smarty.session.con_nom}</div>
				<div style="float:right">
					<form method="POST" name="deconnexion_user" action="{$RACINE}index.php?page=deconnexion">
						<input type="submit" value="Deconnexion" style="cursor:pointer" />
					</form>
				</div>
				
				<div style="float:right;color:#EB8F00;">
					<form method="POST" name="gestion_compte_user" action="{$RACINE}gestion">
						<a href="{$RACINE}gestion"><input type="button" value="Mon Compte" style="cursor:pointer" /></a>
					</form>
				</div>
			</div>
			{else}
			<div id="banniere_connexion">
				<form method="POST" name="connexion_user" action="{$RACINE}index.php?page=connexion">
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
			{/if}
		</div>
    </div>
</div>
<div class="clear"></div>