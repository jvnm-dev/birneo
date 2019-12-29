<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

	$username = DestroyHTML($_POST['username']);
	$email = DestroyHTML($_POST['email']);
	$password = DestroyHTML($_POST['password']);
	$password = md5(DestroyHTML($password));
	$sex = DestroyHTML($_POST['sex']);
	if($sex == "Je suis un homme")
	{
		$sex = "Homme";
	}else
	{
		$sex = "Femme";
	}
	$job = DestroyHTML($_POST['job']);
	$description = DestroyHTML($_POST['description']);
	$name = ucfirst(DestroyHTML($_POST['name']));
	$surname = ucfirst(DestroyHTML($_POST['surname']));
	$situation = DestroyHTML($_POST['situation']);
	$verifReq = $bdd->query("SELECT count(*) FROM users WHERE email = :email OR username = :username",array("email"=>$email,"username"=>$username));
	$verif = $verifReq[0]['count(*)'];
	$filtreUser_code = array(
	        ".",
	        "-",
	        "_",
	        " "
	    );
	    $filtreUser = Array (
	    	"",
	        "",
	        "",
	        ""
		);
		$username = str_replace($filtreUser_code, $filtreUser, $username); 
		$username = preg_replace("#[^a-zA-Z0-9]#", "", $username);
		
	if($verif == 0)
	{
		$bdd->query("INSERT INTO users(username,email,password,sex,name,surname,situation,job,description,type) VALUES(:username,:email,:password,:sex,:name,:surname,:situation,:job,:description,:type)",array(
				"username"=>$username,
				"email"=>$email,
				"password"=>$password,
				"sex"=>$sex,
				"name"=>$name,
				"surname"=>$surname,
				"situation"=>$situation,
				"job"=>$job,
				"description"=>$description,
				"type"=>"public"
			));
		header("Location: ../welcome?reply=ok");
	}else
	{
		header("Location: ../welcome?reply=already");
	}
	
?>