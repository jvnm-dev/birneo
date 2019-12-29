<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$t = array();

//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";

	$id = $_SESSION['userid'];
	$id_debat = DestroyHTML(intval($_POST['id_debat']));
	$type = DestroyHTML(intval($_POST['type']));
	
		if($type == 1)
		{
			$bdd->query("UPDATE debats SET pour = pour+:pour
				 	 	WHERE id = :id",array("pour"=> "1","id"=> $id_debat));

			$bdd->query("INSERT INTO vote_debat(id_debat,id_user) VALUES(:id_debat,:id)",array("id_debat"=>$id_debat,"id"=>$id));
		}elseif($type == 2)
		{

			$bdd->query("UPDATE debats SET neutre = neutre+:neutre
				 	 	 WHERE id = :id",array("neutre"=> "1","id"=> $id_debat));

			$bdd->query("INSERT INTO vote_debat(id_debat,id_user) VALUES(:id_debat,:id)",array("id_debat"=>$id_debat,"id"=>$id));

		}elseif($type == 3)
		{
			$bdd->query("UPDATE debats SET contre = contre+:contre
				 	 	 WHERE id = :id",array("contre"=> "1","id"=> $id_debat));

			$bdd->query("INSERT INTO vote_debat(id_debat,id_user) VALUES(:id_debat,:id)",array("id_debat"=>$id_debat,"id"=>$id));
		}

		$t["erreur"] = "no";

	echo json_encode($t);
	
?>