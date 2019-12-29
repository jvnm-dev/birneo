<?php
  header('Content-type: text/html; charset=utf-8');
  require "res/config.php";
  require "res/secure.php";
  require "functions/profile.func.php";
  require "req/profile.req.php";
  $bdd->query("SET NAMES 'utf8'");
  $username = strip_tags($_GET['username']);
  $profil = $bdd->query("SELECT * FROM users WHERE username=:username",array("username"=>$username));
  $my_info = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));

  $id_exp = $_SESSION['userid'];
  $id_dest = $profil[0]['id'];
  $id = $profil[0]['id'];
  $profile = get_member_informations($id);
?>
<html>
  <head>
      <meta charset="utf-8">
      <title>
        <?php 
          switch ($profil[0]['type']) {
            case 'public':
                echo "Portfolio de ".$profil[0]['surname']." ".$profil[0]['name'];
              break;
            case 'anonyme':
                echo "Portfolio de ".$profil[0]['surname']." ".$profil[0]['name'];
            break;
            default:
                echo "Profil introuvable";
            break;
          }
        ?>
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
        require "class/profile.php";
        require "modal/photo.php";
        
        $verif_amis_req = $bdd->query("SELECT count(*) FROM friends WHERE id_exp = :userid1 AND id_dest = :profileid1 AND active = :un1
                                                             OR    id_exp = :profileid2 AND id_dest = :userid2 AND active = :un2",array(
                                                                "userid1"=>$_SESSION['userid'],
                                                                "profileid1"=>$profile[0]['id'],
                                                                "un1"=>"1",
                                                                "profileid2"=>$profile[0]['id'],
                                                                "userid2"=>$_SESSION['userid'],
                                                                "un2"=>"1",
                                                              ));
        $verif_amis = $verif_amis_req[0]['count(*)'];
        if($_SESSION['userid'] == $profile[0]['id'])
        {
          $verif_amis = 1;
        }
        if($verif_amis == 0)
        {
          ?>
          <div class='container' style='margin-top:-10px;'>
              <div class='well'>
                <div class='alert alert-error'>
                  Accès au profil refusé
                </div>
                  <h1>Ce profil est privé. <a class="btn btn-large btn-primary" href="../check/demanderPermission.php?username=<?php echo $_GET['username']; ?>"><i class="icon-white icon-unlock"></i> Demander la permission</a></h1>
                  <p>L'utilisateur que vous recherchez a activé la fonction "anonyme".</p>
                  <p>Vous pouvez <a  style='color:black' href="../check/demanderPermission.php?username=<?php echo $_GET['username']; ?>">demander à être dans sa liste blanche*</a>.</p>
                  <p><small>*La "liste blanche" est la liste des utilisateurs permis à accéder à ce profil.</small></p>
              </div>
          
          <?php
        }else
        {
      ?>
      <div class="container" style="margin-top: 30px;">
        <div class="row">
          <div class="span12 well">
            <div class="page-header">
              <h1>Portfolio de <?php echo $profile[0]['surname'], " ", $profile[0]['name']; ?></h1>
              <?php 
                if($profile[0]['id'] == $_SESSION['userid'])
                {
                  ?>
                    <a data-toggle="modal" href="#addPhoto" class="btn btn-primary"><i class="icon-white icon-picture"></i> Ajouter une photo</a> 
                  <?php
                }
              ?>
                    <a data-toggle="modal" href="../profile/<?php echo $profile[0]['username']; ?>" class="btn btn-primary"><i class="icon-white icon-user"></i> Retourner à son profil</a>
            </div><br />
                <div class='well' style="border:none;margin-top:-50px;">
                  <?php
                    $photo_req = $bdd->query("SELECT count(*) FROM photo WHERE id_proprio = :profileid ORDER BY id DESC",array("profileid"=>$profile[0]['id']));
                    $nbrePhoto = $photo_req[0]['count(*)'];
                    if($nbrePhoto == 0)
                    {
                      ?>
                        <h3>Ce portfolio est vide...</h3>
                      <?php
                    }else
                    {
                      $photo_req = $bdd->query("SELECT * FROM photo WHERE id_proprio = :profileid ORDER BY id DESC",array("profileid"=>$profile[0]['id']));
                      foreach($photo_req as $data)
                      {
                        ?>
                          <div class="span2 well" style="height: 190px;">
                            <a data-toggle="lightbox" href="#<?php echo $profile[0]['username']; ?>_photo<?php echo $data['id']; ?>" class="thumbnail" style="max-width: 200px;max-height: 200px;"><img src="../photo/<?php echo base64_decode($data['name']); ?>" style="max-height:180px;"/></a>
                            <p style="text-align: center;background-color: rgba(0, 0, 0, 0.2);color:white;"><?php echo tronque($data['description'],20);  ?></p>
                            <div id="<?php echo  $profile[0]['username']; ?>_photo<?php echo $data['id']; ?>" class="lightbox hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class='lightbox-content'>
                                <img src="../photo/<?php echo base64_decode($data['name']); ?>">
                                <div class="lightbox-caption"><p class="birneo_unselectable"><?php echo $data['description'];  ?></p></div>
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
        }
        
      ?>

     <?php include("res/script_profil.php"); ?>
   </body>
</html>