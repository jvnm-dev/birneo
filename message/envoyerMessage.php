<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');
	function urlToLink($var)
	{
		$var = preg_replace('`((?:https?|ftp)://\S+?)(?=[[:punct:]]?(?:\s|\Z)|\Z)`', '<a target="_blank" href="$1$2">$1$2</a>', $var);
		return $var;
	}

	function place_smiley($var)
	{
		$smileys_code = array(
	        ":)",
			":-)",
			":D",
			":-D",
			":d",
			":-d",
			":p",
			":-p",
			":P",
			":-P",
			"^^",
			"^_^",
			"^-^",
			"&lt;3",
			":o",
	        ":-o",
	        ":O",
	        ":-O",
	        ":(",
	        ":-(",
	        ":-/",
	        ":'(",
	        ":'-("
	    );
	    $smileys = Array (
		    "<img src='../assets/img/content.gif' title=':)'  />",
			"<img src='../assets/img/content.gif' title=':)'  />",
			"<img src='../assets/img/rire.gif' title=':D'  />",
			"<img src='../assets/img/rire.gif' title=':D'  />",
			"<img src='../assets/img/rire.gif' title=':D'  />",
			"<img src='../assets/img/rire.gif' title=':D'  />",
			"<img src='../assets/img/langue.gif' title=':p'  />",
			"<img src='../assets/img/langue.gif' title=':-p'  />",
			"<img src='../assets/img/langue.gif' title=':P'  />",
			"<img src='../assets/img/langue.gif' title=':-P'  />",
			"<img src='../assets/img/^^.gif' title='^^'  />",
			"<img src='../assets/img/^^.gif' title='^^'  />",
			"<img src='../assets/img/^^.gif' title='^^'  />",
			"<img src='../assets/img/love.gif' title='<3'  />",
			"<img src='../assets/img/etonne.gif' title=':o'  />",
	        "<img src='../assets/img/etonne.gif' title=':o'  />",
	        "<img src='../assets/img/etonne.gif' title=':o'  />",
	        "<img src='../assets/img/etonne.gif' title=':o'  />",
	        "<img src='../assets/img/pascontent.gif' title=':('  />",
	        "<img src='../assets/img/pascontent.gif' title=':('  />",
	        "<img src='../assets/img/semitriste.gif' title=':/'  />",
	        "<img src='../assets/img/semitriste.gif' title=':/'  />",
	        "<img src='../assets/img/triste.gif' title=\":'(\"  />",
	        "<img src='../assets/img/triste.gif' title=\":'(\"  />"

		);
		$var = str_replace($smileys_code, $smileys, $var);
		return $var;
	}

	if(isset($_POST['message'])){ $message = DestroyHTML($_POST['message']); }
	if(isset($_POST['discussion'])){ $discussion = intval($_POST['discussion']); }

	$destinataire = $bdd->query("SELECT * FROM discussion WHERE id=:discussion1 AND id_1=:userid1 OR id=:discussion2 AND id_2=:userid2",array("discussion1"=>$discussion,"userid1"=>$_SESSION['userid'],"discussion2"=>$discussion,"userid2"=>$_SESSION['userid']));
	
	if($destinataire[0]['id_1'] == $_SESSION['userid'])
	{
		$id_destinataire = $destinataire[0]['id_2'];
	}else
	{
		$id_destinataire = $destinataire[0]['id_1'];
	}

	
	$id_expediteur = intval($_SESSION['userid']);
	date_default_timezone_set('Europe/Brussels');
	$date = date("Y-m-d").' '.date("H:i:s");
	$t = array();
	$t['coucou'] = $id_destinataire;
	$query_verification = $bdd->query("SELECT count(*) FROM discussion WHERE id_1 = :id_expediteur1 AND id_2 = :id_destinataire1 OR id_1 = :id_destinataire2 AND id_2 = :id_expediteur2",array(
							"id_expediteur1"=>$id_expediteur,
							"id_destinataire1"=>$id_destinataire,
							"id_destinataire2"=>$id_destinataire,
							"id_expediteur2"=>$id_expediteur
							));
	
	
		$verification = $query_verification[0]['count(*)'];
	
	if($verification == 0)
	{
		if($_POST['message'] != '' && $_POST['destinataire'] != '')
		{	
			$message = DestroyHTML($_POST['message']);
			$id_destinataire_query = $bdd->query("SELECT count(*) FROM users WHERE id=:id_destinataire",array("id_destinataire"=>$id_destinataire));
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
				$t['erreur'] = "Cette personne n'existe pas => ".$verification_destinataire;
			}
		}
	}else
	{
		$discussion_array = $bdd->query("SELECT * FROM discussion WHERE id_1 = :id_expediteur1 AND id_2 = :id_destinataire1 OR id_1 = :id_destinataire2 AND id_2 = :id_expediteur2",array(
								"id_expediteur1"=>$id_expediteur,
								"id_destinataire1"=>$id_destinataire,
								"id_destinataire2"=>$id_destinataire,
								"id_expediteur2"=>$id_expediteur
							));

		$discussion = $discussion_array[0]['id'];

		if($_POST['message'] != '')
		{
			$bdd->query("INSERT INTO messages(id_expediteur,id_destinataire,date,message,discussion) VALUES(:id_expediteur,:id_destinataire,:datee,:message,:discussion)",array(
				"id_expediteur"=>$id_expediteur,
				"id_destinataire"=>$id_destinataire,
				"datee"=>$date,
				"message"=>$message,
				"discussion"=>$discussion
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

	$me = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));

	$t["message"] =
		"
	    <div class='media'>
          <a class='pull-left' href='#'>
          <img class='img-polaroid' style='max-width:50px;max-height:70px;' src='".base64_decode($me[0]['avatar'])."' />
          </a>
          <div class='media-body'>
            <h4 class='media-heading'>".$me[0]['surname']." ".$me[0]['name']."</h4>
            <i class='icon-white icon-comment'></i> ".$_POST['message']."
            <div class='media'>
              ".$date."
            </div>
        </div>
        </div>
        <hr />
	    ";



	
	echo json_encode($t);
	
?>