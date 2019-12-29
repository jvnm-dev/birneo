<?php
	require_once dirname(__DIR__) . '/res/config.php';
	header('Content-type: text/html; charset=utf-8');

	$id_exp = intval($_POST['id_exp']);
	$id_dest = intval($_POST['id_dest']);

	$t = array();

	$query = $bdd->query("UPDATE friends SET active = :active 
						  WHERE id_exp = :id_dest AND id_dest = :id_exp",array("active"=> "1","id_exp"=> $id_exp,"id_dest"=>$id_dest));

	$t["erreur"] = "no";
	
	echo json_encode($t);
	
?>