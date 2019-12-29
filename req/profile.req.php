<?php
	$username = DestroyHTML($_GET['username']);
	$profil = $bdd->query("SELECT * FROM users WHERE username=:username",array("username"=>$username));
	$my_info = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
	$id_exp = $_SESSION['userid'];
	$id_dest = $profil[0]['id'];
	$id = $profil[0]['id'];
	$profile = get_member_informations($id);
?>