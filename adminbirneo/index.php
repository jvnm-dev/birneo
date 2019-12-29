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
      header("Location: connect.php?token=".$_GET['token']);
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
        <?php include("navbar.php"); ?>
          <div class="container">
            <h1>Bienvenue <?php echo ucfirst($_SESSION['adminbirneo']); ?>.</h1>
            <p class="lead">
                Un avertissement doit être distribué si et seulement si la personne en dérange une autre.
                <br />
                Suite à diverses plaintes, un Chef modérateur a été désigné. Il s'agit de <b style="text-decoration:underline;">Cyprien Druart</b>.
            </p>
            <blockquote>
                <p>
                    <h6 style="text-decoration:underline;">1. Qu'est ce qu'un Chef modérateur ?</h6>
                    Le Chef des modérateurs est le responsable de tous les modérateurs et de leurs actions.<br />
                    Il peut promouvoir n'importe qui à être modérateur et peut également destituer quiconque s'opposant au contrat de modération.
                </p>
            </blockquote>
            <blockquote>
                <p>
                    <h6 style="text-decoration:underline;">2. Pourquoi avoir changé l'espace d'administration ?</h6>
                    Suite à des problèmes de sécurité, nous avons décidé de renforcer l'efficacité des modérateurs.<br />
                    Cette espace vous permettra de bannir par IP, réactiver un compte suspendu, ...<br />
                    Nous pouvons également ajouter des fonctionnalités plus facilement
                </p>
            </blockquote>
            <blockquote>
                <small>Rédigé et pensé par Jason Van Malder et Alberto Nasello, Fondateurs de Birneo</small>
            </blockquote>

            <h2>Membres de l'équipe</h2>
            <blockquote>
              <?php 
                $v = $bdd->query("SELECT * FROM users WHERE admin=1 ORDER BY id ASC");
                foreach($v as $k)
                {
                  ?>
                    <p><b><?php echo $k['surname']." ".$k['name']; ?></b></p>
                  <?php
                }
              ?>
            </blockquote>
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
