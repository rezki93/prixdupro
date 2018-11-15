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
	Fichier: newconfig.win.php
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
		
		<link href="<?=$PWM_FILES?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript" src="<?=$PWM_FILES?>global_<?=strtolower($langue)?>.js"></script>
		
	</head>

	<body>
	
		<table class="head" width="99%" cellpadding="5">
			<tr>
				<td><?=$language[$langue]['CONFIG_HEAD']?></td>
				<td align="right"><a href="?type=newconfig&update" class="inp" title="<?=$language[$langue]['CONFIG_CHECK']?>"><?=$language[$langue]['CONFIG_UPDATE']?></a></td>
				<td width="1"></td>
			</tr>
		</table>
			<br/><br/><br/>
			
		<div class="newconfig" style="margin:9px; <?php if(!isset($_GET['info'])) echo ('background: url(\'./PWM_files/images/config.png\') right center no-repeat;'); ?>">
			<h3><?=$language[$langue]['CONFIG_TITLE']?></h3><br/>

			<?php
				if(isset($_GET['info']))
				{
					echo ($language[$langue]['CONFIG_BIND_INFO']);
					exit;
				}
			
				elseif(isset($_GET['s']))
				{
					echo '<i id="cf"><font color="green">'.$language[$langue]['CONFIG_SAVED'].'</font></i><script type="text/javascript">opener.location.reload();setTimeout(\'document.getElementById("cf").innerHTML = "'.$language[$langue]['CONFIG_TODO'].'"\',2500);</script>';
				}
				
				elseif(isset($_GET['update']))
				{
					$patern_version = '/version = '.$version.'/';
					$open = fopen($update,'r');
					$get = fread($open, 13);
					if(preg_match($patern_version, $get))
					{
						echo '<i id="cf">'.$language[$langue]['CONFIG_UPDATE_OK'].'</i><script type="text/javascript">setTimeout(\'document.getElementById("cf").innerHTML = "'.$language[$langue]['CONFIG_TODO'].'"\',3000);</script>';
					}
					else
					{
						echo '<i id="cf">'.$language[$langue]['CONFIG_UPDATE_NEW'].'</i><script type="text/javascript">setTimeout(\'document.getElementById("cf").innerHTML = "'.$language[$langue]['CONFIG_TODO'].'"\',3000);</script>';
					}
				}
				
				else
				{
					echo '<i id="cf">'.$language[$langue]['CONFIG_TODO'].'</i>';
				}
				
			?>
		
			<br/><br/>

			<form action="?type=newconfig" method="post" name="config" style="margin:11px;">
				<?=$language[$langue]['CONFIG_NEWPASS']?><input id="newpass" type="text" name="newpass" value="" size="42" class="reg"/>
				<br/><br/><br/>

			<table width="100%" cellpadding="5" cellspacing="2">
				<tr>
					<td valign="top"><?=$language[$langue]['CONFIG_DISPLAY']?></td>
					<td valign="top" colspan="2"><input type="checkbox" name="fast" value="1" <?php if($fast_display) echo 'checked'; ?>/> (<?=$language[$langue]['CONFIG_VDISPLAY']?>) </td>
				</tr>
				<tr>
					<td valign="top"><?=$language[$langue]['CONFIG_HL']?></td>
					<td valign="top" colspan="2"><input type="checkbox" name="sh" value="1" <?php if($syntax_highlighting) echo 'checked'; ?>/> (<?=$language[$langue]['CONFIG_VHL']?>) </td>
				</tr>
				<tr>
					<td valign="top"><?=$language[$langue]['CONFIG_OVERWRITE']?></td>
					<td valign="top" colspan="2"><input type="checkbox" name="erase" value="1" <?php if($overwrite_files) echo 'checked'; ?>/> (<?=$language[$langue]['CONFIG_VOVERWRITE']?>) </td>
				</tr>
				<tr>
					<td valign="top"><?=$language[$langue]['CONFIG_PING']?></td>
					<td valign="top" colspan="2"><input type="checkbox" name="ping" value="1" <?php if($ping) echo 'checked'; ?>/> (<?=$language[$langue]['CONFIG_VPING']?>)</td>
				</tr>
				<tr>
					<td valign="top"><?=$language[$langue]['CONFIG_BIND']?></td>
					<td valign="top" colspan="2"><input type="checkbox" name="bind" value="1" <?php if($binding) echo 'checked'; ?>/> (<?=$language[$langue]['CONFIG_VBIND']?>)</td>
				</tr>
				<tr>
					<td valign="top"><?=$language[$langue]['CONFIG_SORT']?></td>
					<td valign="top" width="200">
												  &nbsp;<select name="sort">
													<option value="0"<?php if($default_sort[0] == 0) echo ' selected';?>><?=$language[$langue]['CONFIG_SORT_NAME']?></option>
													<option value="1"<?php if($default_sort[0] == 1) echo ' selected';?>><?=$language[$langue]['CONFIG_SORT_SIZE']?></option>
													<option value="2"<?php if($default_sort[0] == 2) echo ' selected';?>><?=$language[$langue]['CONFIG_SORT_DATE']?></option>
													<option value="3"<?php if($default_sort[0] == 3) echo ' selected';?>><?=$language[$langue]['CONFIG_SORT_PERM']?></option>
													<option value="4"<?php if($default_sort[0] == 4) echo ' selected';?>><?=$language[$langue]['CONFIG_SORT_TYPE']?></option>
												  </select>
					</td>
					<td valign="top">
						<input id="sorta" type="radio" value="a" name="sorts"<?php if($default_sort[1] == 'a') echo ' checked';?>/><label for="sorta"><?=$language[$langue]['CONFIG_SORT_ASC']?></label></i><br/>
						<input id="sortd" type="radio" value="d" name="sorts"<?php if($default_sort[1] == 'd') echo ' checked';?>/><label for="sortd"><?=$language[$langue]['CONFIG_SORT_DESC']?></label></i>
					</td>
				</tr>
			</table>

			<br/>

				<input type="submit" value="<?=$language[$langue]['CONFIG_SUBMIT']?>" />				
			</form>
		</div>
	</body>
</html>