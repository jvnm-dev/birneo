<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$color_primary = DestroyHTML(trim($_POST['color_primary']));
	$color_secondary = DestroyHTML(trim($_POST['color_secondary']));

	$t = array();
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	if($_POST['color_primary'] != '' && $_POST['color_secondary'] != '')
	{
		$id = $_SESSION['userid'];
		$bdd->query("UPDATE users SET color_primary = :color_primary,color_secondary= :color_secondary
				 	 WHERE id = :userid",array("color_primary"=> $color_primary,"color_secondary"=> $color_secondary,"userid"=>$_SESSION['userid']));
		header("Location: ../themes");
	}else
	{
		$t["erreur"] = "Une erreur est survenue";
	}
	

	
?>