<?php
	include('../res/config.php');
    include('../res/secure.php');
	header('Content-type: text/html; charset=utf-8');

	$my_info = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
    if($my_info[0]['token'] == $_SESSION['token'])
    {
    	$id = DestroyHTML(intval($_POST['id']));
        $myid = $my_info[0]['id'];
    	$t = array();
		$verifFollowReq = $bdd->query("SELECT * FROM follow WHERE id_followed = :id AND id_follower = :myid AND type = :zero",array(
                "id"=>$id,
                "myid"=>$myid,
                "zero"=>"0"
            ));
        $verifFollow = $verifFollowReq[0]['count(*)'];
        if($verifFollow == 0){
            $profile = $bdd->query("SELECT * FROM users WHERE id=:myid",array("myid"=>$myid));
            $link = "profile/".$profile[0]['username'];
            $bdd->query("INSERT INTO follow(id_followed,id_follower,type,id_post) VALUES(:id,:userid,:zero,:nul)",array(
                    "id"=>$id,
                    "userid"=>$_SESSION['userid'],
                    "zero"=>"0",
                    "nul"=>""
                ));
            $notifieur = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));

            $contenu = $notifieur[0]['surname']." ".$notifieur[0]['name']." vous suit";
            $bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id,:userid,:zero,:link)",array(
                    "contenu"=>$contenu,
                    "id"=>$id,
                    "userid"=>$_SESSION['userid'],
                    "zero"=>"0",
                    "link"=>$link
                ));
        }
		$t["erreur"] = "no";
    }else
    {
    	$t["erreur"] = "Votre token n'est pas valide, ceci pour être du à une intrusion sur votre compte";
    }
    echo json_encode($t);

	
	
?>