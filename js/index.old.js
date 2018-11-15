$(function(){

// Accordion
$("#accordion").accordion({ header: "h3" });
// Tabs
$('#tabs').tabs();
// Dialog      
$('#dialog').dialog({
  autoOpen: false,
  width: 600,
  buttons: {
    "Ok": function() { 
      $(this).dialog("close"); 
    }, 
    "Cancel": function() { 
      $(this).dialog("close"); 
    } 
  }
});
// Dialog Link
$('#dialog_link').click(function(){
  $('#dialog').dialog('open');
  return false;
});
// Datepicker
$('#datepicker').datepicker({
  inline: true
});
// Slider
$('#slider').slider({
  range: true,
  values: [17, 67]
});
// Progressbar
$("#progressbar").progressbar({
  value: 20 
});
//hover states on the static widgets
$('#dialog_link, ul#icons li').hover(
  function() { $(this).addClass('ui-state-hover'); }, 
  function() { $(this).removeClass('ui-state-hover'); }
);
});

//verifie si l'adresse est un email
function verifMail(m) { // vérif validité email par REGEXP
  var email = m;
    var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]{2,}[.][a-zA-Z]{2,3}$/
    return (reg.exec(email)!=null)
}

//verifie si le numero est un numero de telephone
function verifTel(tel) {
  if( (tel.length != 10) || ( isNaN(tel) ) ) 
    return false; 
  else
    return true;
 }
 
//verifie si nb ets un nombre de taille correspondant
 function verifNombre(nb,taille) {
  if( (nb.length != taille) || ( isNaN(nb) ) ) 
    return false; 
  else
    return true;
 }
 
//verifie que le mot de passe fait 6 caracteres
 function verifPassword(psw) {
  
  if( (psw.length < 6) ) 
    return false; 
  else
    return true;
 }

 
function verifDepartement(){
  var valid = false;
  if ( jQuery("#departement").val()!== "--" )
    valid = true;
  return valid;
}

function verifRegion(){
  var valid = false;
  if ( jQuery("#region").val()!== "--" )
    valid = true;
  return valid;
}


function verifEnergie(){
  var valid = false;
  if ( jQuery("#energie_annonce").val()!== "--" )
    valid = true;
  return valid;
}


function verifBoite(){
  var valid = false;
  if ( jQuery("#boite_annonce").val()!== "--" )
    valid = true;
  return valid;
}


function verifCategorie(){
  var valid = false;
  if ( jQuery("#cat_annonce").val() != "--" )
    valid = true;
  return valid;
}

//verifie que le champ est rempli
function verifVide(s){
  var valid = false;
  if ( s != "")
    valid = true;
  return valid;
}


//validation formulaire pour l'inscription
jQuery("#inscription").live('click',function(){
    retireBordureRougeCreationUser();
    var res_mail = verifMail(jQuery("#mail").val());
    var res_tel = verifTel(jQuery("#tel").val());
    var res_psw = verifPassword(jQuery("#password").val());
    var res_pre = verifVide(jQuery("#prenom").val());
    var res_nom = verifVide(jQuery("#nom").val());
    var res_vil = verifVide(jQuery("#ville").val());
    var res_adr = verifVide(jQuery("#adresse").val());
    var res_dep = verifDepartement();
    var res_reg = verifRegion();
    
    var valid = res_mail && res_tel && res_psw && res_pre && res_nom && res_vil && res_adr && res_dep && res_reg ;
    
    if(res_mail == false)
      jQuery("#mail").css("border-color","#CA0036");
      
    if(res_tel == false)
      jQuery("#tel").css("border-color","#CA0036");
      
    if(res_psw == false)
      jQuery("#password").css("border-color","#CA0036");
      
    if(res_pre == false)
      jQuery("#prenom").css("border-color","#CA0036");
    
    if(res_nom == false)
      jQuery("#nom").css("border-color","#CA0036");
    
    if(res_adr == false)
      jQuery("#adresse").css("border-color","#CA0036");
    
    if(res_vil == false)
      jQuery("#ville").css("border-color","#CA0036");
      
    if(res_dep == false)
      jQuery("#departement").css("border-color","#CA0036"); 
      
    if(res_reg == false)
      jQuery("#region").css("border-color","#CA0036"); 
          
    if(valid)
      document.creation_compte.submit();
    else
      jQuery("#indication_erreurs").css("display","block");
      
});


jQuery("#valider_recherche").live('click',function(){
  var pmin = jQuery("#search_prixmin").val();
  var pmax = jQuery("#search_prixmax").val();
  jQuery("#search_prixmin").css("border-color","#A4A4A4");
  jQuery("#search_prixmax").css("border-color","#A4A4A4");
  if( (pmin!='--') && (pmax!='--') && (pmin > pmax) )
  {
    jQuery("#search_prixmin").css("border-color","#CA0036");
    jQuery("#search_prixmax").css("border-color","#CA0036");
  }
  else
    document.rechercher.submit();
});


