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

  if(isset($_POST['submit']))
  {
    $id = DestroyHTML($_GET['id']);
    $contenu = DestroyHTML($_POST['contenu']);
    $signalement = DestroyHTML($_GET['signalement']);
    $bdd->query("INSERT INTO rapport(raison,id_signalement) 
                 VALUES(:contenu,:signalement)",array("contenu"=>$contenu,"signalement"=>$signalement));

    $query = $bdd->query("UPDATE users SET suspendu = 1
                WHERE id=:id",array("id"=>$id));
    $query = $bdd->query("UPDATE signalement SET regler = 1
                WHERE id=:signalement",array("signalement"=>$signalement));
    $texte = "L'admin ou modérateur qui porte l'id \"".DestroyHTML($_SESSION['userid'])."\" a suspendu le compte de l'utilisateur portant l'id \"".$id."\"";
                logMoiCa($texte,"../logs/admin.txt");

    header("Location: ./signalements.php?message=ok");
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <title>Birneo - Avertir un utilisateur</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">

      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
      <link href="../assets/css/bootBirneo.css" rel="stylesheet">
      <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <style type="text/css">

      html,
      body {
        height: 100%;
      }

      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        margin: 0 auto -60px;
      }

      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }

      .container {
        width: auto;
        max-width: 680px;
      }
      .container .credit {
        margin: 20px 0;
      }

    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>


    <div id="wrap">

      <div class="container">
        <div class="well" style="">
          <form action="" method="POST">
            <label><h2>Raison de ce bannissement</h2></label>
              <textarea id="contenu" name="contenu" style="width:80%;" rows="5"></textarea>
              <input name="submit" type="submit" class="btn btn-block btn-primary" style="width:83%;"/>
          </form>
        </div>
      </div>

    </div>

  </body>
</html>

