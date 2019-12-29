<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');
	$id = intval($_SESSION['userid']);

	$dn = $bdd->query("SELECT password FROM users WHERE id=:id",array("id"=>$id));

	$actualpassword = DestroyHTML($dn[0]['password']);
	$oldpassword = DestroyHTML($_POST['oldpassword']);
	$newpassword = md5(DestroyHTML($_POST['newpassword']));

	$t = array();
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	if($_POST['oldpassword'] != '' && $_POST['newpassword'] != '')
	{
		if($actualpassword == md5($oldpassword))
		{
			$bdd->query("UPDATE users SET password=:newpassword WHERE id=:id",array("newpassword"=>$newpassword,"id"=>$id));
			$t["erreur"] = "no";
			$t["retour"] = "
			<div class='alert alert-success'>Les informations ont été changées.</div>
			";
		}else
		{
			$t['erreur'] = "code1";
			$t['retour'] = "<div class='alert alert-error' id='erreur'>Votre mot de passe actuel n'est pas celui entré.</div>";
		}
		
	}else
	{
		$t["erreur"] = "<div class='alert alert-error' id='erreur'>Complétez tout les champs SVP</div>";
	}
	
	echo json_encode($t);
	
?>