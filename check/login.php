<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');
	if($_POST['email'] != '' && isset($_POST['email']) && isset($_POST['password']) && $_POST['password'] != '')
	{
		// Enlever HTML et PHP
		$email = DestroyHTML($_POST['email']);
		$password = DestroyHTML($_POST['password']);
		// Fonction quote
		
		$dn = $bdd->query("SELECT * FROM users WHERE email = :email", array("email"=> $email));

		if(md5($password) == $dn[0]['password'])
		{
			if($dn['suspendu'] == 1)
			{
				header("Location: ../suspendu/");
			}else
			{
				session_regenerate_id();
				$_SESSION['userid'] = $dn[0]['id'];
				$id = $_SESSION['userid'];
				$_SESSION['email'] = $dn[0]['email'];
				$_SESSION['token'] = md5(time()*rand(1440,2560));
				$token = $_SESSION['token'];
				$query = $bdd->query("UPDATE users SET token = :token,online = :online  WHERE id = :id",array("token"=> $token,"id"=> $id,"online"=>"1"));
				header("Location: ../home/");
			}
			
		}else
		{
			header("Location: ../welcome?reply=notok3");
		}
	}else
	{
		header("Location: ../welcome");
	}
	
	//header("Location: http://".$_SERVER['REMOTE_ADDR']."/birneo/home?reply=ok");
?>