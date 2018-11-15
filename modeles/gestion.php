<?php

function recuperer_toutes_annonces()
{
		$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis php5.3
        $annonces = array();
		
		$chaine="SELECT *
		FROM ANNONCES,USERS
		where ANNONCES.id_user=USERS.id_user
		and ANNONCES.id_user=".$_SESSION['con_id']."
		ORDER BY ANNONCES.date_annonce DESC;
		";	
		
		$req = mysqli_query($link,$chaine);
		
        while ($data = mysqli_fetch_assoc($req)){
            $annonces[] = $data;
        }
 
        return $annonces;
}


function recuperer_favoris()
{
		$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis php5.3
        $favoris= array();
		
		$chaine="SELECT *
		FROM FAVORIS,ANNONCES
		where FAVORIS.id_user=".$_SESSION['con_id']."
		and FAVORIS.id_annonce=ANNONCES.id_annonce
		ORDER BY FAVORIS.id_annonce DESC;
		";	
		
		$req = mysqli_query($link,$chaine);
        while ($data = mysqli_fetch_assoc($req)){
            $favoris[] = $data;
        }
 
        return $favoris;
}