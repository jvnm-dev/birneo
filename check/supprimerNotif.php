<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$id_notification = intval($_POST['id']);
	$id_proprio = intval($_POST['proprio']);

	$cond = $bdd->query("SELECT token FROM users WHERE id = :id_proprio",array("id_proprio"=>$id_proprio));

	if($cond[0]['token'] == $_SESSION['token'])
	{
		$query = $bdd->query("DELETE FROM notification WHERE id = :id_notification AND id_proprio = :id_proprio",array("id_notification"=>$id_notification,"id_proprio"=>$id_proprio));
	}

	

	
	
?>