//validation du formulaire pour le depot d'annonce
jQuery("#deposer_annonce").live('click',function(){
  retireBordureRougeDepotAnnonce();
  var res_tit = verifVide(jQuery("#titre_annonce").val());
  var res_pri = verifVide(jQuery("#prix_annonce").val()) && (!isNaN(jQuery("#prix_annonce").val()));
  var res_cat = verifCategorie();
  var res_des = verifVide(jQuery("#desc_annonce").val());

  var valid = res_tit && res_pri && res_cat && res_des ;
  
  if(res_tit == false)
    jQuery("#titre_annonce").css("border-color","#CA0036");
  if(res_pri == false)
    jQuery("#prix_annonce").css("border-color","#CA0036");
  if(res_cat == false)
    jQuery("#cat_annonce").css("border-color","#CA0036");
  if(res_des == false)
    jQuery("#desc_annonce").css("border-color","#CA0036");
  
  if(jQuery("#cat_annonce").val() == 1 ){
    var res_ann = verifNombre(jQuery("#annee_annonce").val(),4)
    if(res_ann == false)
      jQuery("#annee_annonce").css("border-color","#CA0036");
    
    var res_km = (!isNaN(jQuery("#km_annonce").val())) && verifVide(jQuery("#km_annonce").val())   ; 
    if(res_km == false)
      jQuery("#km_annonce").css("border-color","#CA0036");
      
      
    var res_ene = verifEnergie(jQuery("#energie_annonce").val());
    if(res_ene == false)
      jQuery("#energie_annonce").css("border-color","#CA0036");
      
    var res_boi = verifBoite(jQuery("#boite_annonce").val());
    if(res_boi ==false)
      jQuery("#boite_annonce").css("border-color","#CA0036");  
      
      
    valid = valid && res_ann && res_km && res_ene && res_boi;
  }
  
  
  
  if(valid){
      jQuery("#loader").css("display","block");
      document.depot_annonce.submit();
  }
  else
    jQuery("#indication_erreurs2").css("display","block");
  
});

//validation formulaire pour l'envoi du message a l'annonceur
jQuery("#envoyer_message").live('click',function(){
  retireBordureRougeEnvoiMessage();
  var res_nom = verifVide(jQuery("#sender_name").val());
  var res_mail = verifMail(jQuery("#sender_email").val());
  // var res_msg = verifVide(jQuery("#sender_msg").val());
  var res_msg = true;

  var valid = res_nom && res_mail && res_msg;
  
  if(res_nom == false)
    jQuery("#sender_name").css("border-color","#CA0036");
  if(res_mail == false)
    jQuery("#sender_email").css("border-color","#CA0036");
  if(res_msg == false){
  jQuery("#sender_msg").css("border-color","#CA0036");
  }
  
  if(valid)
      document.envoi_message.submit();

});


//retire les bordure rouge d'erreur 
function retireBordureRougeConnexionUser2(){
  jQuery("#con_password2").css("border-color","#A4A4A4");
  jQuery("#con_login2").css("border-color","#A4A4A4");
}

//retire les bordure rouge d'erreur 
function retireBordureRougeConnexionUser1(){
  jQuery("#con_password").css("border-color","#A4A4A4");
  jQuery("#con_login").css("border-color","#A4A4A4");
}

//retire les bordure rouge d'erreur 
function retireBordureRougeDepotAnnonce(){
  jQuery("#titre_annonce").css("border-color","#A4A4A4");
  jQuery("#prix_annonce").css("border-color","#A4A4A4");
  jQuery("#cat_annonce").css("border-color","#A4A4A4");
  jQuery("#desc_annonce").css("border-color","#A4A4A4");  
  jQuery("#energie_annonce").css("border-color","#A4A4A4");  
  jQuery("#boite_annonce").css("border-color","#A4A4A4");  
  jQuery("#annee_annonce").css("border-color","#A4A4A4");  
  jQuery("#km_annonce").css("border-color","#A4A4A4");  
  
}

//retire les bordure rouge d'erreur 
function retireBordureRougeEnvoiMessage(){
  jQuery("#sender_email").css("border-color","#A4A4A4");
  jQuery("#sender_msg").css("border-color","#A4A4A4");
  jQuery("#sender_name").css("border-color","#A4A4A4");
}

 //retire les bordure rouge d'erreur
function retireBordureRougeCreationUser(){
  jQuery("#mail").css("border-color","#A4A4A4");
  jQuery("#tel").css("border-color","#A4A4A4");
  jQuery("#password").css("border-color","#A4A4A4");
  jQuery("#prenom").css("border-color","#A4A4A4");
  jQuery("#nom").css("border-color","#A4A4A4");
  jQuery("#adresse").css("border-color","#A4A4A4");
  jQuery("#ville").css("border-color","#A4A4A4");
  jQuery("#departement").css("border-color","#A4A4A4");
  jQuery("#region").css("border-color","#A4A4A4");
  
}


//Validation formulaire connexion user dans la barre
jQuery("#connexion_button2").live('click',function(){
  retireBordureRougeConnexionUser2();
  var res_psw = verifVide(jQuery("#con_password2").val());
  var res_log = verifMail(jQuery("#con_login2").val());

  var valid = res_log && res_psw;
  
  if(res_log == false)
    jQuery("#con_login2").css("border-color","#CA0036");
  if(res_psw == false)
    jQuery("#con_password2").css("border-color","#CA0036");

  
  if(valid)
      document.connexion_user2.submit();
  
  return false;
});

