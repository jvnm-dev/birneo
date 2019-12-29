<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$username_destinataire = DestroyHTML($_POST['pseudoAmi']);
	$id_exp = DestroyHTML($_SESSION['userid']);


	$username_destinataire=str_replace("@","",$username_destinataire);
	$profile = $bdd->query("SELECT * FROM users WHERE username = :username_destinataire", array("username_destinataire"=> $username_destinataire));
	
	$id_destinataire=$profile[0]['id'];
	$moi = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $_SESSION['userid']));
	$link = "../profile/".$moi[0]['username'];

	$t = array();

	$bdd->bindMore(array(
		"id_exp"=>$id_exp,
		"id_dest"=>$id_destinataire,
		"date_invitation"=>"NOW()",
		"date_confirmation"=>"",
		"active"=>"0"
		));

	$bdd->query("INSERT INTO friends(id_exp,id_dest,date_invitation,date_confirmation,active)
						  VALUES
						  (:id_exp,:id_dest,:date_invitation,:date_confirmation,:active)");

	$notif = $moi[0]['surname']." ".$moi[0]['name']." aimerait être votre ami";

	$bdd->bindMore(array(
		"contenu"=>$notif,
		"id_proprio"=>$id_destinataire,
		"id_exp"=>$_SESSION['userid'],
		"readed"=>"0",
		"link"=>$link
		));

	$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id_proprio,:id_exp,:readed,:link)");

	$t["erreur"] = "no";
	header("Location: ../profile/".$moi[0]['username']."?message=ok");
	
?>