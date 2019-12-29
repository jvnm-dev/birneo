<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$my_info = $bdd->query("SELECT * FROM users WHERE id = :userid",array("userid"=>$_SESSION['userid']));
	
    if($my_info[0]['admin'] == 1)
    {
    	$idBug = intval($_POST['idBug']);
    	$t = array();
		$query = $bdd->query("DELETE FROM bug
							  WHERE id = :idbug",array("idbug",$idBug));
		$t["erreur"] = "no";
		
		echo json_encode($t);
    }else
    {
    	echo "Qu'espérez-vous ?";
    }

	
	
?>