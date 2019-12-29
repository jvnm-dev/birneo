<?php
	header('Content-type: text/html; charset=utf-8');
	include("res/config.php");
  include("res/secure.php");
	$bdd->bind("userid",$_SESSION['userid']);
  $my_info = $bdd->query("SELECT * FROM users WHERE id = :userid");
  $bdd->query("SET NAMES 'utf8'");
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
      <title>Birneo - Débats</title>
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
      include("modal/lancerDebat.php");
  		//include("functions/home.func.php"); 
  	?>
  		<div class="container" style="margin-top: 30px;">
        	<div class="row">
        		<div class="span3">
        			<div class="well" style="text-align: center;">
                <a href="#lancerDebat" role="button" data-toggle="modal" class="btn btn-large btn-primary" style="width: 83%;">Lancer un débat</a>
        			</div>
        		</div>
        		<div class="span8 well">
        			<div class="page-header">
		              <h1 id="titreMessage">Tous les débats</h1>
		            </div>
		            <?php 
                  
                  $query_discussion = $bdd->query("SELECT * FROM debats ORDER BY id DESC");

                  foreach($query_discussion as $data)
                  {
                    $redacteur = $bdd->query("SELECT * FROM users WHERE id = :dataidposter",array("dataidposter"=>$data['id_poster']));

                    ?>
                        <div 
                        id="debat<?php echo $data['id']; ?>"
                        class="media"
                        style=
                        "
                        padding:5px;
                        -webkit-border-radius: 5px;
                        -moz-border-radius: 5px;
                        border-radius: 5px;
                        border-bottom: 1px solid #f0f0f0;
                        
                        "
                        onMouseOver="this.style.backgroundColor='#f0f0f0'"
                        onMouseOut="this.style.backgroundColor='#ffffff'"
                        >
                          <div class="media-body">
                            <h4 class="media-heading"><?php echo $data['titre']; ?>
                              <a href='../debat/<?php echo $data['id']; ?>' class="btn-small btn-danger pull-right" style="text-decoration:none;width: 54px;"><i class="icon-black icon-eye-open"></i> Lire</a></h4>
                            <div class="pull-left;" style="max-width:500px;">
                              <?php echo tronque($data['contenu'],60); ?></div>
                            <!-- Nested media object -->
                            <div class="media">
                            </div>
                          </div>
                        </div>
                      
                    <?php
                   
                  }

                  
                ?>
        		</div>
        	</div>
          <?php require("skull/footer.php"); ?> 
        </div>

  	<?php 
    
    include("res/script_debat.php"); 
    ?>
    <script>
       $("#popover").hover(function(){
          $("#popover").popover("show");
        }).on("mouseleave",function(){
          $("#popover").popover("hide");
        });
        
        
    </script>
  </body>