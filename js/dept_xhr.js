
/**
 * Lister les départements d'une région avec un objet
 * XMLHTTPRequest.
 */
/* Création de la variable globale qui contiendra l'objet XHR */
var requete = null;
/**
 * Fonction privée qui va créer un objet XHR.
 * Cette fonction initialisera la valeur dans la variable globale définie
 * ci-dessus.
 */
function creerRequete()
{
    try
    {
        /* On tente de créer un objet XmlHTTPRequest */
        requete = new XMLHttpRequest();
    }
    catch (microsoft)
    {
        /* Microsoft utilisant une autre technique, on essays de créer un objet ActiveX */
        try
        {
            requete = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch(autremicrosoft)
        {
            /* La première méthode a échoué, on en teste une seconde */
            try
            {
                requete = new ActiveXObject('Microsoft.XMLHTTP');
            }
            catch(echec)
            {
                /* À ce stade, aucune méthode ne fonctionne... mettez donc votre navigateur à jour <!-- s;) --><img src="{SMILIES_PATH}/icon_wink.gif" alt=";)" title="Wink" /><!-- s;) --> */
                requete = null;
            }
        }
    }
    if(requete == null)
    {
        alert('Impossible de créer l\'objet requête,\nVotre navigateur ne semble pas supporter les object XMLHttpRequest.');
    }
}
/**
 * Fonction privée qui va mettre à jour l'affichage de la page.
 */
function actualiserDepartements(id)
{
    var listeDept = requete.responseText;
    var blocListe = document.getElementById(id);
    blocListe.innerHTML = listeDept;
}

/**
 * Fonction publique appelée par la page affichée.
 * Cette fonction va initialiser la création de l'objet XHR puis appeler
 * le code serveur afin de récupérer les données à modifier dans la page.
 */
 


function getDepartements(idr, idd, bloc)
{
    /* Si il n'y a pas d'identifiant de région, on fait disparaître la seconde liste au cas où elle serait affichée */
    if(idr == 'vide')
        document.getElementById(bloc).innerHTML = '';
    else
    {
        /* À cet endroit précis, on peut faire apparaître un message d'attente */
        var blocListe = document.getElementById(bloc);
        blocListe.innerHTML = "Veuillez patienter...";
		
        /* On crée l'objet XHR */
        creerRequete();
		
		/* Définition du fichier de traitement */
		var section = "";
		if(bloc=="bloc_search_departements")
			section = "search"
		if(bloc=="bloc_depot_departements")
			section = "depot"
	
		var url = 'index.php?page=departements&section='+section+'&idr='+idr+'&idd='+idd;
			
		
		
        /* Envoi de la requête à la page de traitement */
        requete.open('GET', url, true);
		
        /* On surveille le changement d'état de la requête qui va passer successivement de 1 à 4 */
        requete.onreadystatechange = function()
        {
            /* Lorsque l'état est à 4 */
            if(requete.readyState == 4)
            {
                /* Si on a un statut à 200 */
                if(requete.status == 200)
                {
                    /* Mise à jour de l'affichage, on appelle la fonction apropriée */
                    actualiserDepartements(bloc);
                }
            }
        };
        requete.send(null);
    }
}



function ajout_favoris(id_user,id_annonce){
		var blocListe = document.getElementById('bloc-fav');
        blocListe.innerHTML = "Veuillez patienter...";
		
        /* On crée l'objet XHR */
        creerRequete();
		
		/* Définition du fichier de traitement */
		var section = "";
		
		var url = 'index.php?page=ajout_favoris&ref='+id_annonce+'&user='+id_user;

		
        /* Envoi de la requête à la page de traitement */
        requete.open('GET', url, true);
		
        /* On surveille le changement d'état de la requête qui va passer successivement de 1 à 4 */
        requete.onreadystatechange = function()
        {
            /* Lorsque l'état est à 4 */
            if(requete.readyState == 4)
            {
                /* Si on a un statut à 200 */
                if(requete.status == 200)
                {
                    /* Mise à jour de l'affichage, on appelle la fonction apropriée */
                    blocListe.innerHTML = "L'annonce a été ajouté a vos favoris";
                }
            }
        };
        requete.send(null);
    
}