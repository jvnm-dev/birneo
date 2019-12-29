<?php 
    include("../res/config.php");
    include("../res/secure.php");
    $admin = $bdd->query("SELECT * FROM users WHERE id =:userid",array("userid"=>$_SESSION['userid']));

    if($admin[0]['admin'] == 0)
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

  $signalement = DestroyHTML($_GET['signalement']);

  $query = $bdd->query("UPDATE signalement SET regler = 2
              WHERE id=:signalement",array("signalement"=>$signalement));
  $texte = "L'admin ou modérateur qui porte l'id \"".$_SESSION['userid']."\" a pardonné l'utilisateur portant l'id \"".DestroyHTML($_GET['id'])."\"";
              logMoiCa($texte,"../logs/admin.txt");

  header("Location: ./signalements.php?message=ok");

?>
