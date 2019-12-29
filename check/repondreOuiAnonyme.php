<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$id_exp = DestroyHTML($_GET['exp']);
	$id_dest = DestroyHTML($_GET['dest']);

	$profile = $bdd->query("SELECT * FROM users WHERE id = :id_dest",array("id_dest"=>$id_dest));
	$link = "profile/".$profile[0]['username'];

	$moi = $bdd->query("SELECT * FROM users WHERE id = :id_exp",array("id_exp"=>$id_exp));
	$link2 = "profile/".$moi[0]['username'];

	$t = array();
	$query = $bdd->query("UPDATE friends SET active = :active WHERE id_exp = :id_exp AND id_dest = :id_dest",array(
			"active"=>"1",
			"id_exp"=>$id_exp,
			"id_dest"=>$id_dest
		));
	
	$contenu = $profile[0]['surname']." ".$profile[0]['name']." a accepté votre invitation";
	$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id_proprio,:id_exp,:readed,:link)",array(
			"contenu"=>$contenu,
			"id_proprio"=>$id_exp,
			"id_exp"=>$id_dest,
			"readed"=>"0",
			"link"=>$link
		));
	$t["erreur"] = "no";
	
	header("Location: ../".$link2);
	
?>