//Validation formulaire Connexion user en haut a droite
jQuery("#connexion_button").live('click',function(){
  retireBordureRougeConnexionUser1();
  var res_psw = verifVide(jQuery("#con_password").val());
  var res_log = verifMail(jQuery("#con_login").val());
  var valid = res_log && res_psw;
  
  if(res_log == false)
    jQuery("#con_login").css("border-color","#CA0036");
  if(res_psw == false)
    jQuery("#con_password").css("border-color","#CA0036");

  if(valid)
      document.connexion_user.submit();
  return false;
});

//Affiche les blocs liés au voitures, motos et caravannes pour la recherche 
jQuery("#search_categorie").live('change',function(){
  var test = jQuery("#search_categorie").val();
  
  jQuery("#bloc_annee").css("display","none");
  jQuery("#bloc_km").css("display","none");
  jQuery("#bloc_energie_boite").css("display","none");
    
  if(test == 1 || test == 2 || test == 3 ){
    jQuery("#bloc_annee").css("display","block");
    if(test == 1 || test == 2){
      jQuery("#bloc_km").css("display","block");
      if(test == 1)
        jQuery("#bloc_energie_boite").css("display","block");  
    }
  }
});

//Affiche les blocs liés au voitures, motos et caravannes pour le depot d'annonces
jQuery("#cat_annonce").live('change',function(){
  var test = jQuery("#cat_annonce").val();
  
  jQuery("#bloc_depot_annee").css("display","none");
  jQuery("#bloc_depot_km").css("display","none");
  jQuery("#bloc_depot_energie").css("display","none");
  jQuery("#bloc_depot_boite").css("display","none");
    
  if(test == 1 || test == 2 || test == 3 ){
    jQuery("#bloc_depot_annee").css("display","block");
    if(test == 1 || test == 2){
      jQuery("#bloc_depot_km").css("display","block");
      if(test == 1){
        jQuery("#bloc_depot_boite").css("display","block");  
        jQuery("#bloc_depot_energie").css("display","block");
  
      }
    }
  }
});

//affiche le champs pour la 2eme photo une fois qu'on a rentré la premiere
jQuery("#photo1").live('change',function(){
  jQuery("#bloc_photo2").css("display","block");
});

//affiche le champs pour la 3eme photo une fois qu'on a rentré la deuxieme
jQuery("#photo2").live('change',function(){
  jQuery("#bloc_photo3").css("display","block");
});

function retireDepartements(){
  for(i = 1; i <= 95; i++){
    jQuery("#osd"+i).css("display","none");
  }
  jQuery("#osd971").css("display","none");
  jQuery("#osd972").css("display","none");
  jQuery("#osd973").css("display","none");
  jQuery("#osd974").css("display","none");
  jQuery("#osd976").css("display","none");
}


function modifier_mdp(){
  var erreur = false;
  
  var mdp = prompt('Tapez votre mot de passe actuel','');
  if(mdp == "" || mdp == null)
    erreur = true;
  
  if(erreur == false)
    var mdp2 = prompt('Tapez votre nouveau mot de passe ','');
    
  if(mdp2 == "" || mdp2 == null)
    erreur = true;
    
  if(erreur == false){
    jQuery("#block-loader-modification_mdp").css("display","block");
    jQuery.ajax({
      'url': './index.php?page=gestion&rub=modif_mdp&mdp='+mdp+'&mdp2='+mdp2 ,
      'type': 'GET',
      'dataType':'text',
      'success':   function(res) {
          jQuery("#block-loader-modification_mdp").css("display","none");
          alert("resultat : "+res);
          if(res == true )
            alert("Votre mot de passe a bien &eacute;t&eacute; modifi&eacute;<br>Nous vous avons envoy&eacute; un email");
          else
            alert(res);
      }
    });
  }

}

function renvoyer_mdp(){
  var mail = prompt("Tapez votre adresse email");
  
  if(mail != null){
    if(mail != ""){
      jQuery.ajax({
        'url': './index.php?page=renvoi_mdp&mail='+mail ,
        'type': 'GET',
        'dataType':'html',
        'success':   function(res) {
          $("#message_connexion").empty();
          $("#message_connexion").slideUp('fast')
          $("#message_connexion").append(res);
          // jQuery("#message_connexion").css("border-color","green");
          $("#message_connexion").slideDown('slow')
          // jQuery("#message_connexion").css("color","green");
        }
      });
    }
    else{
      $("#message_connexion").empty();
      $("#message_connexion").slideUp('fast')
      $("#message_connexion").append("<p style='color:red;border : 2px solid red'>Veuillez entrer une adresse email</p>");
      // jQuery("#message_connexion").css("border-color","red");
      $("#message_connexion").slideDown('slow')
      // jQuery("#message_connexion").css("color","red");
    }
  }
  
}

