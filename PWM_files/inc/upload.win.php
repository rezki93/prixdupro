<?php

///////////////////////////////////// 
/*
	PHP Web Manager: Reloaded
	Fichier: upload.win.php
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
		
		<title>PHP Web Manager v<?=$version?></title>
		
		<link href="<?=$PWM_FILES?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
		
	</head>

	<body>
	
		<table class="head" width="99%" cellpadding="5">
			<tr>
				<td width="70%"><?=$language[$langue]['UPLOAD_TITLE']?></td>
				<td width="29%" align="right"><?php if($max = ini_get('upload_max_filesize')) echo $language[$langue]['UPLOAD_MAX_SIZE'].$max; ?></td>
				<td width="01%"></td>
			</tr>
		</table>

		<script type="text/javascript">

		function Submit() {
		var All = document.forms['upload'].getElementsByTagName('input');

		for(i=0;i<All.length;i++)
			{
			if( (All[i].value !== '' && All[i].name == 'userfile[]') || ( All[i].name == 'url' && All[i].value !== '' && All[i].value !== 'http://' && All[i].value !== "<?=$language[$langue]['UPLOAD_GET_URL']?>") )
				{
				return true;
				}
			}

		return false;
		}

		function basename (path) { return path.replace( /.*\//, '' ); }
		
		<?php

		if(isset($_GET['ok']))
			echo "opener.location.reload();\n";
		elseif(isset($_GET['error']))
			echo "window.location.reload();\n";

		?>
		</script>

		<div class="global2" id="upload">
			<span class="title"><?=$language[$langue]['UPLOAD_SELECT']?></span><br/>

			<form onsubmit="return Submit();" action="?type=upload&root=<?=$root?>" style="margin:10px;" method="post" enctype="multipart/form-data" name="upload">
				<table width="94%">
					<tr>
						<td valign="top">
							<input type="file" name="userfile[]" size="40" class="up"><br />
							<input type="file" name="userfile[]" size="40" class="up"><br />
							<input type="file" name="userfile[]" size="40" class="up"><br />
							<input type="file" name="userfile[]" size="40" class="up"><br />
							<input type="file" name="userfile[]" size="40" class="up"><br />
							<input type="file" name="userfile[]" size="40" class="up"><br />
							<input type="file" name="userfile[]" size="40" class="up"><br />
						</td>
						<td width="100"></td>
						<td valign="top" align="left">
							<input type="text" onfocus="if(this.value == '<?=$language[$langue]['UPLOAD_GET_URL']?>') this.value = 'http://';this.select()" onblur="if(this.value == '' || this.value == 'http://') this.value = '<?=$language[$langue]['UPLOAD_GET_URL']?>';" onkeyup="document.getElementById('upname').value = basename(this.value)" value="<?=$language[$langue]['UPLOAD_GET_URL']?>" name="url" class="upd" size="37"/>
			<?='<img src="'.$PWM_FILES.'images/goBack.png" alt="" /><br /><br />'?>
							<input type="text" class="upd" name="nameOf" id="upname" onfocus="if(this.value == '<?=$language[$langue]['UPLOAD_GET_NAME']?>') this.value = '';"  value="<?=$language[$langue]['UPLOAD_GET_NAME']?>" name="url" class="upd" size="37"/>
						</td>
					</tr>
				</table>
				<br />
				<input type="submit" value="<?=$language[$langue]['UPLOAD_SUBMIT']?>"/>
			</form>
			
		<table class="foot" width="99%" cellpadding="5">
			<tr>
				<td width="70%" align="left">&nbsp;<?=$language[$langue]['UPLOAD_FOLDER'].path2link($root)?></td>
				<td width="20%" align="right"><?=$language[$langue]['UPLOAD_OVERWRITE']?><?php if($overwrite_files) echo ('<i>'.$language[$langue]['UPLOAD_OW_ACT'].'</i>'); else echo ('<i>'.$language[$langue]['UPLOAD_OW_DEACT'].'</i>'); ?></td>
				<td width="01%" align="right"></td>
			</tr>
		</table>
		
		</div>
	</body>
</html>