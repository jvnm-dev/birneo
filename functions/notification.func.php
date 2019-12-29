<?php 
	function tronque($chaine, $longueur = 120) 
	{
	 
		if (empty ($chaine)) 
		{ 
			return ""; 
		}
		elseif (strlen ($chaine) < $longueur) 
		{ 
			return $chaine; 
		}
		elseif (preg_match ("/(.{1,$longueur})\s./ms", $chaine, $match)) 
		{ 
			return $match [1] . "..."; 
		}
		else 
		{ 
			return substr ($chaine, 0, $longueur) . "..."; 
		}
	}


	function count_notification()
	{
		global $bdd;
		$count_notification_req = $bdd->query("SELECT count(*) FROM notification WHERE id_proprio=:userid AND readed=:readed",array("userid"=>$_SESSION['userid'],"readed"=>"0"));
		$count_notification = $count_notification_req[0]['count(*)'];
		return $count_notification;
	}
			?>