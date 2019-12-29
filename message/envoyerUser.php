<?php 

	include("../res/config.php");
	if(!isset($_SESSION['userid']))
	{
		header("Location: ../welcome");
	}
	$t = array();
	$username_dest = str_replace("@", "", $_POST['username_destinataire']);
	$username_req = $bdd->query("SELECT count(*) FROM users WHERE username=:usernamedest",array("usernamedest"=>$username_dest));
	$count = $username_req[0]['count(*)'];
	if($count == 0)
	{
		$t['erreur'] = "inexistant";
		echo json_encode($t);
		die();
	}
	$destinataire = $bdd->query("SELECT * FROM users WHERE username=:usernamedest",array("usernamedest"=>$username_dest));
	$id_destinataire = $destinataire[0]['id'];
	$id_expediteur = intval($_SESSION['userid']);

	$req_discussion_1 = $bdd->query("SELECT count(*) FROM discussion WHERE id_1 = :idexpediteur1 AND id_2 = :iddestinataire1 OR id_1 = :iddestinataire2 AND id_2 = :idexpediteur2",array(
			"idexpediteur1"=>$id_expediteur,
			"iddestinataire1"=>$id_destinataire,
			"iddestinataire2"=>$id_destinataire,
			"idexpediteur2"=>$id_expediteur
		));
	$discussion_1 = $req_discussion_1[0]['count(*)'];
	$discussion_id = $bdd->query("SELECT * FROM discussion WHERE id_1 = :idexpediteur1 AND id_2 = :iddestinataire1 OR id_1 = :iddestinataire2 AND id_2 = :idexpediteur2",array(
		"idexpediteur1"=>$id_expediteur,
		"iddestinataire1"=>$id_destinataire,
		"iddestinataire2"=>$id_destinataire,
		"idexpediteur2"=>$id_expediteur
	));
	$date = date("Y-m-d").' '.date("H:i:s");
	if($discussion_1>0)
	{
		$t['erreur'] = "already";
		$t['discussion'] = $discussion_id[0]['id'];
	}else
	{
		$req_discussion_2 = $bdd->query("INSERT INTO discussion(id_1,id_2,date,readed,notifPour,archive) VALUES(:id_1,:id_2,:datee,:readed,:notifPour,:archive)",array(
			"id_1"=>$id_expediteur,
			"id_2"=>$id_destinataire,
			"datee"=>$date,
			"readed"=>"0",
			"notifPour"=>$id_destinataire,
			"archive"=>"0"
		));
		$t['discussion'] = $bdd->lastId();
		$t['erreur'] = "no";
	}

	echo json_encode($t);

?>