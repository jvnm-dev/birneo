<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$name = DestroyHTML($_POST['name']);
	$surname = DestroyHTML($_POST['surname']);


	$t = array();
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	if($_POST['name'] != '' && $_POST['surname'] != '')
	{
		$id = intval($_SESSION['userid']);
		$bdd->query("UPDATE users SET name=:name,surname=:surname WHERE id=:id",array("name"=>$name,"surname"=>$surname,"id"=>$id));
		$t["erreur"] = "no";
		$t["retour"] = "
		<div class='alert alert-success'>Les informations ont été changées.</div>
		";
	}else
	{
		$t["erreur"] = "<div class='alert alert-error' id='erreur'>Complétez tout les champs SVP</div>";
	}
	
	echo json_encode($t);
	
?>