<?php
	include("res/config.php");
	if(isset($_SESSION['userid']))
	{
		$bdd->query("UPDATE users SET online=0 WHERE id=:userid",array("userid"=>$_SESSION['userid']));
	}

	$_SESSION = array();

	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}

	session_destroy();
    $dest = "welcome";
	header("Location: ".$dest);
?>