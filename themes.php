<?php
  header('Content-type: text/html; charset=utf-8');
  require "res/config.php";
  require "res/secure.php";
  require "functions/profile.func.php";
  $bdd->query("SET NAMES 'utf8'");
  $my_info = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $_SESSION['userid']));
  $username = $my_info[0]['username'];
  $profil = $bdd->query("SELECT * FROM users WHERE username = :username", array("username"=> $username));
  $id_exp = $_SESSION['userid'];
  $id_dest = $profil[0]['id'];
  $id = $profil[0]['id'];
  $profile = get_member_informations($id);

?>
<html>
  <head>
      <meta charset="utf-8">
      <title>
        Birneo - Thèmes
      </title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">

      <!-- Le styles -->
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
      <link href="../assets/css/bootBirneo.css" rel="stylesheet">
      <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
      <link rel="stylesheet" href="../assets/css/bootstrap-lightbox.css" type="text/css" media="screen" />
      <style type="text/css">
      body {
        padding-top: 46px;
        padding-bottom: 40px;
      }
      .avatar {
         padding: 4px;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        -webkit-border-radius: 500px;
          -moz-border-radius: 500px;
          border-radius: 500px;
          -webkit-transition: all .3s ease-in-out;
          -moz-transition: all .3s ease-in-out;
          -o-transition: all .3s ease-in-out;
          transition: all .3s ease-in-out;
      }

      .avatar:hover {
        padding: 4px;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        -webkit-border-radius: 0px;
          -moz-border-radius: 0px;
          border-radius: 0px;
        background-color: #fff;
        -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
           -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
              box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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

      .noborder{
        border:none;
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
        
        $bdd->bind("id_exp",$_SESSION['userid']);
        $bdd->bind("id_dest",$profile[0]['id']);
        $bdd->bind("id_exp2",$profile[0]['id']);
        $bdd->bind("id_dest2",$_SESSION['userid']);
        $verif_amis = $bdd->query("SELECT count(*) FROM friends WHERE id_exp = :id_exp AND id_dest = :id_dest AND active = '1'
                                                             OR    id_exp = :id_exp2 AND id_dest = :id_dest2 AND active = '1'");
        if($_SESSION['userid'] == $profile[0]['id'])
        {
          $verif_amis[0]['count(*)'] = 1;
        }
        if($verif_amis[0]['count(*)'] == 0)
        {
          ?>
          <div class='container' style='margin-top:-10px;'>
              <div class='well'>
                <div class='alert alert-error'>
                  Accès au profil refusé
                </div>
                  <h1>Ce profil est privé. <a class="btn btn-large btn-primary"><i class="icon-white icon-unlock"></i> Demander la permission</a></h1>
                  <p>L'utilisateur que vous recherchez a activé la fonction "anonyme".</p>
                  <p>Vous pouvez <a href='#' style='color:black'>demander à être dans sa liste blanche*</a>.</p>
                  <p><small>*La "liste blanche" est la liste des utilisateurs permis à accéder à ce profil.</small></p>
              </div>
          
          <?php
        }else
        {
      ?>
      <div class="container" style="margin-top: 30px;">
        <div class="row">
          <div class="span12 well">
            <h1>Thèmes disponibles</h1><br />
                  <?php
                    $theme = $bdd->query("SELECT * FROM theme ORDER BY name ASC");


                    foreach($theme as $data)
                    {
                      $user = $bdd->query("SELECT * FROM users WHERE id = :iduser", array("iduser"=>$_SESSION['userid']));

                      
                      ?>
                        <form id="theme<?php echo $data['id']; ?>" method="POST" action="../check/changerTheme.php" style="display:none;">
                          <input id="color_primary" name="color_primary" type="hidden" value="<?php echo $data['color1']; ?>"/>
                          <input id="color_secondary" name="color_secondary" type="hidden" value="<?php echo $data['color2']; ?>"/>
                        </form>
                        <div class="span5  well" style="padding-top:0px;border-color: <?php echo $data['color1']; ?>">
                          <h3 style="color: <?php echo $data['color1']; ?>"><?php echo $data['name']; ?>
                            <?php 

                              if(trim($data['color1']) == trim($user[0]['color_primary']))
                              {
                                echo "<i class='icon-ok-sign'></i>";
                              }else
                              {
                                ?>
                                  <small><a onclick="sendTheme(<?php echo $data['id']; ?>);" id="themeChoix" style="color: <?php echo $data['color1']; ?>;cursor: pointer;"><b><i class="icon-hand-right"></i> <u>Choisir</u></b></a></small>
                                <?php
                              }

                            ?>
                          </h3>
                          <ul>
                            <li style="color:white;padding: 5px;width:26%;list-style-type: none;background-color: <?php echo $data['color1']; ?>">Couleur primaire </li>
                            <li style="color:white;padding: 5px;width:26%;list-style-type: none;background-color: <?php echo $data['color2']; ?>">Couleur secondaire </li>
                          </ul>
                          

                        </div>
                      <?php
                    }
                  ?>

            </div>
          </div>
        </div>
        <?php
        }
      ?>

     <?php include("res/script_profil.php"); ?>
   </body>
</html>