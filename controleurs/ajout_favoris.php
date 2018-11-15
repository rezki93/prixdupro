<?php


if(isset($_SESSION['con_id']) )
{
	if(isset($_GET['ref']) && isset($_GET['user']) )
	{
		$user = $_GET['user'];
		$ref = $_GET['ref'];
		
		$chaine = "INSERT INTO `FAVORIS` 
				   VALUES ('".$user."', '".$ref."')";	
		$req = mysql_query($chaine);
		echo $req;
	}
}




?>