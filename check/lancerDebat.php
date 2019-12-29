<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$contenu = DestroyHTML($_POST['contenu']);
	$titre = DestroyHTML($_POST['titre']);

	date_default_timezone_set('Europe/Brussels');
	$date = date("Y-m-d").' '.date("H:i:s");
	$t = array();
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	if($_POST['contenu'] != '')
	{
		$id = $_SESSION['userid'];
		
		$bdd->query("INSERT INTO debats(titre,contenu,pour,contre,neutre,id_poster) VALUES (:titre,:contenu,:pour,:contre,:neutre,:id_poster)",array(
				"titre"=>$titre,
				"contenu"=>$contenu,
				"pour"=>"0",
				"contre"=>"0",
				"neutre"=>"0",
				"id_poster"=>$_SESSION['userid'],
			));

		$id_publication = $bdd->lastId();
		$link = "../debat/".$id_publication;
		$notifieur = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
		$content = $notifieur[0]['surname']." ".$notifieur[0]['name']." a lancé un débat";
		$query_follow = $bdd->query("SELECT * FROM follow WHERE id_followed = :id_followed AND type = :type",array("id_followed"=>$_SESSION['userid'],"type"=>"0"));
    	foreach($query_follow as $row)
    	{
			$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:content,:id_follower,:userid,:readed,:link)",array("content"=>$content,"id_follower"=>$row['id_follower'],"userid"=>$_SESSION['userid'],"readed"=>"0","link"=>$link));	
		}
		header("Location: ".$link);
		

		$t["erreur"] = "no";
		$data = 
		"
			<p>".$contenu."</p>
		";
		echo $data;
	}else
	{
		header("Location: ../debats");
	}

	
	
?>
