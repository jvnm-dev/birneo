<?php
  header('Content-type: text/html; charset=utf-8');
  include("../res/config.php");
    include("../res/secure.php");
  if(!$_SESSION['userid'] == 1 || !$_SESSION['userid'] == 2 || !$_SESSION['userid'] == 3)
  {
    header("Location: ../home");
  }else
  {
    if(isset($_SESSION['adminbirneo']) && $_SESSION['adminbirneo'] != '')
    {
      header("Location: index.php");
    }
  }
  error_reporting(0);

  if($_GET['token'] == '')
  {
    header("Location: ../home");
  }else
  {
    if($_GET['token'] != $_SESSION['token'])
    {
      header("Location: ../home");
    }
  }

?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Gestion Birneo</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">

      <!-- Le styles -->
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
      
      <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
      <style type="text/css">
      @import url(http://weloveiconfonts.com/api/?family=entypo);
@import url(http://fonts.googleapis.com/css?family=Roboto);

/* zocial */
[class*="entypo-"]:before {
  font-family: 'entypo', sans-serif;
}

*,
*:before,
*:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box; 
}


h2 {
  color:grey;
  margin-left:12px;
}

body {
  background: #f0f0f0;
  font-family: 'Roboto', sans-serif;
  
}

form {
  position:relative;
  margin: 50px auto;
  width: 380px;
  height: auto;
}

input {
  padding: 16px;
  border-radius:7px;
  border:0px;
  background: rgba(255,255,255);
  display: block;
  margin: 15px;
  width: 300px;  
  color:grey;
  font-size:18px;
  height: 54px;
}

input:focus {
  outline-color: rgba(0,0,0,0);
  background: rgba(255,255,255,.95);
  color: #0fc0bc;
}

button {
  float:right;
  height: 121px;
  width: 50px;
  border: 0px;
  background: #0fc0bc;
  border-radius:7px;
  padding: 10px;
  color:white;
  font-size:22px;
}

.inputUserIcon {
  position:absolute;
  top:68px;
  right: 80px;
  color:white;
}

.inputPassIcon {
  position:absolute;
  top:136px;
  right: 80px;
  color:white;
}

input::-webkit-input-placeholder {
  color: grey;
}

input:focus::-webkit-input-placeholder {
  color: #0fc0bc;
}

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
          if(isset($_POST['submit']))
          {
            $prenom = trim(htmlspecialchars($_POST['prenom']));
            $password = md5($_POST['password']);
            $query = $bdd->query("SELECT count(*) FROM admin WHERE name=:prenom AND password=:password",array("prenom"=>$prenom,"password"=>$password));
            $count = $query[0]['count(*)'];
            if($count == 1)
            {
              $texte = "Connexion de l'admin ou modérateur qui porte l'id \"".intval($_SESSION['userid'])."\"";
              logMoiCa($texte,"../logs/admin.txt");
              session_regenerate_id();
              $_SESSION['adminbirneo'] = strip_tags($prenom);
              header("Location: index.php");
            }else
            {
              echo "<p style='text-align:center;color:red;'>Prénom ou mot de passe incorrect.</p>";
            }
          }
        ?>
        <form action="" method="POST">
          <h2><span class="entypo-login"></span> Connexion au panel de gestion</h2>
          <button id="submit" name="submit" class="submit"><span class="entypo-lock"></span></button>
          <span class="icon-user inputUserIcon"></span>
          <input id="prenom" name="prenom" type="text" class="user" placeholder="Prénom"/>
          <span class="icon-lock inputPassIcon"></span>
          <input id="password" name="password" type="password" class="pass"placeholder="Mot de passe"/>
        </form>

     <?php include("../res/script_support.php"); ?>
   </body>
</html>
