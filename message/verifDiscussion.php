<?php 
	require("../res/config.php");

	$t = array();

	$discussion = intval($_GET['id']);
	$myID = intval($_SESSION['userid']);

	$verifMessage_req = $bdd->query("SELECT count(*) FROM messages WHERE id_destinataire=:myid AND discussion=:discussion AND readed=:zero",array("myid"=>$myID,"discussion"=>$discussion,"zero"=>"0"));
	$verifMessage = $verifMessage_req[0]['count(*)'];
	$t['erreur'] = "no";
	$t['message'] = $verifMessage;

	echo json_encode($t);

?>