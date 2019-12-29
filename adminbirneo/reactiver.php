<?php 
    include("../res/config.php");
    include("../res/secure.php");
    if(!$_SESSION['userid'] == 1 || !$_SESSION['userid'] == 2 || !$_SESSION['userid'] == 3)
    {
        header("Location: ../home");
    }else
  	{
    if(isset($_SESSION['adminbirneo']) && $_SESSION['adminbirneo'] != '')
    {

    }else
    {
      header("Location: connect.php");
    }
  }
    error_reporting(0);
    $token = strip_tags($_GET['token']);

    if($token != $_SESSION['token'])
    {
    	header("Location: index.php");
    }else
    {
    	$id_a_reactiver = intval(strip_tags($_GET['id']));
    	$sql = "UPDATE users SET suspendu=0 WHERE id='$id_a_reactiver'";
    	$bdd->query($sql);
    	header("Location: suspendus.php?message=ok");
    }
?>