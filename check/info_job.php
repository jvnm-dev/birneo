<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$job = DestroyHTML($_POST['job']);

	$t = array();
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	if($_POST['job'] != '')
	{
		$id = intval($_SESSION['userid']);
		$bdd->query("UPDATE users SET job=:job WHERE id=:id",array("job"=>$job,"id"=>$id));
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