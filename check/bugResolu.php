<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');
	$my_info = $bdd->query("SELECT * FROM users WHERE id = :userid",array("userid"=>$_SESSION['userid']));
	$bug = DestroyHTML($_POST['idBug']);
	$t = array();
	if($my_info[0]['admin'] == 1)
	{
		$bdd->query("UPDATE bug SET statut = :statut 
				 	 WHERE id = :bug",array("statut"=> "2","bug"=>$bug));
		header("Location: ../buglist");
	}
	

	$t["erreur"] = "no";
	
	echo json_encode($t);
	
?>