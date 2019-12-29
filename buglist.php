<?php
  header('Content-type: text/html; charset=utf-8');
  include("res/config.php"); 
  include("res/secure.php"); 
  if(isset($_SESSION['userid']) && $_SESSION['userid'] != '')
  {
    $bdd->bind("userid",$_SESSION['userid']);
    $my_info = $bdd->query("SELECT * FROM users WHERE id = :userid");
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
          <li><?php echo '<a href="../support">Accueil</a>'; ?></li>
          <li class="active"><?php echo '<a href="../buglist">Liste des bugs</a>'; ?></li>
        </ul>
        <h3 class="muted">Support Birneo</h3>
      </div>

      <hr>
      <div class="row">
        <div class="span6">
          <?php
            $query = $bdd->query("SELECT * FROM bug ORDER BY id DESC, statut ASC");
            foreach($query as $row)
            {
              $dn = $bdd->query("SELECT * FROM users WHERE id=:rowidposter", array("rowidposter"=>$row['id_poster']));
              $avatar = base64_decode($dn[0]['avatar']);
              $username = $dn[0]['username'];
              if($row['statut'] == 0)
              {
                $statut = '<span class="label pull-right">En attente</span>';
              }elseif($row['statut'] == 1)
              {
                $statut = '<span class="label pull-right">En cours de résolution</span>';
              }elseif($row['statut'] == 2)
              {
                $statut = '<span class="label pull-right label-success">Résolu</span>';
              }
            ?>
              <div id="bug<?php echo $row['id']; ?>" class="well span6">
                <h4><strong><?php echo ucfirst($row['titre']); ?></strong></h4><?php echo $statut; ?>
                <p><strong><?php echo ucfirst($row['content']); ?></strong></p>
                <small><strong>Par <?php echo ucfirst($username); ?></strong></small>
                <?php 
                  if($my_info[0]['admin'] == 1)
                  {
                    ?>
                    <hr />
                    <?php
                    if($my_info[0]['admin'] == 1)
                    {
                      ?>
                        <div class="span4">
                          <h4>Que faire ?</h4>
                          <form action="../check/bugResolu.php" method="POST">
                            <label>Changer le statut</label>
                            <input id="idBug" name="idBug" type="text" value="<?php echo $row['id']; ?>" style="display:none;" />
                            <p><input type="submit" style="-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: moz-none;-ms-user-select: none;user-select: none;" class="btn"/></p>
                          </form>
                        </div>
                      <?php
                    }
                  }
                ?>
              </div>
            <?php
            }
          ?>
        </div>
      </div>

      <?php
        include("skull/footer.php");
      ?>

      </div> <!-- /container -->

     <?php include("res/script_support.php"); ?>
   </body>
</html>
