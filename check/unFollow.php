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
					 WHERE id_followed = :id AND id_follower = :myid",array("id"=>$id,"myid"=>$myid));
        $profile = $bdd->query("SELECT * FROM users WHERE id = :myid",array("myid"=>$myid));
        $link = "profile/".$profile[0]['username'];
        $notifieur = $bdd->query("SELECT * FROM users WHERE id = :userid",array("userid"=>$_SESSION['userid']));
        $contenu = $notifieur[0]['surname']." ".$notifieur[0]['name']." ne vous suit plus";
        $bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id_proprio,:id_exp,:readed,:link)",array(
                    "contenu"=>$content,
                    "id_proprio"=>$id,
                    "id_exp"=>$_SESSION['userid'],
                    "readed"=>"0",
                    "link"=>$link
                ));
		$t["erreur"] = "no";
    }else
    {
    	$t["erreur"] = "Votre token n'est pas valide, ceci pour être du à une intrusion sur votre compte";
    }
    echo json_encode($t);

	
	
?>