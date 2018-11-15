<?php

///////////////////////////////////// GPL //////////////////////////////////////
/*

  This file is part of PHP Web Manager.
  Copyright (c) 2010-2011 SimpleGeek. All rights reserved.
  http://www.simplegeek.fr/

  PHP Web Manager is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  PHP Web Manager is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
  
*/
/////////////////////////////////////////////////////////////////////////////////

/*
	PHP Web Manager: Reloaded
	Fichier: copy.win.php
	Dernière modification: 10/06/2010
	Copyright (C) SimpleGeek 2010-2011
*/

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
				<td width="70%"><?=$language[$langue]['COPY_HEAD'].path2link($root)?></td>
			</tr>
		</table>

		<center>
			<div class="title"><?=$language[$langue]['COPY_TITLE']?></div><br/>
				<div class="center">

				<?php

				sort($ftp);
				$pd = rmslashes(dirname($root));
					echo '<a href="?type=copy&root='.$pd.'"><img src="'.$PWM_FILES.'images/prev.png" border="0" alt="'.$language[$langue]['LISTING_PREV'].'" />&nbsp;..</a><br /><br />';

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

					echo '<img src="'.$PWM_FILES.'images/rep.png" alt="'.$language[$langue]['LISTING_DIR'].'" />&nbsp;<a href="?type=copy&root='.$fp.'"'.$title.'>'.$filename.'</a><br/><br/>';
				}
				
				?>
				
				
			</div>
			<table width="90%">
					<tr>
						<td>
							<input type="button" value="<?=$language[$langue]['COPY_SUBMIT']?>" onclick="send()" />
						</td>
						<td align="right">
							<input type="button" value="<?=$language[$langue]['COPY_RETURN']?>" onclick="self.close()" />
						</td>
					</tr>
			</table>
		</center>

		<script type="text/javascript">
			function send() {
				if(opener.count > 0)
				{
					opener.newType.value = 'copy4select';
					opener.newRoot.value = '<?=addslashes($root)?>';
					opener.act.submit();
					self.close();
				}
				else 
					alert("<?=$language[$langue]['COPY_NOFILE']?>");
					self.close();
			}
		</script>
	</body>
</html>