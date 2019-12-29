<?php
  $index = 1;
  include("res/config.php");
  include("res/secure.php");
  if(isset($_SESSION['userid']))
  {
    header("location: home");
  }
?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Bienvenue sur Birneo</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">

      <!-- Le styles -->
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
      <link href="assets/css/bootBirneo.css" rel="stylesheet">
      <?php
      $total = "7";
      $file_type = ".jpg";
      $image_folder = "assets/img/";
      $start = "1";
      $random = mt_rand($start, $total);
      $image_name = $random . $file_type;
      $image = $image_folder."background".$image_name;
      ?>
       <style>
      html, body {
      height: 98%;
      background: url(<?php echo $image; ?>) no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      }
      footer {
      color: #666;
      background: #222;
      padding: 17px 0 18px 0;
      border-top: 1px solid #000;
      height: 15px;
      }
      footer a {
      color: #999;
      }
      footer a:hover {
      color: #efefef;
      }
      .wrapper {
      min-height: 100%;
      height: auto !important;
      height: 100%;
      margin: 0 auto -63px;
      }
      .push {
      height: 63px;
      }
      /* not required for sticky footer; just pushes hero down a bit */
      .wrapper > .container {
      padding-top: 10px;
      }
      </style>
      <link href="assets/css/bootplus-responsive.css" rel="stylesheet">

      <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <![endif]-->

      <!-- Fav and touch icons -->
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">
  </head>

  <body>
      <?php
        include("modal/inscription.php");
      ?>
      
               
               <div id="registerok" class="alert alert-success span5" style="position: absolute;z-index: 1000;margin: 0 auto;display: none;">
                <h3><strong>Inscription complétée</strong></h3>
                <p>Vous pouvez désormais vous connecter.</p>
               </div>
               <div id="registernotok1" class="alert alert-error span5" style="position: absolute;z-index: 1000;margin: 0 auto;display: none;">
                <h3><strong>Inscription non complétée</strong></h3>
                <p>Ce nom d'utilisateur est déjà utilisé.</p>
               </div>
               <div id="registernotok2" class="alert alert-error span5" style="position: absolute;z-index: 1000;margin: 0 auto;display: none;">
                <h3><strong>Inscription non complétée</strong></h3>
                <p>Cet adresse email est déjà utilisé.</p>
               </div>
               <div id="registernotok3" class="alert alert-error span5" style="position: absolute;z-index: 1000;margin: 0 auto;display: none;">
                <h3><strong>Connexion impossible</strong></h3>
                <p>Adresse email ou mot de passe incorrect.</p>
               </div>
               <div id="already" class="alert alert-error span5" style="position: absolute;z-index: 1000;margin: 0 auto;display: none;">
                <h3><strong>Inscription non complétée</strong></h3>
                <p>Adresse email ou nom d'utilisateur déjà utilisé.</p>
               </div>



                <div class="wrapper" style="margin-top:30px;">
                  <div class="container well" style="width:600px;">
                      <div class="page-header" style="margin:0;padding:0;">
                        <h1>Bienvenue sur Birneo</h1>
                      </div>

                      <div class="span3" style="border-right: 1px solid #F0F0F0;padding-top:5px;">
                        <form id="login" method="POST" action="check/login.php">
                         <input id="email" name="email" class="span2" type="text" placeholder="Adresse email" style="display:block;height:50px;width:90%;font-size:20px;border-radius:10px;">
                         <input id="password" name="password" class="span2" type="password" placeholder="Mot de passe" style="display:block;height:50px;width:90%;font-size:20px;border-radius:10px;">
                         <button id="loginSubmit" class="btn btn-large btn-danger btn-block" style="width:95%;">Connexion</button>
                       </form>
                     </div>
                     <div class="span2">
                        <h4>Envie de découvrir ?</h4>
                        <a id="popover" href="#register" role="button" data-toggle="modal" class="btn btn-danger btn-large" data-placement="bottom" title="C'est gratuit" data-content="Ainsi que tout le reste du site !">S'inscrire &raquo;</a>
                     </div>
                  </div>
                  <div class="container well" style="width:600px;">
                    <div class="page-header" style="margin:0;padding:0;text-align:center;">
                        <h1>Découvrez, partagez, rencontrez</h1>
                      </div>
                      <div class="row-fluid">
                        <ul class="thumbnails">
                          <li class="span4">
                            <a class="thumbnail">
                              <img src="../assets/img/1.jpg" alt="">
                            </a>
                          </li>
                          <li class="span4">
                            <a class="thumbnail">
                              <img src="../assets/img/2.jpg" alt="">
                            </a>
                          </li>
                          <li class="span4">
                            <a class="thumbnail">
                              <img src="../assets/img/3.jpg" alt="">
                            </a>
                          </li>
                        </ul>
                      </div>
                      <div class="row-fluid">
                        <ul class="thumbnails">
                          <li class="span4">
                            <a class="thumbnail">
                              <img src="../assets/img/4.jpg" alt="">
                            </a>
                          </li>
                          <li class="span4">
                            <a class="thumbnail">
                              <img src="../assets/img/5.jpg" alt="">
                            </a>
                          </li>
                          <li class="span4">
                            <a class="thumbnail">
                              <img src="../assets/img/6.jpg" alt="">
                            </a>
                          </li>
                        </ul>
                      </div>
                  </div>
                  
                  </div>
                  

                  <div class="push"><!--//--></div>
                  </div>
                  <footer>
                    <div class="container">
                        <?php include("skull/footer.php"); ?>
                    </div>
                </footer>

      <script src="assets/js/jquery.js"></script>
      <script src="assets/js/bootstrap-transition.js"></script>
      <script src="assets/js/bootstrap-alert.js"></script>
      <script src="assets/js/bootstrap-modal.js"></script>
      <script src="assets/js/bootstrap-dropdown.js"></script>
      <script src="assets/js/bootstrap-scrollspy.js"></script>
      <script src="assets/js/bootstrap-tab.js"></script>
      <script src="assets/js/bootstrap-tooltip.js"></script>
      <script src="assets/js/bootstrap-popover.js"></script>
      <script src="assets/js/bootstrap-button.js"></script>
      <script src="assets/js/bootstrap-collapse.js"></script>
      <script src="assets/js/bootstrap-carousel.js"></script>
      <script src="assets/js/bootstrap-typeahead.js"></script>
      <script src="assets/js/script_register.js"></script>
      <?php include("assets/js/reply_home.php"); ?>
      <script>
        $("#loginSubmit").click(function(){
          var email = $("#loginEmail");
          var password = $("#loginPassword");
          var form = $("#login");
          if(email.val() != "")
          {
            email.css("border","3px solid #5aac41");
          }else
          {
            email.css("border","3px solid #dd4b39");
            return false;
          }
          if(password.val() != "")
          {
            password.css("border","3px solid #5aac41");
          }else
          {
            password.css("border","3px solid #dd4b39");
            return false;
          }
        });
      </script>
      <script>
        $( document ).ready(function() {
            var img = $("img");
            img.fadeIn();
        });
      </script>
   </body>
</html>
