<?php
  header('Content-type: text/html; charset=utf-8');
  include("res/config.php"); 
  include("res/secure.php"); 
  if(isset($_SESSION['userid']) && $_SESSION['userid'] != '')
  {
    $my_info = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
  }else
  {
    header("Location: welcome");
  }
?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Support Birneo</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">

      <!-- Le styles -->
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
      <link href="../assets/css/bootBirneo.css" rel="stylesheet">
      <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
      <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 60px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }

      .birneo_unselectable
      {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: moz-none;
        -ms-user-select: none;
        user-select: none;
      }

      <?php
        require("res/color.css");
      ?>
        
      </style>
      <link href="../assets/css/bootplus-responsive.css" rel="stylesheet">

      <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
      <![endif]-->

      <!-- Fav and touch icons -->
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>
      <?php
      include("skull/navbar.php"); 
      ?>

       <div class="container-narrow well">

      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li class="active"><?php echo '<a href="http://'.$_SERVER['SERVER_ADDR'].'/support">Paramètres généraux</a>'; ?></li>
          <li><?php echo '<a href="http://'.$_SERVER['SERVER_ADDR'].'/buglist">Sécurité</a>'; ?></li>
          <li><?php echo '<a href="http://'.$_SERVER['SERVER_ADDR'].'/contact">Confidentialité</a>'; ?></li>
        </ul>
        <h3 class="muted">Paramètres</h3>
      </div>

      <hr>
        <?php include("modal/bugreport.php"); ?>
      <div class="jumbotron">
        <h1>Paramètres généraux</h1>
        <p class="lead" style="">...</p>
        
      </div>

      <hr>

      <div class="row-fluid marketing">
        <div class="span6">
          Option 1
        </div>

        <div class="span6">
          Option 2
        </div>
      </div>

      <?php
        include("skull/footer.php");
      ?>

      </div> <!-- /container -->

     <?php include("res/script_support.php"); ?>
   </body>
</html>
