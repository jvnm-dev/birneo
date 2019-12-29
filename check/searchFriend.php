<?php
	$_POST['search'] = str_replace("@","",$_POST['search']);
	$_POST['search'] = str_replace("&","",$_POST['search']);
	$_POST['search'] = str_replace("#","",$_POST['search']);
	header("Location: ../profile/".$_POST['search']);	
?>