<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$id = intval($_SESSION['userid']);
	$id_post = DestroyHTML(intval($_POST['id_post']));
	$id_poster = DestroyHTML(intval($_POST['id_poster']));
	$type = DestroyHTML(intval($_POST['type']));

	$t = array();
	$verifQuery = $bdd->query("SELECT count(*) FROM signalement WHERE id_post = :id_post AND id_poster = :id_poster AND type = :type AND signalerPar = :id",array(
		"id_post"=>$id_post,
		"id_poster"=>$id_poster,
		"type"=>$type,
		"id"=>$id
	));
	$verif = $verifQuery[0]['count(*)'];
	if($verif == 1)
	{
		$t["already"] = $verif;
	}else
	{
		$query = $bdd->query("INSERT INTO signalement(id_post,id_poster,type,signalerPar,regler) VALUES(:id_post,:id_poster,:type,:signalerPar,:regler)",array(
			"id_post"=>$id_post,
			"id_poster"=>$id_poster,
			"type"=>$type,
			"signalerPar"=>$id,
			"regler"=>"0"
		));
		$t["already"] = $verif;
	}

	

	$t["erreur"] = "no";
	
	
	echo json_encode($t);
	
?>