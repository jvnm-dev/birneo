<?php
  header('Content-type: text/html; charset=utf-8');
  require "res/config.php";
  require "res/secure.php";
  require "functions/profile.func.php";
  $bdd->query("SET NAMES 'utf8'");
  $my_info = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));

  $username = $my_info[0]['username'];
  $profil = $bdd->query("SELECT * FROM users WHERE username=:username",array("username"=>$username));
  
  $id_exp = $_SESSION['userid'];
  $id_dest = $profil[0]['id'];
  $id = $profil[0]['id'];
  $profile = get_member_informations($id);

?>
<html>
  <head>
      <meta charset="utf-8">
      <title>
        Birneo - Vos notifications
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
      <div class="container" style="margin-top: 30px;">
        <div class="row">
          <div class="span12 well">
            <h1>Vos notifications</h1><br />
                  <?php
                    $notif_req = $bdd->query("SELECT * FROM notification WHERE id_proprio=:userid ORDER BY id DESC",array("userid"=>$_SESSION['userid']));


                    foreach($notif_req as $data)
                    {
                      $user = $bdd->query("SELECT * FROM users WHERE id=:dataidexp",array("dataidexp"=>$data['id_exp']));
                      if(isset($user) && !empty($user))
                      {
                      ?>
                      <div class="span5" style="margin-bottom: 5px">
                            <div class="media notifBirneo" style="border-radius: 5px" onclick='location.href="../<?php echo $data['link']; ?>"'">
                              <a href="#<?php echo $user[0]['username']; ?>_photoBox" class="pull-left">
                                <img src="<?php echo base64_decode($user[0]['avatar']); ?>" class="img-polaroid" style="max-height:75px;max-width:75px;">
                              </a>
                              <div class="media-body">
                                  <p class="lead" style="font-size:17.5px;"><?php echo $data['contenu']; ?></p>
                                </div>
                            </div>
                        </div>
                      <?php
                      }
                    }
                  ?>

            </div>
          </div>
        </div>
        <?php
        
      ?>

     <?php include("res/script_profil.php"); ?>
   </body>
</html>