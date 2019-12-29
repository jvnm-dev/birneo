<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$situation = DestroyHTML($_POST['situation']);


	$t = array();
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	if($_POST['situation'] != '')
	{
		$id = DestroyHTML(intval($_SESSION['userid']));
		$bdd->query("UPDATE users SET situation=:situation WHERE id=:id",array("situation"=>$situation,"id"=>$id));
		$t["erreur"] = "no";
		$t["retour"] = "
		<div class='alert alert-success'>L'information a été changée.</div>
		";
	}else
	{
		$t["erreur"] = "<div class='alert alert-error' id='erreur'>Complétez tout les champs SVP</div>";
	}
	
	echo json_encode($t);
	
?>