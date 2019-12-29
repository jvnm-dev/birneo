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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
     <meta charset="utf-8">
      <title>Administation - Accueil</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="shortcut icon" href="../assets/ico/favicon.png">

    <!-- Loading Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="css/flat-ui.css" rel="stylesheet">

    

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body style="margin-left:40px;">
    <?php 
    $id = DestroyHTML($_GET['id']);
    $reactionSur = $bdd->query("SELECT * FROM users WHERE id=:id",array("id"=>$id));
    $nomCompletCoupable = $reactionSur[0]['name'].' '.$reactionSur[0]['surname'];
    $affaireid = DestroyHTML($_GET['affaire']);
    $avatar = base64_decode($reactionSur[0]['avatar']);

    $signalement = $bdd->query("SELECT * FROM signalement WHERE id=:affaireid",array("affaireid"=>$affaireid));
    $signaleur = $bdd->query("SELECT * FROM users WHERE id=:signalementsignalerpar",array("signalementsignalerpar"=>$signalement[0]['signalerPar']));
    $nomCompletSignaleur = $signaleur[0]['name'].' '.$signaleur[0]['surname'];
    if($signalement[0]['type'] == 1)
    {
      $typeInfraction = "Publication";
      $idInfraction = intval($signalement[0]['id_post']);
      $infraction = $bdd->query("SELECT * FROM posts WHERE id=:idinfraction",array("idinfraction"=>$idInfraction));
      $link = "../publication/".$infraction[0]['id'];

    }elseif($signalement[0]['type'] == 2)
    {
      $typeInfraction = "Commentaire";
      $idInfraction = intval($signalement[0]['id_post']);
      $infractionReq = $bdd->query("SELECT * FROM comments WHERE id=:idinfraction",array("idinfraction"=>$idInfraction));
      $link = "../publication/".$infraction[0][0]['id_publication'];
    }elseif($signalement[0]['type'] == 3)
    {
      $typeInfraction = "Photo";
      $idInfraction = intval($signalement[0]['id_post']);
      $infractionReq = $bdd->query("SELECT * FROM photo WHERE id=:idinfraction",array("idinfraction"=>$idInfraction));
      $link = "../portfolio/".$reactionSur[0]['id'];
    }


  ?>
  <?php include("navbar.php"); ?>
  <div class="container">
    <div class="row">
      <div class="well">
        <h3>Réaction sur <?php echo $nomCompletCoupable ?> concernant le signalement #<?php echo $affaireid; ?></h3>
            <div class="span4">
            <h4>Informations sur l'utilisateur</h4>
              <div class="media">
                <a class="pull-left" href="#">
                  <img class="media-object" src="<?php echo $avatar; ?>" style="max-height:100px;max-width:100px;"/>
                </a>
                  <div class="media-body">
                    <h4 class="media-heading"><?php echo $nomCompletCoupable; ?></h4>
                      <ul>
                        <li><?php echo $reactionSur[0]['sex']; ?></li>
                        <li><?php echo $reactionSur[0]['situation']; ?></li>
                        <li><?php echo $reactionSur[0]['job']; ?></li>
                        <li>Avertissement(s): <?php echo $reactionSur[0]['avertissement']; ?></li>
                      </ul>
                  </div>
              </div>
            </div>
            <div class="span4">
              <h4>Infraction de l'utilisateur</h4>
                <div class="media">
                  <a class="pull-left" href="#">
                    
                  </a>
                    <div class="media-body">
                      <h4 class="media-heading"><?php echo $typeInfraction; ?></h4>
                        <p>Contenu: <blockquote><?php echo $infraction[0]['content']; ?></blockquote></p>
                        <p><a class="btn btn-inverse" target="_blank" href="<?php echo $link; ?>">Voir la source</a></p>
                    </div>
                </div>
            </div><br />
            
            <div class="span12">
              <p><label>Action sur la personne qui a été signalée (<?php echo $nomCompletCoupable ?>):</label> <a class="btn btn-primary" href="avertir.php?id=<?php echo $reactionSur[0]['id']; ?>&signalement=<?php echo $affaireid; ?>">Avertir l'utilisateur</a> <a href="suspendre.php?id=<?php echo $reactionSur[0]['id']; ?>&signalement=<?php echo $affaireid; ?>" class="btn btn-danger">Suspendre le compte de l'utilisateur</a> <a class="btn btn-primary" href="banip.php?id=<?php echo $reactionSur[0]['id']; ?>&signalement=<?php echo $affaireid; ?>">Bannir l'ip de l'utilisateur</a></p>
              <p><label>Action sur la personne qui a signalé (<?php echo $nomCompletSignaleur ?>):</label> <a class="btn btn-primary" href="avertir.php?id=<?php echo $signaleur[0]['id']; ?>&signalement=<?php echo $affaireid; ?>">Avertir l'utilisateur</a> <a href="suspendre.php?id=<?php echo $signaleur[0]['id']; ?>&signalement=<?php echo $affaireid; ?>" class="btn btn-danger">Suspendre le compte de l'utilisateur</a> <a class="btn btn-primary" href="banip.php?id=<?php echo $signaleur[0]['id']; ?>&signalement=<?php echo $affaireid; ?>">Bannir l'ip de l'utilisateur</a></p>
              <p><label>Action sur les deux personnes (<?php echo $nomCompletCoupable ?> et <?php echo $nomCompletSignaleur ?>):</label> <a class="btn btn-warning" href="pardonner.php?signalement=<?php echo $affaireid; ?>&id=<?php echo $reactionSur[0]['id']; ?>">Pardonner</a> </p>

            </div>   
    </div>
    </div>

    <!-- Load JS here for greater good =============================-->
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script src="js/flatui-checkbox.js"></script>
    <script src="js/flatui-radio.js"></script>
    <script src="js/jquery.tagsinput.js"></script>
    <script src="js/jquery.placeholder.js"></script>
  </body>
</html>
