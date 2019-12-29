<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$t = array();
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	$photo = $_FILES['photo']['name'];
	$photo_tmp = $_FILES['photo']['tmp_name'];
	$description = DestroyHTML($_POST['description']);
	date_default_timezone_set('Europe/Brussels');
	$date = date("Y-m-d").' '.date("H:i:s");
	if(!empty($photo))
	{
		$image_ext = strtolower(end(explode('.',$photo)));
		
		if(in_array($image_ext,array('jpg','jpeg','png','gif','bmp')))
		{
			$photo = md5(time()*rand(1440,2560));
			$photo = $photo.'.'.$image_ext;
			move_uploaded_file($photo_tmp, '../photo/'.$photo);
			$url = base64_encode($photo);
			$req = base64_encode("../photo/".$photo);

			$bdd->query("INSERT INTO photo (name,id_proprio,description) VALUES (:url,:userid,:description)",array("url"=> $url,"userid"=> $_SESSION['userid'],"description"=> $description));

			$t["erreur"] = "no";

			$my_info = $bdd->query("SELECT * FROM users WHERE id= :userid",array("userid"=>$_SESSION['userid']));

			$addr = '../portfolio/'.$my_info[0]["username"];
			
			$bdd->bindMore(array(
				"id_poster"=>$_SESSION['userid'],
				"content"=>$description,
				"categorie"=>"Aucune",
				"vote"=>"0",
				"comments"=>"0",
				"type"=>"0",
				"dest"=>$dest,
				"datee"=>$date,
				"photo"=>$photo
				));

			$bdd->query("INSERT INTO posts(id_poster,content,categorie,vote,comments,type,dest,date,photo) VALUES(:id_poster,:content,:categorie,:vote,:comments,:type,:dest,:datee,:photo)");
			
			$id_publication = $bdd->lastId();
			$link = "publication/".$id_publication;

			$notifieur = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));

			$content = $notifieur[0]['surname']." ".$notifieur[0]['name']." a publié quelque chose";

			$query_follow = $bdd->query("SELECT * FROM follow WHERE id_followed = :id_followed AND type = :type",array("id_followed"=>$_SESSION['userid'],"type"=>"0"));

	    	foreach($query_follow as $row)
	    	{
				$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:content,:id_follower,:userid,:readed,:link)",array("content"=>$content,"id_follower"=>$row['id_follower'],"userid"=>$_SESSION['userid'],"readed"=>"0","link"=>$link));	
			}
			header("Location: ".$addr);

		}else
		{
			$my_info = $bdd->query("SELECT * FROM users WHERE id= :userid",array("userid"=>$_SESSION['userid']));
			$addr = '../portfolio/'.$my_info[0]["username"].'?error=ext';
			header("Location: ".$addr);
		}
	}
	
	echo json_encode($t);
	
?>