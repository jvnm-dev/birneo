<?php
	require_once __DIR__ . '/config.php';
	function getToken($id)
	{
		global $bdd;

		$getSessionTokenOk = $bdd->query("SELECT token FROM users WHERE id = :id", array("id"=> $id));
		$token = $getSessionTokenOk[0]['token'];
		return $token;
	}
	if(isset($_SESSION['userid']))
	{
		$id = intval($_SESSION['userid']);
		$token = getToken($_SESSION['userid']);
		if($token == $_SESSION['token'])
		{
			$tokenValid = 1;
		}else
		{
			header("Location: ../logout");
		}
	}
?>