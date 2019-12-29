<?php 
	session_start();
	require_once __DIR__ . '/mysql/Db.class.php';
	$bdd = new Db();
	$t = array();

	$query = $bdd->query("SELECT count(*) FROM notification WHERE id_proprio = :id_proprio AND readed = :readed", array("id_proprio"=> $_SESSION['userid'],"readed"=>"0"));
	$query_2 = $bdd->query("SELECT count(*) FROM discussion WHERE id_1 = :uid AND readed = :readed AND notifPour = :uid2 OR id_2 = :uid3 AND readed = :readed2 AND notifPour = :uid4", array(
		"uid"=> $_SESSION['userid'],
		"readed"=>"0",
		"uid2"=> $_SESSION['userid'],
		"uid3"=> $_SESSION['userid'],
		"readed2"=>"0",
		"uid4"=> $_SESSION['userid']
		));


	$t["notification"] = $query[0]['count(*)'];
	$t["message"] = $query_2[0]['count(*)'];
	
	echo json_encode($t);
?>