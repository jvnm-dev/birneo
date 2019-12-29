<?php
	session_start();
	require_once __DIR__ . '/mysql/Db.class.php';
	$bdd = new Db();
	header('Content-type: text/html; charset=utf-8');

	$t = array();
	$query = $bdd->query("UPDATE notification SET readed=1 WHERE id_proprio='{$_SESSION['userid']}';");
	$t["erreur"] = "no";
	
	echo json_encode($t);
	
?>