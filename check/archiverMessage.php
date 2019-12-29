<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');
	$discussion = DestroyHTML($_POST['discussion']);
	$t = array();
	
	$bdd->query("UPDATE discussion SET archive = :archive 
				 WHERE id = :discussion",array("archive"=> "1","discussion"=> $discussion));

	$t["erreur"] = "no";
	
	echo json_encode($t);
	
?>