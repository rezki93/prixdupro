<?php

///////////////////////////////////// 
/*
	PHP Web Manager: Reloaded
	Fichier: copy.win.php
	Dernière modification: 10/06/2010
	Copyright (C) SimpleGeek 2010-2011
*/
///////////////////////////////////// 

#######################
##     SECURITE      ##
#######################

  if(!$logged)
	exit;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=strtolower($language[$langue])?>" lang="<?=strtolower($language[$langue])?>">
	<head> 
	
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
		<meta name="desciption" content="PHP Web Manager: Reloaded - WebFTP" />
		<meta name="keywords" content="client ftp, ftp, php web manager, reloaded, simplegeek, manager, php, web, html, admin, password, filezilla" />
		<meta name="author" content="SimpleGeek" />
		
		<title>PHP Web Manager: MP3 Player</title>
		
		<link href="<?=$PWM_FILES?>css/player.css" rel="stylesheet" type="text/css" media="screen" />
	
	</head>

	<body>
		<center>
			<br /><br /><br /><div align="center" class="sound">
				<audio src="<?=$_GET['src']?>" controls autoplay autobuffer></audio><br /><br />
				<span class="listen">Listen to the music . . . <i>(Download <a target="_blank" href="?type=download&src=<?=$_GET['src2']?>">here</a>)</i></span>
			</div>
	</body>
</html>