<?php
	require_once dirname(__DIR__) . '/res/config.php';
	header('Content-type: text/html; charset=utf-8');

	$t = array();

//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";

	$id = $_SESSION['userid'];
	$id_publication = DestroyHTML($_POST['id_publication']);

	$req = $bdd->query("SELECT count(*) FROM vote WHERE id_publication = :id_publication AND id_user = :id", array("id_publication"=> $id_publication,"id"=> $id));
	$count = $req[0]['count(*)'];
	
	$req = $bdd->query("SELECT count(vote) FROM posts WHERE id = :id_publication", array("id_publication"=> $id_publication));
	$nombre = $req[0]['count(vote)'];
	$t["nombre"] = $nombre;	
	

	if($count==0)
	{	
		// Notification
		$bdd->query("INSERT INTO vote (id_publication,id_user) VALUES(:id_publication,:id_user)",array("id_publication"=>$id_publication,"id_user"=>$id));
		$bdd->query("UPDATE posts SET vote = vote+:vote WHERE id = :id_publication",array("vote"=>"1","id_publication"=>$id_publication)); 
		$publication = $bdd->query("SELECT * FROM posts WHERE id = :id_publication", array("id_publication"=> $id_publication));

		$link = "publication/".$id_publication;
		if($publication['id_poster'] != $_SESSION['userid']){
			$notifieur = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $_SESSION['userid']));
			$contenu = $notifieur[0]['surname']." ".$notifieur[0]['name']." a aimé votre publication";
			$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id_proprio,:id_exp,:readed,:link)",array(
				"contenu"=>$contenu,
				"id_proprio"=>$publication[0]['id_poster'],
				"id_exp"=>$_SESSION['userid'],
				"readed"=>"0",
				"link"=>$link
			));
		}

		$t["erreur"] = "no";
	}else
	{
		$t["erreur"] = "already";
	}

	
	
	$t["count"] = $count;
	echo json_encode($t);
	
?>