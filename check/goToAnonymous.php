<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');
	$id = intval($_SESSION['userid']);
	$req = DestroyHTML(intval($_POST['req']));

	$t = array();
	if($req == 1){ 
		$bdd->query("UPDATE users SET type=:anonyme WHERE id=:id",array("anonyme"=>"anonyme","id"=>$id)); 
	}else{ 
		$bdd->query("UPDATE users SET type=:public WHERE id=:id",array("public"=>"public","id"=>$id)); 
	}
	$t["erreur"] = "no";
	
	echo json_encode($t);
	
?>