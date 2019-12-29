<?php
	header('Content-type: text/html; charset=utf-8');
	include("res/config.php");
  include("res/secure.php");
	$my_info = $bdd->query("SELECT * FROM users WHERE id = :userid",array("userid"=>$_SESSION['userid']));

  if($my_info[0]['type'] == "anonyme")
  {
    if(!isset($_GET['filtre'])){
      header("Location: ../home?filtre=friend");
    }
  }

	if(!isset($_SESSION['userid']))
	{
		header("location: ../welcome");
	}
?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Birneo</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">

      <!-- Le styles -->
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
      <link href="../assets/css/bootBirneo.css" rel="stylesheet">
      

      <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
      <link href="../assets/css/bootstrap.icon-large.min.css" rel="stylesheet">
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
  		include("functions/home.func.php"); 
  	?>
  		<div class="container" style="margin-top: 30px;">
        	<div class="row">
        		<div class="span3">
        			<div class="well">
                <div class="commentaire" style="width: 104%;text-align:center;">
                  <a onclick="insertTag('[b]','[/b]','contenu');" class="btn"><i class="icon icon-bold"></i></a>
                  <a onclick="insertTag('[quote]','[/quote]','contenu');" class="btn"><i class="icon icon-comment"></i></a>
                  <a onclick="insertTag('[i]','[/i]','contenu');" class="btn"><i class="icon icon-italic"></i></a>
                  <a onclick="insertTag('[u]','[/u]','contenu');" class="btn" style="padding-top:2px;"><b>U</b></a>
                  <a onclick="insertTag('[color=CouleurEnAnglais]','[/color]','contenu');" class="btn"><i class="icon icon-tint"></i></a>
                  <a onclick="insertTag('[progress=50%]','[/progress]','contenu');" class="btn"><i class="icon icon-tasks"></i></a>
                  <a onclick="insertTag('[vimeo=id_de_la_video]','[/vimeo]','contenu');" class="btn" style=""><img width="16" height="16" src="http://www.birneo.com/assets/img/vimeo-icon.png" /></a>
                </div>
        				<form id="publier" align="left">
			                <textarea id="contenu" name="contenu" rows="4" style="width: 96%;resize: none;" placeholder="Qu'avez-vous à dire ?"></textarea><br />
			                Catégorie:
			                <select id="categorie" name="categorie" placeholder="Catégorie" style="width: 96%;">
			                  <option>Aucune</option>
                        <option>Actualité</option>
			                  <option>Humour</option>
			                  <option>People</option>
			                  <option>Musique</option>
			                  <option>Internet</option>
			                  <option>Jeux vidéo</option>
			                </select>
                      <div class="btn-group">
			                 <a id="publierSubmit" class="btn btn-primary" style="width: 60%;"><i class="icon-white icon-comment pull-left"></i> Dire</a>  
                       <a id="publierVider" class="btn" style="width: 60%;"><i class="icon-white icon-trash pull-left"></i> Vider</a>
			                </div>
                  </form>
        			</div>
				      <ul class="nav nav-list">
	              <li class="nav-header">Filtre</li>
                
                <?php
                    if(isset($_GET['filtre']))
                    {
                      if($_GET['filtre'] == "friend")
                      {
                        ?>
                          <li id="toutLeMonde" class="birneo_unselectable" style="cursor: pointer;"><a href="../home">Tout le monde</a></li>
                          <li id="Amis" class="active birneo_unselectable" style="cursor: pointer;"><a href="../home?filtre=friend">De vos amis</a></li>
                          <li id="Photo" class="birneo_unselectable" style="cursor: pointer;"><a href="../home?filtre=photo">Photo</a></li>
                        <?php
                      }elseif($_GET['filtre'] == "photo")
                      {
                        ?>
                          <li id="toutLeMonde" class="birneo_unselectable" style="cursor: pointer;"><a href="../home">Tout le monde</a></li>
                          <li id="Amis" class="birneo_unselectable" style="cursor: pointer;"><a href="../home?filtre=friend">De vos amis</a></li>
                          <li id="Photo" class="active birneo_unselectable" style="cursor: pointer;"><a href="../home?filtre=photo">Photo</a></li>
                        <?php
                      }else
                      {
                        ?>
                          <li id="toutLeMonde" class="active birneo_unselectable" style="cursor: pointer;"><a href="../home">Tout le monde</a></li>
                          <li id="Amis" class="birneo_unselectable" style="cursor: pointer;"><a href="../home?filtre=friend">De vos amis</a></li>
                          <li id="Photo" class="birneo_unselectable" style="cursor: pointer;"><a href="../home?filtre=photo">Photo</a></li>
                        <?php
                      }
                    }else
                    {
                      ?>
                        <li id="toutLeMonde" class="active birneo_unselectable" style="cursor: pointer;"><a href="../home">Tout le monde</a></li>
                        <li id="Amis" class="birneo_unselectable" style="cursor: pointer;"><a href="../home?filtre=friend">De vos amis</a></li>
                        <li id="Photo" class="birneo_unselectable" style="cursor: pointer;"><a href="../home?filtre=photo">Photo</a></li>
                      <?php
                    }
                  
                ?>
	              <!--<li><a href="#">Link</a></li>
	              <li><a href="#">Link</a></li>-->
            	</ul>
              <br />
           <div class="well">
            <h3 class="nav-header colorBirneo" ><i class="icon-envelope"></i> Messagerie <span id="counterDiscussion" class='badge badge-important' style="display:none;"></span> <button id="refreshListMessage" class="btn btn-primary"><i class="icon-white icon-refresh"></i></button></h3>
                <hr  style="margin:0;padding:0;margin-bottom:-22px;"/>
                <br />
              <div class="well">
                  <div style="padding:5px;" >
                    Lancer une discussion:<br /><input style="width:90%;" id="instant" name="instant" type="text" placeholder="@Nom d'utilisateur" /><button id="envoyerUser" name="envoyerUser" onclick="envoyerUser();" class="btn btn-block btn-primary"><i class="icon-white icon-arrow-up"></i> Lancer</button></a>
                  </div>
                  <div id="btnRetour" style="padding:5px;">
                  </div>
              </div>
              <div class="well" style="padding:0;padding-top:2px">
                <div id="EnvoyerMessagerie" style="padding:5px;">
                </div>
                <div id="loaderMessagerie" style="display:none;text-align:center;" align="center">
                  <center><img src="../assets/img/loader.gif" style="width:25px;"></center>
                </div>
                <div id="contenuMessagerie" style="max-height:400px;overflow:auto;padding:5px;">
                  <?php include("message/recupMessage.php"); ?>
                </div>
                
              </div>
            </div>

              
        		</div>
        		<?php if(isset($_GET['filtre']) && $_GET['filtre'] == "friend"){ ?>
            <div class="span8 well">
            	<div class="well">
	                <p><strong>Annonce de l'administration : <?php echo $annonce; ?></strong></p>
				</div>
        			<div class="page-header">
                  
		              <h1 id="titreHome">Publications de vos amis <!--<button class="btn" onclick="$(this).addClass('btn-danger');"><i class="icon-white icon-refresh"></i> Rafraîchissement automatique</button>--></h1>
		            </div>
		            <div id="toutLeMondePublicationHide" style="display:none;">
                    <div id="amisPublication">
                      <div class='span6 well'>
                        <?php
                          $user=$bdd->query("SELECT * FROM users WHERE id= :userid",array("userid"=>$_SESSION['userid']));
                        ?>
                          <h2><img src="<?php echo base64_decode($user[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <?php echo $user[0]['surname']," ",$user[0]['name']; ?> <small id="categorieEmplacement" style="font-size: 15px;"> </small></h2>
                        <div id='toutLeMondePublication'>
                        </div>
                        <span class="label label-important">Rafraichissez la page pour pouvoir commenter ou aimer cette publication</span>
                      </div>
                    </div>
                </div>
		            <div id="toutLeMondePublication">
        				  <?php get_publication_all(1); ?>
                  <div id="newPost">
                  </div>
        			  </div>
        		</div>
            
            <?php
            }elseif(isset($_GET['filtre']) && $_GET['filtre'] == "photo")
            {
              ?>
                <div class="span8 well">
	                <div class="well">
		                <p><strong>Annonce de l'administration : <?php echo $annonce; ?></strong></p>
					</div>
                    <div class="page-header">
                        <h1 id="titreHome">Flux des photos <!--<button class="btn" onclick="$(this).addClass('btn-danger');"><i class="icon-white icon-refresh"></i> Rafraîchissement automatique</button>--></h1>
                      </div>
                      <div id="toutLeMondePublicationHide" style="display:none;">
                          <div id="amisPublication">
                            <div class='span6 well'>
                              <?php
                                $user=$bdd->query("SELECT * FROM users WHERE id= :userid",array("userid"=>$_SESSION['userid']));
                              ?>
                                <h2><img src="<?php echo base64_decode($user[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <?php echo $user[0]['surname']," ",$user[0]['name']; ?> <small id="categorieEmplacement" style="font-size: 15px;"> </small></h2>
                              <div id='toutLeMondePublication'>
                              </div>
                              <span class="label label-important">Rafraichissez la page pour pouvoir commenter ou aimer cette publication</span>
                            </div>
                          </div>
                      </div>
                      <div id="toutLeMondePublication">
                        <?php get_publication_all(2); ?>
                        <div id="newPost">
                        </div>
                      </div>
                  </div>
              <?php
            }elseif(isset($_GET['filtre']) && $_GET['filtre'] != "friend" && $_GET['filtre'] != "photo"){
                ?>
                  <div class="span8 well">
                  	<div class="well">
	                	<p><strong>Annonce de l'administration : <?php echo $annonce; ?></strong></p>
					</div>
                    <div class="page-header">
                        <h1 id="titreHome">Publications de tout le monde <!--<button class="btn" onclick="$(this).addClass('btn-danger');"><i class="icon-white icon-refresh"></i> Rafraîchissement automatique</button>--></h1>
                      </div>
                      <div id="toutLeMondePublicationHide" style="display:none;">
                          <div id="amisPublication">
                            <div class='span6 well'>
                              <?php
                                $user=$bdd->query("SELECT * FROM users WHERE id= :userid",array("userid"=>$_SESSION['userid']));
                              ?>
                                <h2><img src="<?php echo base64_decode($user[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <?php echo $user[0]['surname']," ",$user[0]['name']; ?> <small id="categorieEmplacement" style="font-size: 15px;"> </small></h2>
                              <div id='toutLeMondePublication'>
                              </div>
                              <span class="label label-important">Rafraichissez la page pour pouvoir commenter ou aimer cette publication</span>
                            </div>
                          </div>
                      </div>
                      <div id="toutLeMondePublication">
                        <?php get_publication_all(0); ?>
                        <div id="newPost">
                        </div>
                      </div>
                  </div>
                <?php
              }else{
                ?>
                  <div class="span8 well">
                  		<div class="well">
			                <p><strong>Annonce de l'administration : <?php echo $annonce; ?></strong></p>
						</div>
                    <div class="page-header">
                        <h1 id="titreHome">Publications de tout le monde <!--<button class="btn" onclick="$(this).addClass('btn-danger');"><i class="icon-white icon-refresh"></i> Rafraîchissement automatique</button>--></h1>
                      </div>
                      <div id="toutLeMondePublicationHide" style="display:none;">
                          <div id="amisPublication">
                            <div class='span6 well'>
                              <?php
                                $user=$bdd->query("SELECT * FROM users WHERE id= :userid",array("userid"=>$_SESSION['userid']));
                              ?>
                                <h2><img src="<?php echo base64_decode($user[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <?php echo $user[0]['surname']," ",$user[0]['name']; ?> <small id="categorieEmplacement" style="font-size: 15px;"> </small></h2>
                              <div id='toutLeMondePublication'>
                              </div>
                              <span class="label label-important">Rafraichissez la page pour pouvoir commenter ou aimer cette publication</span>
                            </div>
                          </div>
                      </div>
                      <div id="toutLeMondePublication">
                        <?php get_publication_all(0); ?>
                        <!-- A MODIFIER CI DESSOUS -->
                        <div id="newPost">
                        </div>
                      </div>
                  </div>
                <?php
                } ?>
        	</div>
              <?php require("skull/footer.php"); ?>
        </div>
  	<?php require("res/script_home.php"); ?>
  </body>