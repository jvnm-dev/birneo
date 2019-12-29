<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$contenu = DestroyHTML($_POST['content']);
	$titre = DestroyHTML($_POST['titre']);
	$type = DestroyHTML($_POST['type']);

	
	
	$t = array();
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	if($_POST['content'] != '')
	{
		$id = $_SESSION['userid'];
		$bdd->query("INSERT INTO bug(id_poster,titre,content,type,statut) VALUES (:id,:titre,:contenu,:type,:statut)",array(
				"id"=>$id,
				"titre"=>$titre,
				"contenu"=>$contenu,
				"type"=>$type,
				"statut"=>""
			));
		$t["erreur"] = "no";
	}

	echo json_encode($t);
	
?>