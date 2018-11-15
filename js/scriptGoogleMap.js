	//initilaisation des variables
	var map = null;
	var geocoder = null;
  
function load() {
	alert("la fonction load est lancé");
	if (GBrowserIsCompatible()) {
	
		//nouvel objet de type Map	
		map = new GMap2(document.getElementById("map"));
		
		//centralisa de la carte initiale. 
		//Emplacement fait en fonction des code Longitude et Latitude
		map.setCenter(new GLatLng(48.9, 2.3), 13);
		
		//affichage des contrôleurs de zoom, ...
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
		
		//nouvel Obget de géocodeur
		geocoder = new GClientGeocoder();
	}
   
   
  //récupération des valeurs des champs d'adresse et nom    
	var adresse = $('#adresse').text();
	var nom = $('#nom').text();
     
	if (geocoder) {
		alert("geocoder = true");
		geocoder.getLatLng(
			adresse,function(point) {
				//si l'adresse n'existe pas on l'affiche
				if (!point) {
					alert(adresse + " introuvable");
				} else {
					alert("on est censé affiché");
					//centrer la carte sur les coordonnées. 
					//le chiffre 13 correspond au zoom de visualisation de la carte
					map.setCenter(point, 13);
					
					//initialisation du pointer (flêche rouge)
					var marker = new GMarker(point);
					map.addOverlay(marker);
					
					//création des informations affichées sur le pointeur
					marker.openInfoWindowHtml(nom +"<br />"+adresse);
				}
			}
		);
	}
}
  
// appelle de la fonction d'initailisation et de chargement de la page dès que google est ok.   
google.setOnLoadCallback(load)
     
     
 
