<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');
	$bdd->query("SET NAMES 'utf8'");
	$contenu = DestroyHTML($_POST['content']);

	$categorie = DestroyHTML($_POST['categorie']);
	
	if(isset($_POST['type']))
	{
		$type= DestroyHTML($_POST['type']);
		$dest= DestroyHTML($_POST['dest']);

	}else
	{
		$type='';
		$dest='';
	}
	date_default_timezone_set('Europe/Brussels');
	$date = date('Y-m-d H:i:s', time() - 7200);
	$t = array();
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	if($_POST['content'] != '')
	{
		$id = intval($_SESSION['userid']);
		$type_notif = "commentaire";
		if($type==1)
		{

			$bdd->query("INSERT INTO posts(id_poster,content,categorie,vote,comments,type,dest,date) VALUES (:id_poster,:content,:categorie,:vote,:comments,:type,:dest,:datee)",array(
					"id_poster"=>$dest,
					"content"=>$contenu,
					"categorie"=>$categorie,
					"vote"=>"0",
					"comments"=>"0",
					"type"=>$type,
					"dest"=>$id,
					"datee"=>$date
				));


			$id_publication = $bdd->lastId();
			$link = "publication/".$id_publication;
			$notif = $bdd->query("SELECT * FROM users WHERE id=:dest",array("dest"=>$dest));
			$notifieur = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
			$content = $notifieur[0]['surname']." ".$notifieur[0]['name']." a publié sur votre profil";
			$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id_proprio,:id_exp,:readed,:link)",array(
					"contenu"=>$content,
					"id_proprio"=>$dest,
					"id_exp"=>$_SESSION['userid'],
					"readed"=>"0",
					"link"=>$link
				));
		}else
		{

			$bdd->query("INSERT INTO posts(id_poster,content,categorie,vote,comments,type,dest,date) VALUES (:id_poster,:content,:categorie,:vote,:comments,:type,:dest,:datee)",array(
				"id_poster"=>$id,
				"content"=>$contenu,
				"categorie"=>$categorie,
				"vote"=>"0",
				"comments"=>"0",
				"type"=>$type,
				"dest"=>$dest,
				"datee"=>$date
			));
		

			$id_publication = $bdd->lastId();
			$link = "publication/".$id_publication;
			$notifieur = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
			$content = $notifieur[0]['surname']." ".$notifieur[0]['name']." a publié quelque chose";
			$query_follow = $bdd->query("SELECT * FROM follow WHERE id_followed = :userid AND type = :type",array("userid"=>$_SESSION['userid'],"type"=>"0"));
	    	foreach($query_follow as $row)
	    	{
				$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id_proprio,:id_exp,:readed,:link)",array(
					"contenu"=>$content,
					"id_proprio"=>$row['id_follower'],
					"id_exp"=>$_SESSION['userid'],
					"readed"=>"0",
					"link"=>$link
				));
			}
		}
		

		$t["erreur"] = "no";
		$data = 
		"
			<p>".$contenu."</p>
		";
		echo $data;
	}

	
	
?>
