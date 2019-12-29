<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	if(isset($_POST['message'])){ $message = DestroyHTML($_POST['message']);}
	if(isset($_POST['discussion'])){ $discussion = intval($_POST['discussion']);}
	if(isset($_POST['id_destinataire'])){ $id_destinataire = intval($_POST['id_destinataire']); }
	if(isset($_POST['destinataire']))
	{ 
		$username_destinataire = DestroyHTML($_POST['destinataire']);

		$username_destinataire=str_replace("@","",$username_destinataire);
		$destinataire = $bdd->query("SELECT * FROM users WHERE username= :username_destinataire",array("username_destinataire"=>$username_destinataire));
		$id_destinataire = $destinataire[0]['id'];
	}


	$id_expediteur = intval($_SESSION['userid']);
	date_default_timezone_set('Europe/Brussels');
	$date = date("Y-m-d").' '.date("H:i:s");
	$t = array();


	$query_verification = $bdd->query("SELECT count(*) FROM discussion WHERE id_1 = :id_expediteur1 AND id_2 = :id_destinataire1
																OR 	  id_1 = :id_destinataire2 AND id_2 = :id_expediteur2",array(
																	"id_expediteur1"=>$id_expediteur,
																	"id_destinataire1"=>$id_destinataire,
																	"id_destinataire2"=>$id_destinataire,
																	"id_expediteur2"=>$id_expediteur
																	));
	

	if(!empty($query_verification))
	{
		$verification = $query_verification[0]['count(*)'];
	}else
	{

		$t['erreur'] = "Cette personne n'existe pas.";
		echo json_encode($t);
		die();
	}

	if($verification == 0)
	{
		if($_POST['message'] != '' && $_POST['destinataire'] != '')
		{	
			$message = DestroyHTML($_POST['message']);
			$username_destinataire = DestroyHTML($_POST['destinataire']);

			$username_destinataire=str_replace("@","",$username_destinataire);
			$id_destinataire_query = $bdd->query("SELECT count(*) FROM users WHERE username= :username_destinataire",array("username_destinataire"=>$username_destinataire));
			$verification_destinataire = $id_destinataire_query[0]['count(*)'];
			if($verification_destinataire == 1)
			{
				$bdd->query("INSERT INTO discussion (id_1,id_2,date,readed,notifPour,archive) VALUES(:id_1,:id_2,:datee,:readed,:notifPour,:archive)",array(
					"id_1"=>$id_expediteur,
					"id_2"=>$id_destinataire,
					"datee"=>$date,
					"readed"=>"0",
					"notifPour"=>$id_destinataire,
					"archive"=>"0"
				));
				$id_discussion = $bdd->lastId();

				$bdd->query("INSERT INTO messages(id_expediteur,id_destinataire,date,message,discussion) VALUES(:id_expediteur,:id_destinataire,:datee,:message,:discussion)",array(
					"id_expediteur"=>$id_expediteur,
					"id_destinataire"=>$id_destinataire,
					"datee"=>$date,
					"message"=>$message,
					"discussion"=>$id_discussion
				));

				$t["erreur"] = "no";
			}else
			{
				$t['erreur'] = "Cette personne n'existe pas".$username_destinataire;
			}
		}
	}else
	{
		$discussion_array = $bdd->query("SELECT * FROM discussion WHERE id_1 = :id_expediteur1 AND id_2 = :id_destinataire1
											OR 	  id_1 = :id_destinataire2 AND id_2 = :id_expediteur2",array(
												"id_expediteur1"=>$id_expediteur,
												"id_destinataire1"=>$id_destinataire,
												"id_destinataire2"=>$id_destinataire,
												"id_expediteur2"=>$id_expediteur
												));
		$discussion = $discussion_array[0]['id'];
		$id_discussion = $discussion_array[0]['id'];
		if($_POST['message'] != '')
		{
			$bdd->query("INSERT INTO messages(id_expediteur,id_destinataire,date,message,discussion) VALUES(:id_expediteur,:id_destinataire,:datee,:message,:discussion)",array(
				"id_expediteur"=>$id_expediteur,
				"id_destinataire"=>$id_destinataire,
				"datee"=>$date,
				"message"=>$message,
				"discussion"=>$id_discussion
			));

			$bdd->query("UPDATE discussion SET date=:datee,readed=:readed,notifPour=:id_destinataire,archive=:archive WHERE id=:discussion",array(
					"datee"=>$date,
					"readed"=>"0",
					"id_destinataire"=>$id_destinataire,
					"archive"=>"0",
					"discussion"=>$discussion
				));
			$t["erreur"] = "no";
		}
	}

	echo json_encode($t);
	
?>