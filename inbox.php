<?php
	header('Content-type: text/html; charset=utf-8');
	include("res/config.php");
  include("res/secure.php");
	$my_info = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));

	if(!isset($_SESSION['userid']))
	{
		header("location: http://".$_SERVER['SERVER_ADDR']."/welcome");
	}
  require "class/profile.php";
        $User = new User();
        $User->id=$_SESSION['userid'];
        $User->read();
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
            ":/",
            ":-/",
            ":'(",
            ":'-("
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
            "<img src='../assets/img/semitriste.gif' title=':/'  />",
            "<img src='../assets/img/triste.gif' title=\":'(\"  />",
            "<img src='../assets/img/triste.gif' title=\":'(\"  />"
          );
    $var = str_replace($smileys_code, $smileys, $var);
    return $var;
  }

?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Votre boîte de réception</title>
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
  		//include("functions/home.func.php"); 
  	?>
  		<div class="container" style="margin-top: 30px;">
        	<div class="row">
        		<div class="span3">
        			<div class="well">
                <div class="page-header" style="text-align:center;margin:5px;padding:0;">
                  <h3>Envoyer un message</h3>
                </div>
                <div id="errorMessage" class="alert alert-error" style="display:none;"></div>
        				  <form id="publier" align="left" method="POST">
			                <textarea id="contenu" name="contenu" rows="4" style="width: 96%;resize: none;" placeholder="Message à envoyer"></textarea><br />
			                Destinataire:
			                <input id="destinataire" autocomplete="off" name="destinataire" type="text" placeholder="@Nom d'utilisateur" <?php if(isset($_GET['envoyerA'])){ ?> value="<?php echo strip_tags($_GET['envoyerA']); ?>" <?php } ?>/>
			                <p><small>Vous devez appuyer sur "Envoyer" pour envoyer votre message</small></p>
                      <a  id="messageInboxSubmit" class="btn btn-primary" style="width: 40.6%;"><i class="icon-white icon-envelope pull-left"></i> Envoyer</a>  <a id="publierVider" class="btn" style="width: 40.6%;"><i class="icon-white icon-trash pull-left"></i> Vider</a>
			            </form>

        			</div>
				<ul class="nav nav-list">
	              <li class="nav-header">Filtre</li>
	              <li id="toutLeMonde" class="active birneo_unselectable" style="cursor: pointer;"><a href="../inbox">Boîte de réception</a></li>
                <li id="amis" class="birneo_unselectable" style="cursor: pointer;"><a href="../archives">Archives</a></li>
	              <!--<li><a href="#">Link</a></li>
	              <li><a href="#">Link</a></li>-->
            	</ul>
        		</div>
        		<div class="span8 well">
        			<div class="page-header">
		              <h1 id="titreMessage">Toutes les discussions</h1>
		            </div>
		            <div id="messageFeedback" class="alert alert-error span6" style="display:none;">
		                <h2>Nouvelle(s) publication(s)</h2>
		                <p>Vous venez de publier du contenu. <a href="" style="color: white;text-decoration:underline;">Rafraîchissez la page</a> pour pouvoir l'afficher.</a></p>
		            </div>
		           <?php 
                  
                  $query_discussion_count = $bdd->query("SELECT count(*) FROM discussion WHERE id_1 = :userid1 AND archive=:un1 OR id_2 =:userid2 AND archive=:un2 ORDER BY date DESC",array(
                      "userid1"=>$_SESSION['userid'],
                      "un1"=>"0",
                      "userid2"=>$_SESSION['userid'],
                      "un2"=>"0"
                    ));
                  $nombre_discussion = $query_discussion_count[0]['count(*)'];

                  $query_discussion = $bdd->query("SELECT * FROM discussion WHERE id_1 = :userid1 AND archive=:un1 OR id_2 =:userid2 AND archive=:un2 ORDER BY date DESC",array(
                      "userid1"=>$_SESSION['userid'],
                      "un1"=>"0",
                      "userid2"=>$_SESSION['userid'],
                      "un2"=>"0"
                    ));
                  if($nombre_discussion == 0)
                  {
                    ?>
                      <p class="lead">Vous n'avez aucun message</p>
                    <?php
                  }
                  
                  $query_discussion = $bdd->query("SELECT * FROM discussion WHERE id_1 = :userid1 AND archive=:zero1 OR id_2 =:userid2 AND archive = :zero2 ORDER BY date DESC",array("userid1"=>$_SESSION['userid'],"zero1"=>"0","userid2"=>$_SESSION['userid'],"zero2"=>"0"));
                  foreach($query_discussion as $data)
                  {

                      $bdd->bind("dataid1",$data['id_1']);
                      $bdd->bind("dataid2",$data['id_2']);
                      $bdd->bind("iddata1",$data['id_1']);
                      $bdd->bind("iddata2",$data['id_2']);
                      $query_message = $bdd->query("SELECT * FROM messages WHERE id_expediteur = :dataid1 AND id_destinataire = :dataid2 OR  id_destinataire = :iddata1 AND id_expediteur=:iddata2 ORDER BY id DESC LIMIT 0,1");

                      foreach($query_message as $row)
                      {
                        $expediteur = $bdd->query("SELECT * FROM users WHERE id=:rowidexpediteur", array("rowidexpediteur"=>$row['id_expediteur']));
                        $destinataire = $bdd->query("SELECT * FROM users WHERE id=:rowiddestinataire", array("rowiddestinataire"=>$row['id_destinataire']));
                        
                          if(!empty($destinataire) && !empty($expediteur) && $expediteur[0]['id'] == $_SESSION['userid'])
                          {
                            $avatar = $destinataire[0]['avatar'];
                            $nom = $destinataire[0]['name'];
                            $prenom = $destinataire[0]['surname'];
                          }elseif(!empty($destinataire) && !empty($expediteur))
                          {
                            $avatar = $expediteur[0]['avatar'];
                            $nom = $expediteur[0]['name'];
                            $prenom = $expediteur[0]['surname'];
                          }

                          $date = date("d-m-Y", strtotime($data['date']));
                          $heure = date("H:i", strtotime($data['date']));
                          if(!empty($destinataire) && !empty($expediteur))
                          {


                    ?>
                        <div 
                        id="discussion<?php echo $data['id']; ?>"
                        class="media"
                        style=
                        "
                        padding:5px;
                        -webkit-border-radius: 5px;
                        -moz-border-radius: 5px;
                        border-radius: 5px;
                        
                        "
                        onMouseOver="this.style.backgroundColor='#f0f0f0'"
                        onMouseOut="this.style.backgroundColor='#ffffff'"
                        >
                          <a class="pull-left" href="#">
                          <img class="img-polaroid" style="max-width:50px;" src="<?php echo base64_decode($avatar); ?>" />
                          </a>
                          <div class="media-body">
                            <h4 class="media-heading"><?php echo $prenom, ' ', $nom; ?>
                              <?php 
                                if($data['notifPour'] == $_SESSION['userid'])
                                {
                                  echo ' <span class="label">Reçu</span> ';
                                }else
                                {
                                  echo ' <span class="label">Envoyé</span> ';
                                }
                                if($data['readed'] == 0)
                                {
                                  echo ' <span class="label">Non lu</span> ';
                                }else
                                {
                                  echo ' <span class="label">Lu</span> ';
                                }
                              ?>
                              <a href='../discussion/<?php echo $data['id']; ?>' class="btn-small btn-danger pull-right" style="text-decoration:none;width: 54px;"><i class="icon-black icon-eye-open"></i> Lire</a></h4>
                            <div class="pull-left;" style="max-width:500px;">
                              <?php 

                              if($data['notifPour'] == $_SESSION['userid'])
                              {
                                echo '<i class="icon-white icon-arrow-down"></i> ';
                              }else
                              {
                                echo '<i class="icon-white icon-arrow-up"></i> ';
                              }

                              ?>
                               

                              <?php echo tronque($row['message'],60); ?></div><a style="text-decoration:none;cursor:pointer;float:right;" onclick="archiver(<?php echo $data['id']; ?>);" class="btn-small btn-primary pull-right" style="text-decoration:none;"><i class="icon-black icon-folder-open"></i> Archiver</a>
                             
                            <!-- Nested media object -->
                            <div class="media">
                              Dernier message le <?php echo str_replace('-' ,'/',$date),' à '.$heure; ?>
                            </div>
                          </div>
                        </div>
                      
                    <?php
                      }
                      }
                  }

                  
                ?>
        		</div>
        	</div>
        </div>
  	<?php 
    
    include("res/script_message.php"); 
    ?>
    <script>
       $("#popover").hover(function(){
          $("#popover").popover("show");
        }).on("mouseleave",function(){
          $("#popover").popover("hide");
        });
        
        
    </script>
  </body>