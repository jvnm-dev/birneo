<?php 
	include('../res/config.php');
	if(!isset($_SESSION['userid']))
	{
		header("Location: ../welcome");
	}
	$t = array();
	$myID = intval($_SESSION['userid']);
	$discussion = intval($_POST['discussion']);

	$recherche = $bdd->query("SELECT * FROM discussion WHERE id=:discussion1 AND id_1 = :myid1 OR id = :discussion2 AND id_2 = :myid2",array("discussion1"=>$discussion,"myid1"=>$myID,"discussion2"=>$discussion,"myid2"=>$myID));
	if($recherche[0]['id_1'] == $myID)
	{
		$destinataire = $recherche[0]['id_2'];
	}else
	{
		$destinataire = $recherche[0]['id_1'];
	}

	$t['erreur'] = "no";
	$t['destinataire'] = $destinataire;

	echo json_encode($t);


?>