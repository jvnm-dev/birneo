<?php
	require_once dirname(__DIR__) . '/res/config.php';
	header('Content-type: text/html; charset=utf-8');

	$id_exp = intval($_POST['id_exp']);
	$id_dest = intval($_POST['id_dest']);

	$profile = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));

	$link = "profile/".$profile[0]['username'];

	$t = array();
	$t["var"] = $id_exp." à ".$id_dest;
	$query = $bdd->query("UPDATE friends SET active = active+1 WHERE id_exp = :iddest AND id_dest = :idexp",array(
			"idexp"=>$id_exp,
			"iddest"=>$id_dest
		));
	
	$contenu = $profile[0]['surname']." ".$profile[0]['name']." a accepté votre invitation";
	$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id_dest,:id_exp,:readed,:link)",array(
		"contenu"=>$contenu,
		"id_dest"=>$id_dest,
		"id_exp"=>$id_exp,
		"readed"=>"0",
		"link"=>$link
		));

	$t["erreur"] = "no";
	
	echo json_encode($t);
	
?>