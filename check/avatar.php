<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$t = array();
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	$avatar = $_FILES['avatar']['name'];
	$avatar_tmp = $_FILES['avatar']['tmp_name'];
	if(!empty($avatar))
	{
		$image_ext = strtolower(end(explode('.',$avatar)));
		
		if(in_array($image_ext,array('jpg','jpeg','png','gif','bmp')))
		{
			$avatar = md5(time()*rand(1440,2560));
			$avatar = $avatar.'.'.$image_ext;
			move_uploaded_file($avatar_tmp, '../avatar/'.$avatar);
			$req = base64_encode("../avatar/".$avatar);
			$bdd->query("UPDATE users SET avatar = :req 
				 		 WHERE id = :userid",array("req"=> $req,"userid"=> $_SESSION['userid']));
			$t["erreur"] = "no";

			$my_info = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $_SESSION['userid']));

			$addr = '../profile/'.$my_info[0]["username"];
			header("Location: ".$addr);

		}else
		{
			$my_info = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $_SESSION['userid']));
			$addr = '../profile/'.$my_info[0]["username"].'?error=ext';
			header("Location: ".$addr);

		}
	}
	
	echo json_encode($t);
	
?>