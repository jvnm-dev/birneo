<?php 
  $rapport = 1;
  include("res/config.php");
  $bdd->query("SET NAMES 'utf8'");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <title>Birneo - Rapport #<?php echo $_GET['id_signalement']; ?></title>
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
    <?php 

      $id_signalement = intval($_GET['id_signalement']);
      $rapport = $bdd->query("SELECT * FROM rapport WHERE id_signalement = :id_signalement", array("id_signalement"=> $id_signalement));

    ?>

    <div id="wrap">

      <div class="container">
        <div class="well" style="">
          <div class="page-header"><h3>Rapport du modérateur ID #<?php echo $_GET["id_signalement"]; ?></h3></div>
          <p>
            <label>Raison de l'action du modérateur:</label>
            <blockquote><?php if(isset($rapport[0]['raison'])){ echo $rapport[0]['raison']; }else{ echo "Aucune précision."; } ?></blockquote>  
            <p><a href="../home">Retour à l'accueil</a></p>
          </p>
        </div>
      </div>

    </div>

  </body>
</html>

