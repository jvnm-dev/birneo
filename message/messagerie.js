var discussion;
var idDestinataire;
var T_GLOBAL = false;

$("#refreshListMessage").click(function(){
  $("#contenuMessagerie").fadeOut();
  $("#EnvoyerMessagerie").empty();
  $("#contenuMessagerie").load("../message/recupMessage.php");
  $("#contenuMessagerie").fadeIn();
});

function ouvrirDiscussion(id)
{
	discussion = id;
  $("#loaderMessagerie").fadeIn();
	$("#contenuMessagerie").hide();
	$("#contenuMessagerie").empty();
	$("#EnvoyerMessagerie").empty();
	$("#contenuMessagerie").load("../message/ouvrirDiscussion.php?id="+id);
	$.post("../message/chercherDestinataire.php",{discussion:discussion}, function(data){
        if(data.erreur=="no"){
            idDestinataire = data.destinataire;
        }
    },"json");
	$("#EnvoyerMessagerie").append("Répondre:<br /><textarea style='width:90%;' id='content' name='content' placeholder='Réponse'></textarea><button id='repondreMessage' name='repondreMessage' class='btn btn-block btn-primary' onclick='envoyerMessage();'><div id='idDestinataire'></div><i class='icon-white icon-arrow-down'></i> Envoyer</button></a>");
	$("#btnRetour").empty();
  $("#btnRetour").append("<a onclick='retour();' class='btn btn-block btn-primary'>Boîte de réception</a>");
	$("#contenuMessagerie").fadeIn();
  $("#loaderMessagerie").fadeOut();
	lancerRefresh(id);
  getAlert();

}

function lancerRefresh(id)
{
  discussion = id;
  T_GLOBAL = setTimeout('refreshDiscussion('+id+')',2000);
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
