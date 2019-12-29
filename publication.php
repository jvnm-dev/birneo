<?php
  header('Content-type: text/html; charset=utf-8');
  include("res/config.php");
  $bdd->query("SET NAMES 'utf8'");
  include("res/secure.php"); 
  include("functions/profile.func.php");
  if(isset($_SESSION['userid']) && $_SESSION['userid'] != '')
  {
    $my_info = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
    $id = intval($_GET['id']);
    $publication = $bdd->query("SELECT * FROM posts WHERE id=:id",array("id"=>$id));
    $publication_req = $bdd->query("SELECT count(*) FROM posts WHERE id=:id",array("id"=>$id));
    $verif = $publication_req[0]['count(*)'];
    if($verif == 0)
    {
      header("Location: ../home");
    }
    $poster = $bdd->query("SELECT * FROM users WHERE id=:publicationidposter",array("publicationidposter"=>$publication[0]['id_poster']));
  }else 
  {
      header("Location: ../welcome");
  }


  
?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Publication de <?php echo $poster[0]['surname'], ' ', $poster[0]['name'];  ?></title>
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
          <h2 style="font-weight:normal;">Publication de <?php echo $poster[0]['surname'], ' ', $poster[0]['name'];  ?></h2>
        </div>
      <div class="publication">
        <div class="span12" id="amisPublication">
          <?php 
            $req = $bdd->query("SELECT count(*) FROM vote WHERE id_publication = :publicationid AND id_user = :userid",array("publicationid"=>$publication[0]['id'],"userid"=>$_SESSION['userid']));
            $count = $req[0]['count(*)'];
            $date = date("d-m-Y", strtotime($publication[0]['date']));
            $date = str_replace("-", "/", $date);
            $heure = date("H:i", strtotime($publication[0]['date']));
            $publication[0]['content'] = place_smiley($publication[0]['content']);
            $publication[0]['content'] = urlToLink($publication[0]['content']);
            $publication[0]['content'] = marquage($publication[0]['content']);
            $publication[0]['content'] = YoutubeURLtoEmbed($publication[0]['content']);
            $publication[0]['content'] = YoutubeRedirectDiv($publication[0]['content']);
            $publication[0]['content'] = showBBcodes($publication[0]['content']);
            $publication[0]['content'] = hashtag($publication[0]['content']);

            if($publication[0]['type'] != 1)
            {
               $dn = $bdd->query("SELECT * FROM users WHERE id=:publicationidposter",array("publicationidposter"=>$publication[0]['id_poster']));
               $suiveurReq = $bdd->query("SELECT count(*) FROM follow WHERE id_followed = :publicationidposter AND id_follower = :userid",array("publicationidposter"=>$publication[0]['id_poster'],"userid"=>$_SESSION['userid']));
               $suiveur = $suiveurReq[0]['count(*)'];
                ?>
                  <div id="<?php echo $publication[0]['id'] ?>" class="span5 well">
                  <?php if($publication[0]['id_poster'] == $_SESSION['userid']){ ?><a onclick="removePost(<?php echo $publication[0]['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $publication[0]['id']; ?>,<?php echo $publication[0]['id_poster']; ?>,1)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><u class="pull-right">Signaler</u></a><?php } ?>
                    <h2><img src="<?php echo base64_decode($dn[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <a style="color:#444444;" href="../profile/<?php echo $dn[0]['username']; ?>"><?php echo $dn[0]['surname']," ",$dn[0]['name']; ?></a> <?php if($publication[0]['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $publication[0]['categorie']; ?></small><?php } ?></h2>
                    <p>
                      <?php 
                      if(isset($publication[0]['photo']) && $publication[0]['photo'] != ''){
                        echo "<blockquote>".$publication[0]['content']."</blockquote>";
                        echo '<img style="max-height:600px;" class="img-polaroid" src="../photo/'.$publication[0]['photo'].'" />';
                      }else
                      {
                        echo $publication[0]['content'];
                      }
                      ?>
                    </p>
                    <small style="color: grey;">Le <?php echo $date; ?> à <?php echo $heure; ?></small>
                    <p><a id="btnlike<?php echo $publication[0]['id']; ?>" onclick="addlike(<?php echo $publication[0]['id']; ?>,<?php echo $publication[0]['vote']; ?>);" class="btn like birneo_unselectable"><i id="like<?php echo $publication[0]['id']; ?>" <?php if($count == 0){ ?>class="icon-white icon-heart-empty"><?php }else{ ?> class="icon-white icon-heart"> <?php } ?></i> (<span id="vote<?php echo $publication[0]['id']; ?>"><?php echo $publication[0]['vote']; ?></span>)</a> <a class="btn btn-danger birneo_unselectable"><i class="icon-white icon-comment"></i> Commentaires (<span id="commentCount<?php echo $publication[0]['id'] ?>"><?php echo $publication[0]['comments']; ?></span>)</a> <?php if($suiveur == 0){ }else{ } ?> <span id="commentLoader<?php echo $publication[0]['id']; ?>" style="display:none;"> <img  name="commentLoader" src="http://127.0.0.1/assets/img/loader.gif" width="16"> </span></p>
                    <div id="error<?php echo $publication[0]['id']; ?>"></div>
                    <div id="commentaireDiv<?php echo $publication[0]['id']; ?>">
                      <?php 
                        get_comments($publication[0]['id']); 
                        
                      ?>
                    </div>
                    <form id="formComment<?php echo $publication[0]['id'] ?>" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
                      <textarea id="addCommentaire<?php echo $publication[0]['id'] ?>" onKeyPress="if(event.keyCode == 13){ addComment(<?php echo $publication[0]['id'] ?>); }"  name="addCommentaire" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
                      <input id="idForCommentaire" type="text" style="display:none;" value="<?php echo $publication[0]['id'] ?>"/> 
                    </form>
                    <?php /* if($id == $_SESSION['userid']){ ?><a class="btn btn-danger pull-right"><i class="icon-white icon-remove"></i> Supprimer</a><?php } */ ?>
                  </div>
                <?php
              }else
              {
                $sender = $bdd->query("SELECT * FROM users WHERE id=:publicationdest",array("publicationdest"=>$publication[0]['dest']));
                $receiver = $bdd->query("SELECT * FROM users WHERE id=:publicationidposter",array("publicationidposter"=>$publication[0]['id_poster']));
                ?>
                <div id="<?php echo $publication[0]['id'] ?>" class="span6 well">
                <?php if($publication[0]['id_poster'] == $_SESSION['userid']){ ?><a onclick="removePost(<?php echo $publication[0]['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $publication[0]['id']; ?>,<?php echo $publication[0]['id_poster']; ?>,1)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><u class="pull-right">Signaler</u></a><?php } ?>
                <h3><img src="<?php echo base64_decode($sender[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <?php echo $sender[0]['surname']," ",$sender[0]['name'], " <i class='icon-black icon-arrow-right'></i> ", $receiver[0]['surname']," ",$receiver[0]['name']; ?> <?php if($publication[0]['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $publication[0]['categorie']; ?></small><?php } ?></h3>
                <p><?php echo $publication[0]['content'] ?></p>
                <small style="color: grey;">Le <?php echo $date; ?> à <?php echo $heure; ?></small>
                <p><a id="btnlike<?php echo $publication[0]['id']; ?>" onclick="addlike(<?php echo $publication[0]['id']; ?>,<?php echo $publication[0]['vote']; ?>);" class="btn like birneo_unselectable"><i id="like<?php echo $publication[0]['id']; ?>" <?php if($count == 0){ ?>class="icon-white icon-heart-empty"><?php }else{ ?> class="icon-white icon-heart"> <?php } ?></i> (<span id="vote<?php echo $publication[0]['id']; ?>"><?php echo $publication[0]['vote']; ?></span>)</a> <a class="btn btn-danger birneo_unselectable"><i class="icon-white icon-comment"></i> Commentaires (<span id="commentCount<?php echo $publication[0]['id'] ?>"><?php echo $publication[0]['comments']; ?></span>)</a> <span id="commentLoader<?php echo $publication[0]['id']; ?>" style="display:none;"> <img  name="commentLoader" src="http://127.0.0.1/assets/img/loader.gif" width="16"> </span></p>
                <div id="error<?php echo $publication[0]['id']; ?>"></div>
                <div id="commentaireDiv<?php echo $publication[0]['id']; ?>">
                  <?php 
                    get_comments($publication[0]['id']); 
                  ?>
                </div>
                <form id="formComment<?php echo $publication[0]['id'] ?>" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
                  <textarea id="addCommentaire<?php echo $publication[0]['id'] ?>" onKeyPress="if(event.keyCode == 13){ addComment(<?php echo $publication[0]['id'] ?>); }"  name="addCommentaire" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
                  <input id="idForCommentaire" type="text" style="display:none;" value="<?php echo $publication[0]['id'] ?>"/> 
                </form>
                <?php /* if($id == $_SESSION['userid']){ ?><a class="btn btn-danger pull-right"><i class="icon-white icon-remove"></i> Supprimer</a><?php } */ ?>
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

     <?php include("res/script_publication.php"); ?>
   </body>
</html>
