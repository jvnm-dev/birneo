<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$id_notification_req = $bdd->query("SELECT * FROM notification WHERE id='{$_GET['id']}'");
	$id_notification = $id_notification_req->fetch();

	if($id_notification['readed'] == 0)
	{
		$bdd->query("UPDATE notification SET readed = '1' WHERE id='{$id_notification['id']}'");
		$t["erreur"] = "no";
	}
	$addr = $_SERVER['SERVER_ADDR'];
	header( "Location:http://".$addr."/".$id_notification['link'] );
	
?>