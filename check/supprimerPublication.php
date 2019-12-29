<?php
	include('../res/config.php');
	include('../res/secure.php');
	header('Content-type: text/html; charset=utf-8');

	$my_info = $bdd->query("SELECT * FROM users WHERE id = :userid",array("userid"=>$_SESSION['userid']));
    $id = intval($_POST['id']);
    $publication = $bdd->query("SELECT * FROM posts WHERE id=:id",array("id"=>$id));

    if($my_info[0]['token'] == $_SESSION['token'] && $publication[0]['id_poster'] == $_SESSION['userid'] || $my_info[0]['admin'] == 1)
    {
    	
    	$t = array();
    	$comment = $bdd->query("SELECT * FROM comments WHERE id = :id",array("id"=>$id));
		$bdd->query("DELETE FROM posts
					 WHERE id = :id",array("id"=>$id));
		$t["erreur"] = "no";
    }else
    {
    	$t["erreur"] = "Votre token n'est pas valide, ceci pour être du à une intrusion sur votre compte";
    }
    echo json_encode($t);

	
	
?>