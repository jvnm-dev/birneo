<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$id_exp = intval($_POST['id_exp']);
	$id_dest = intval($_POST['id_dest']);
	
	$profile = $bdd->query("SELECT * FROM users WHERE id = :id_exp",array("id_exp"=>$id_exp));
	$link = "profile/".$profile[0]['username'];

	$t = array();
	$t["var"] = $id_exp." pour ".$id_dest;
	$bdd->query("INSERT INTO friends(id_exp,id_dest,date_invitation,date_confirmation,active) VALUES(:id_exp,:id_dest,:date_invitation,:date_confirmation,:active)",array(
			"id_exp"=>$id_exp,
			"id_dest"=>$id_dest,
			"date_invitation"=>"NOW()",
			"date_confirmation"=>"",
			"active"=>"0"
		));

	$notif = $profile[0]['surname']." ".$profile[0]['name']." aimerait être votre ami";
	$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id_proprio,:id_exp,:readed,:link)",array(
		"contenu"=>$notif,
		"id_proprio"=>$id_dest,
		"id_exp"=>$_SESSION['userid'],
		"readed"=>"0",
		"link"=>$link
	));
	$t["erreur"] = "no";
	
	echo json_encode($t);
	
?>