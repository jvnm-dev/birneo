<?php
  header('Content-type: text/html; charset=utf-8');
  include("res/config.php");
  include("res/secure.php");  
  if(isset($_SESSION['userid']) && $_SESSION['userid'] != '')
  {
    $my_info = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $_SESSION['userid']));
    $discussion = $bdd->query("SELECT * FROM discussion WHERE id = :id ORDER BY date DESC", array("id"=> $_GET['id']));
    if($discussion[0]['readed'] == 0)
    {
      if($discussion[0]['notifPour'] == $_SESSION['userid'])
      {
        $bdd->query("UPDATE discussion SET readed=1 WHERE id = :id", array("id"=> $_GET['id']));
      }
    }
    if($_SESSION['userid'] == $discussion[0]['id_1'] || $_SESSION['userid'] == $discussion[0]['id_2']){
      if($_SESSION['userid'] == $discussion[0]['id_1'])
      {
        $nomprenom = $bdd->query("SELECT * FROM users WHERE id= :id", array("id"=> $discussion[0]['id_2']));
        $nom = $nomprenom[0]['name'];
        $prenom = $nomprenom[0]['surname'];
      }else if($_SESSION['userid'] == $discussion[0]['id_2'])
      {
        $nomprenom = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=>$discussion[0]['id_1']));
        $nom = $nomprenom[0]['name'];
        $prenom = $nomprenom[0]['surname'];
      }
    }else
    {
      header("Location: ../home");
    }
  }else
  {
    header("Location: welcome");
  }
  function place_smiley($var)
  {
    $smileys_code = array(
          ":)",
      ":-)",
      ":D",
      ":-D",
      ":d",
      ":-d",
      ":p",
      ":-p",
      ":P",
      ":-P",
      "^^",
      "^_^",
      "^-^",
      "&lt;3",
      ":o",
          ":-o",
          ":O",
          ":-O",
          ":(",
          ":-(",
          ":-/",
          ":'(",
          ":'-(",
          "&lt;br /&gt;"
      );
      $smileys = Array (
        "<img src='../assets/img/content.gif' title=':)'  />",
      "<img src='../assets/img/content.gif' title=':)'  />",
      "<img src='../assets/img/rire.gif' title=':D'  />",
      "<img src='../assets/img/rire.gif' title=':D'  />",
      "<img src='../assets/img/rire.gif' title=':D'  />",
      "<img src='../assets/img/rire.gif' title=':D'  />",
      "<img src='../assets/img/langue.gif' title=':p'  />",
      "<img src='../assets/img/langue.gif' title=':-p'  />",
      "<img src='../assets/img/langue.gif' title=':P'  />",
      "<img src='../assets/img/langue.gif' title=':-P'  />",
      "<img src='../assets/img/^^.gif' title='^^'  />",
      "<img src='../assets/img/^^.gif' title='^^'  />",
      "<img src='../assets/img/^^.gif' title='^^'  />",
      "<img src='../assets/img/love.gif' title='<3'  />",
      "<img src='../assets/img/etonne.gif' title=':o'  />",
          "<img src='../assets/img/etonne.gif' title=':o'  />",
          "<img src='../assets/img/etonne.gif' title=':o'  />",
          "<img src='../assets/img/etonne.gif' title=':o'  />",
          "<img src='../assets/img/pascontent.gif' title=':('  />",
          "<img src='../assets/img/pascontent.gif' title=':('  />",
          "<img src='../assets/img/semitriste.gif' title=':/'  />",
          "<img src='../assets/img/triste.gif' title=\":'(\"  />",
          "<img src='../assets/img/triste.gif' title=\":'(\"  />",
            "<br />"

    );
    $var = str_replace($smileys_code, $smileys, $var);
    return $var;
  }

  function urlToLink($var)
  {
    $var = preg_replace('`((?:https?|ftp)://\S+?)(?=[[:punct:]]?(?:\s|\Z)|\Z)`', '<a target="_blank" href="$1$2">$1$2</a>', $var);
    return $var;
  }

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title><?php echo $prenom,' ',$nom; ?> - Discussion</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">

      <!-- Le styles -->
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
      <link href="../assets/css/bootBirneo.css" rel="stylesheet">
      <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
      <style>
      body {
        padding-top: 60px; 
      }
      .divider {
        *width: 100%;
        height: 1px;
        margin: 9px 1px;
        *margin: -5px 0 5px;
        overflow: hidden;
        background-color: #e5e5e5;
        border-bottom: 1px solid #ffffff;
      }
      .error
      {
        border: solid 1px red;
      }
      <?php
        require("res/color.css");
      ?>
      </style>
      <link href="../assets/css/bootplus-responsive.css" rel="stylesheet">
      <link href="../assets/css/font-awesome-ie7.min.css" rel="stylesheet">

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

  <body onload="scrolldown();">

     <?php
      include("skull/navbar.php"); 
      ?>

    <div class="container well" style="margin-top:-30px;">

      <div class="page-header">
        <h5 style="font-weight:normal;"><a class="pull-left colorBirneo" style="" href="../inbox"><i class="icon-white icon-arrow-left"></i> Retour à la boîte de réception</a><a class="pull-right colorBirneo" style="" href="<?php echo '../profile/'.$nomprenom[0]['username'] ?>">Aller sur le profil de <?php echo $prenom, ' ',$nom; ?> <i class="icon-white icon-arrow-right"></i></a></h5>
        <br />
      </div>

      
      <div class="span8 well" style="padding:0px;margin:0;width:100%;border: none;">
          <?php 

         $query_message = $bdd->query("SELECT * FROM messages WHERE discussion = :disc ORDER BY date ASC", array("disc"=> $_GET['id']));


          foreach($query_message as $row)
          {
            $expediteur = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $row['id_expediteur']));
            $destinataire = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $row['id_destinataire']));

            if($expediteur[0]['id'] == $_SESSION['userid'])
            {
              $id = $destinataire[0]['id'];
              $avatar = $destinataire[0]['avatar'];
              $nom = $destinataire[0]['name'];
              $prenom = $destinataire[0]['surname'];
            }else
            {
              $id = $expediteur[0]['id'];
              $avatar = $expediteur[0]['avatar'];
              $nom = $expediteur[0]['name'];
              $prenom = $expediteur[0]['surname'];
            }
            $date = date("d-m-Y", strtotime($row['date']));
            $heure = date("H:i", strtotime($row['date']));
            $row['message'] = place_smiley($row['message']);
            $row['message'] = urlToLink($row['message']);
          ?>
              
                <div class="media">
                  <a class="pull-left" href="#">
                  <img class="img-polaroid" style="max-width:50px;max-height:70px;" src="<?php echo base64_decode($expediteur[0]['avatar']); ?>" />
                  </a>
                  <div class="media-body">
                    <h4 class="media-heading"><?php echo $expediteur[0]['surname'], ' ', $expediteur[0]['name'],' <small class="pull-right">', str_replace('-' ,'/',$date),'</small>'; ?></h4>
                    <i class="icon-white icon-comment"></i> <?php echo $row['message']; ?>
                     
                    <!-- Nested media object -->
                    <div class="media">
                      <?php echo $heure; ?>
                    </div>
                </div>
                </div>
                <div class="divider"></div>
              
          <?php 
          }
          ?>
          <div>
            <h4>Répondre à 
            <?php 
              if($expediteur[0]['id'] == $_SESSION['userid'])
              {
                echo $destinataire[0]['surname'], ' ', $destinataire[0]['name'];
              }else
              {
                echo $expediteur[0]['surname'], ' ', $expediteur[0]['name'];
              }
            ?>
            </h4>
            <form id="formMessage">
              <input id="id_destinataire" name="id_destinataire" type="hidden" value="<?php echo $id; ?>" />
              <input id="discussion" name="discussion" type="hidden" value="<?php echo $_GET['id']; ?>" />
              <textarea id="message" name="message" type="text" style="width:98%"></textarea>
              <div class="pull-right"><a id="envoyerMessage" name="envoyerMessage" class="btn btn-primary"><i class="icon-white icon-arrow-up"></i> Envoyer</a> <small>ou pressez la toucher Entrée</small></div>
            </form>
          </div>
          </div>

    </div> <!-- /container -->

    <?php include("res/script_message.php"); ?>

  </body>
</html>
