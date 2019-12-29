<?php
	include('../res/config.php');
	include('../res/secure.php');
	header('Content-type: text/html; charset=utf-8');

	$my_info = $bdd->query("SELECT * FROM users WHERE id = :userid",array("userid"=>$_SESSION['userid']));
    $comment = $bdd->query("SELECT * FROM comments WHERE id = :idcomment",array("idcomment"=>$idComment));
    
    if($my_info[0]['token'] == $_SESSION['token'] && $comment[0]['id_poster'] == $_SESSION['userid'] || $my_info[0]['admin'] == 1)
    {
    	$idComment = intval($_POST['id']);
    	$t = array();
    	$comment = $bdd->query("SELECT * FROM comments WHERE id = :idcomment",array("idcomment"=>$idComment));


        $bdd->query("DELETE FROM comments_debat
                     WHERE id = :idcomment",array("idcomment"=>$idComment));
		$t["erreur"] = "no";
		
		
    }else
    {
    	$t["erreur"] = "Votre token n'est pas valide, ceci pour être du à une intrusion sur votre compte";
    }
    echo json_encode($t);

	
	
?>