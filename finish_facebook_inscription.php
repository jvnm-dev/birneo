<?php 
	require 'res/config.php';
	$password1 = htmlentities(strip_tags($_POST['password']));
	$password2 = htmlentities(strip_tags($_POST['password_repeat']));
	$situation = htmlentities(strip_tags($_POST['situation']));
	$email = htmlentities(strip_tags(_POST['email']));
	$password1 = md5($password1);
	$avatar = "Li4vYXZhdGFyL2RlZmF1bHQuanBn";
	if(isset($password1) && isset($password2))
	{
		$bdd->query("UPDATE users SET password = :password,situation = :situation,avatar = :avatar WHERE email = :email", array("password"=> $password1,"situation"=> $situation,"avatar"=> $avatar,"email"=> $email));
		header("Location: ../welcome?reply=ok");
	}else
	{
		echo "Vous devez remplir tout les champs, recommencer la procédure depuis le début.";
		$bdd->query("SELECT * FROM users WHERE email = :email", array("email"=>$email));
	}
	

?>