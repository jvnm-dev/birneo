<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$id_exp = intval($_POST['id_exp']);
	$id_dest = intval($_POST['id_dest']);

	$t = array();
	$query = $bdd->query("DELETE FROM friends
						  WHERE id_exp = :id_exp1 AND id_dest = :id_dest1
						  OR id_exp = :id_dest2 AND id_dest = :id_exp2",array(
						  		"id_exp1"=>$id_exp,
						  		"id_dest1"=>$id_dest,
						  		"id_dest2"=>$id_dest,
						  		"id_exp2"=>$id_exp,
						  	));
	$t["erreur"] = "no";
	
	echo json_encode($t);
	
?>