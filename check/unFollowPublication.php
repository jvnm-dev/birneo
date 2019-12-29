<?php
	include('../res/config.php');
	include('../res/secure.php');
	header('Content-type: text/html; charset=utf-8');

	$my_info = $bdd->query("SELECT * FROM users WHERE id = :userid",array("userid"=>$_SESSION['userid']));

    if($my_info[0]['token'] == $_SESSION['token'])
    {
    	$id = intval($_POST['id']);
        $myid = $my_info[0]['id'];
    	$t = array();
		$bdd->query("DELETE FROM follow
					 WHERE id_post= :id  AND id_follower = :myid",array("id"=>$id,"myid"=>$myid));
		$t["erreur"] = "no";
    }else
    {
    	$t["erreur"] = "Votre token n'est pas valide, ceci pour être du à une intrusion sur votre compte";
    }
    echo json_encode($t);

	
	
?>