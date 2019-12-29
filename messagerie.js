var discussion;
var idDestinataire;
var T_GLOBAL = false;
function ouvrirDiscussion(id)
{
	discussion = id;

	$("#contenuMessagerie").hide();
	$("#contenuMessagerie").empty();
	$("#EnvoyerMessagerie").empty();
	$("#contenuMessagerie").load("../message/ouvrirDiscussion.php?id="+id);
	$.post("../message/chercherDestinataire.php",{discussion:discussion}, function(data){
        if(data.erreur=="no"){
            idDestinataire = data.destinataire;
        }
    },"json");
	$("#EnvoyerMessagerie").append("Répondre:<br /><textarea id='content' name='content' placeholder='Réponse'></textarea><button id='repondreMessage' name='repondreMessage' class='btn btn-block btn-primary' onclick='envoyerMessage();'><div id='idDestinataire'></div><i class='icon-white icon-arrow-up'></i> Envoyer</button></a>");
	$("#btnRetour").append("<a onclick='retour();' class='btn btn-block btn-primary'>Boîte de réception</a>");
	$("#contenuMessagerie").fadeIn();
	refreshDiscussion(id);
}

function refreshDiscussion(id)
{
  discussion = id;
  $.ajax({
    type: 'POST',
    dataType:"json",
    url: '../message/verifDiscussion.php?id='+id,
    success: function(data){
      if(data.message>0){
        $.post("../message/ajouterMessage.php?id="+id,{discussion:discussion}, function(data){
        if(data.erreur=="no"){
        	if(data.message != "") 
        	{
            	$("#contenuMessagerie").prepend(data.message);
        	}
          }
    	},"json");
      }
    }
  });
  T_GLOBAL = setTimeout('refreshDiscussion('+id+')',2000);
}

function retour()
{
	$("#btnRetour").empty();
	$("#EnvoyerMessagerie").empty();
	$("#contenuMessagerie").fadeOut(200);
	$("#contenuMessagerie").hide();
	$("#contenuMessagerie").empty();
	$("#contenuMessagerie").load("../message/recupMessage.php");
	$("#EnvoyerMessagerie").append("Envoyer un message:<br /><input id='instant' name='instant' type='text' placeholder='@Nom d utilisateur' /><button id='envoyerMessage' name='envoyerMessage' class='btn btn-block btn-primary'><i class='icon-white icon-arrow-up'></i> Envoyer</button></a>");
	$("#contenuMessagerie").fadeIn();
	if(T_GLOBAL) {
	  clearTimeout(T_GLOBAL);
	  T_GLOBAL = false;
	}
}

function envoyerMessage()
{
	message = $("#content").val();
    $.post("../message/envoyerMessage.php",{message:message,discussion:discussion,idDestinataire:idDestinataire}, function(data){
        if(data.erreur=="no"){
            $("#content").val("");
            $("#contenuMessagerie").prepend(data.message);
          }
    },"json");
	
}

function envoyerUser(){
	username_destinataire = $("#instant").val();
	$.post("../message/envoyerUser.php",{username_destinataire:username_destinataire}, function(data){
        if(data.erreur=="no"){
         	ouvrirDiscussion(data.discussion);
        }else if(data.erreur=="already")
        {
         	ouvrirDiscussion(data.discussion);
        }else if (data.erreur=="inexistant") {
        	$("#instant").css("border","3px solid red");
        };
    },"json");
}
