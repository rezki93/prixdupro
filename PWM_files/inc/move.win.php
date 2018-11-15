<?php

///////////////////////////////////// 
/*
	PHP Web Manager: Reloaded
	Fichier: move.win.php
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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=strtolower($langue)?>" lang="<?=strtolower($langue)?>"> 
	<head> 
	
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
		<meta name="desciption" content="PHP Web Manager: Reloaded - WebFTP" />
		<meta name="keywords" content="client ftp, ftp, php web manager, reloaded, simplegeek, manager, php, web, html, admin, password, filezilla" />
		<meta name="author" content="SimpleGeek" />
		
		<title>PHP Web Manager v<?=$version?></title>
		
		<link href="<?=$PWM_FILES?>css/copiemove.css" rel="stylesheet" type="text/css" media="screen" />

</head>

	<body>
	
		<table class="head" width="99%" cellpadding="5">
			<tr>
				<td width="70%"><?=$language[$langue]['MOVE_HEAD'].path2link($root)?></td>
			</tr>
		</table>

		<center>
			<div class="title"><?=$language[$langue]['MOVE_TITLE']?></div><br/>
				<div class="center">

				<?php

				sort($ftp);
				$pd = rmslashes(dirname($root));
					echo '<a href="?type=move&root='.$pd.'"><img src="'.$PWM_FILES.'images/prev.png" border="0" alt="'.$language[$langue]['LISTING_PREV'].'" />&nbsp;..</a><br /><br />';

				foreach($ftp as $file)
				{
					$fp = $root.'/'.$file;
					$filename = $file;

					if(strlen($filename) > 33)
					{
						$title = ' title="'.$filename.'"';
						$filename = substr($filename,0,29) . ' ...';
					}
					else 
						$title = null;

					if(preg_match('`^'.quotemeta($fp).'/`', dirname($_SERVER['SCRIPT_FILENAME']).'/'))
					{
						$filename = '<font color="red">'.$filename.'</font>';
					}

					echo '<img src="'.$PWM_FILES.'images/rep.png" alt="'.$language[$langue]['LISTING_DIR'].'" />&nbsp;<a href="?type=move&root='.$fp.'"'.$title.'>'.$filename.'</a><br/><br/>';
				}
				
				?>
				
				
			</div>
			<table width="90%">
					<tr>
						<td>
							<input type="button" value="<?=$language[$langue]['MOVE_SUBMIT']?>" onclick="send()" />
						</td>
						<td align="right">
							<input type="button" value="<?=$language[$langue]['MOVE_RETURN']?>" onclick="self.close()" />
						</td>
					</tr>
			</table>
		</center>

		<script type="text/javascript">
			function send() {
				if(opener.count > 0)
				{
					opener.newType.value = 'move4select';
					opener.newRoot.value = '<?=addslashes($root)?>';
					opener.act.submit();
					self.close();
				}
				else 
					alert("<?=$language[$langue]['MOVE_NOFILE']?>");
					self.close();
			}
		</script>
	</body>
</html>