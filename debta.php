<?php
  header('Content-type: text/html; charset=utf-8');
  include("res/config.php");
  include("res/secure.php"); 
  $bdd->query("SET NAMES 'utf8'");
  if(isset($_SESSION['userid']) && $_SESSION['userid'] != '')
  {
    $bdd->bind("userid",$_SESSION['userid']);
    $my_info = $bdd->query("SELECT * FROM users WHERE id = :userid");
    $id = intval($_GET['id']);
    $publication_count = $bdd->query("SELECT count(*) FROM debats WHERE id=:id",array("id"=>$id));
    $verif = $publication_count[0]['count(*)'];

    $publication = $bdd->query("SELECT * FROM debats WHERE id=:id",array("id"=>$id));
    if($verif == 0)
    {
      header("Location:../home");
    }
    $poster = $bdd->query("SELECT * FROM users WHERE id=:publicationidposter",array("publicationidposter"=>$publication[0]['id_poster']));
  }else 
  {
    header("Location: ../welcome");
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

  function get_comments($id)
  {
    global $bdd;
    $query_commentaire = $bdd->query("SELECT * FROM comments_debat WHERE id_publication=:id",array("id"=>$id));
    foreach($query_commentaire as $row)
      {
        $dn = $bdd->query("SELECT * FROM users WHERE id=:rowidposter",array("rowidposter"=>$row['id_poster']));
        $avatar = base64_decode($dn[0]['avatar']);
        $username = $dn[0]['username'];
        $row['content'] = place_smiley($row['content']);
        $row['content'] = urlToLink($row['content']);
      ?>
        <div id="commentaire<?php echo $row['id']; ?>" class="span4 commentaire" style="padding:5px;margin:0px;">
          <p><img src="<?php echo $avatar; ?>" class="img-polaroid" style="max-width: 30px;"> <strong><?php echo $dn[0]['surname']," ",$dn[0]['name']; ?></strong><?php if($row['id_poster'] == $_SESSION['userid']){ ?><a onclick="removeComment(<?php echo $row['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $row['id']; ?>,<?php echo $row['id_poster']; ?>,2)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-warning-sign pull-right"></i></a><?php } ?></p>
          <p style="font-size: 12px;"><i class="icon-black icon-comment"></i> <?php echo $row['content']; ?></p>
        </div>
      <?php
      }
  }
  
?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Débat: "<?php echo $publication[0]['titre']; ?>"</title>
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
      .container-narpublication {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narpublication > hr {
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

      <div class="container-narpublication well">
        <div class="page-header">
          <h2 style="font-weight:normal;">Débat sur "<?php echo $publication[0]['titre']; ?>"</h2>
        </div>
      <div class="publication">
        <div class="span12" id="amisPublication">
          <?php 

          $publication[0]['contenu'] = place_smiley($publication[0]['contenu']);
          $publication[0]['contenu'] = urlToLink($publication[0]['contenu']);

          ?>
           <blockquote style="max-width:50%"><?php echo $publication[0]['contenu']; ?></blockquote> 
           
            
            <?php 
              $verif_req = $bdd->query("SELECT count(*) FROM vote_debat WHERE id_debat = :publicationid AND id_user = :userid",array("publicationid"=>$publication[0]['id'],"userid"=>$_SESSION['userid']));
              $verif = $verif_req[0]['count(*)'];
              if($verif == 1)
              {
                ?>
                <h4>Vous avez déjà donné votre avis</h4>
                <a class="btn btn-primary" ><i class="icon-white icon-star-empty"></i></i> Pour (<?php echo $publication[0]['pour']; ?>)</a> <a class="btn"><i class="icon-white icon-star-empty"></i> Neutre (<?php echo $publication[0]['neutre']; ?>)</a> <a class="btn btn-danger"><i class="icon-white icon-star-empty"></i> Contre (<?php echo $publication[0]['contre']; ?>)</a>
                <?php
              }else
              {
                ?>
                  <h4>Donnez votre avis</h4>
                  <a class="btn btn-primary" onclick="choix(<?php echo $publication[0]['id']; ?>,1);"><i class="icon-white icon-star-empty"></i></i> Pour (<?php echo $publication[0]['pour']; ?>)</a> <a class="btn" onclick="choix(<?php echo $publication[0]['id']; ?>,2);"><i class="icon-white icon-star-empty"></i> Neutre (<?php echo $publication[0]['neutre']; ?>)</a> <a class="btn btn-danger" onclick="choix(<?php echo $publication[0]['id']; ?>,3);"><i class="icon-white icon-star-empty"></i> Contre (<?php echo $publication[0]['contre']; ?>)</a>
                <?php
              }
            ?>
            <br /><br />
           <div style="max-width: 550px">
           <?php get_comments($publication[0]['id']); ?>
           <div id="commentaireDiv">
            
           </div>
           <form id="formComment" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
            <textarea id="addCommentaire" onKeyPress="addComment(<?php echo $publication[0]['id']; ?>);"  name="addCommentaire" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
            <input id="idForCommentaire" type="text" style="display:none;" value=""/> 
           </form>
           </div>
        </div>

      <?php
        include("skull/footer.php");
      ?>

      </div> <!-- /container -->

     <?php include("res/script_debat.php"); ?>
   </body>
</html>
