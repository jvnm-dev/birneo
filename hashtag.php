<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
?>
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
	
	if(isset($_GET['hashtag']))
	{
		$hashtag_get = DestroyHTML($_GET['hashtag']);
	} else {
		$hashtag_get = null;
	}

	if(isset($_GET['zone']))
	{
		$zone_get = DestroyHTML($_GET['zone']);
	} else {
		$zone_get = null;
	}


	function CheckHashtag($var){
		global $hashtag_get;
		
		if (preg_match('/(?:^|\s+)(#'.$hashtag_get.'+)/', $var)) {
			return true;
		} else {
			return false;
		}
	}

	function marquage($chaine)
	{
		$chaine = preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i','<a href="../profile/$1" target="_blank">@$1</a>',$chaine);
		return $chaine;
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
	       	" <br />"

		);
		$var = str_replace($smileys_code, $smileys, $var);
		return $var;
	}

	function showBBcodes($text) {
	$find = array(
		'~\[b\](.*?)\[/b\]~s',
		'~\[i\](.*?)\[/i\]~s',
		'~\[u\](.*?)\[/u\]~s',
		'~\[quote\](.*?)\[/quote\]~s',
		'~\[color=(.*?)\](.*?)\[/color\]~s',
		'~\[progress=(.*?)\](.*?)\[/progress\]~s',
		'~\[vimeo=(.*?)\]\[/vimeo\]~s'
	);

	$replace = array(
		'<b>$1</b>',
		'<i>$1</i>',
		'<span style="text-decoration:underline;">$1</span>',
		'<blockquote><p>$1</p></blockquote>',
		'<span style="color:$1;">$2</span>',
		'<div class="progress progress-striped active"><div class="bar" style="width: $1;"></div></div><p>$2</p>',
		'<iframe src="//player.vimeo.com/video/$1?portrait=0&color=333" width="500" height="300" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
	);

	return preg_replace($find,$replace,$text);
	}

	function urlToLink($var)
	{
		$var = preg_replace('`((?:https?|ftp)://\S+?)(?=[[:punct:]]?(?:\s|\Z)|\Z)`', '<a target="_blank" href="$1$2">$1$2</a>', $var);
		return $var;
	}

	function YoutubeURLtoEmbed($var) {
		$search = '#<a(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*<\/a>#x';
		$replace = '<iframe width="450" height="300" src="http://www.youtube.com/embed/$2" frameborder="0" allowfullscreen></iframe>';
			$text = preg_replace($search, $replace, $var, '1');

			return $text;
	}

	function YoutubeRedirectDiv($var) {
		$search = '#<a(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*<\/a>#x';
		$replace = '<div class="alert alert-info"><strong>Vidéo masqué !</strong> <a target="_blank" href="http://www.youtube.com/watch?v=$2">Voir cette vidéo (YouTube)</a></div>';
			$text = preg_replace($search, $replace, $var);

			return $text;
	}

	function hashtag($chaine)
	{
		$chaine = preg_replace('#\#([a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ_-]+)#i','<a href="../shashtag/$1" target="_blank">#$1</a>',$chaine);
		return $chaine;
	}
?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Birneo - Hashtag</title>
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
  	?>
  		<div class="container" style="margin-top: 30px;">
        	<div class="row">
        		<div class="span11 well">
        			<div class="page-header">
		            	<h1 id="titreMessage">#<?php echo $hashtag_get; ?></h1>
		            </div>
		            <?php 

		          if(!$zone_get || $zone_get == null) {
		          	$query_publication = $bdd->query("SELECT * FROM posts ORDER BY id DESC");
		          	$nombre = 0;
		          		foreach($query_publication as $row)
		          			{
		          				$date = date("d-m-Y", strtotime($row['date']));
			    				$date = str_replace("-", "/", $date);
			         			$heure = date("H:i", strtotime($row['date']));
			    				$dn = $bdd->query("SELECT * FROM users WHERE id=:id",array("id"=>$row['id_poster']));
			    				$row['content'] = place_smiley($row['content']);
								$row['content'] = urlToLink($row['content']);
								$row['content'] = YoutubeURLtoEmbed($row['content']);
								$row['content'] = YoutubeRedirectDiv($row['content']);
								$row['content'] = showBBcodes($row['content']);
								//$row['content'] = hashtag($row['content']);
			    				if(CheckHashtag($row['content'])) {
			    					$nombre++;
			    				?>
			    					<div id="publication<?php echo $row['id'] ?>" class="span8 well"
			    						onMouseOver="this.style.backgroundColor='#f0f0f0'"
                        				onMouseOut="this.style.backgroundColor='#ffffff'"
                        				onclick="location.href='../publication/<?php echo $row['id']; ?>'"
			    						style="cursor:pointer;margin-right:10px;"
			    						>
									<h2><?php echo $dn[0]['surname']," ",$dn[0]['name']; ?> <?php if($row['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $row['categorie']; ?></small><?php } ?></h2>
									<p>
										<?php 
										if(isset($row['photo']) && $row['photo'] != ''){
											echo "<blockquote>".marquage($row['content'])."</blockquote>";
											echo '<img style="max-height:600px;" class="img-polaroid" src="../photo/'.$row['photo'].'" />';
										} else {
											echo marquage($row['content']);
										}
										?>
									</p>
									<small style="color: grey;">Le <?php echo $date; ?> : <?php echo $heure; ?></small>
									</div>
								<?php
							}
						}

					} elseif($zone_get == 'comments') {
						$nombre = 0;
						$query_commentaire = $bdd->query("SELECT * FROM comments ORDER BY id DESC");
						foreach($query_commentaire as $row)
							{
								$dn = $bdd->query("SELECT * FROM users WHERE id= :id_poster",array("id_poster"=>$row['id_poster']));
								$row['content'] = place_smiley($row['content']);
								$row['content'] = urlToLink($row['content']);
								$row['content'] = marquage($row['content']);
								$row['content'] = YoutubeRedirectDiv($row['content']);
								$row['content'] = showBBcodes($row['content']);
								$date = date("d-m-Y", strtotime($row['date']));
								$date = str_replace("-", "/", $date);
								$heure = date("H:i", strtotime($row['date']));
								if(CheckHashtag($row['content'])) {
			    					$nombre++;
			    				?>
			    					<div id="publication<?php echo $row['id_publication'] ?>" class="span8 well"
			    						onMouseOver="this.style.backgroundColor='#f0f0f0'"
                        				onMouseOut="this.style.backgroundColor='#ffffff'"
                        				onclick="location.href='../publication/<?php echo $row['id_publication']; ?>'"
			    						style="cursor:pointer;margin-right:10px;"
			    						>
									<h2><?php echo $dn[0]['surname']," ",$dn[0]['name']; ?></h2>
									<p><?php echo $row['content']; ?></p>
									<small style="color: grey;">Le <?php echo $date; ?> : <?php echo $heure; ?></small>
									</div>
								<?php
							}
						}
					} else {
						$nombre = 1;
						?>
						<div class="alert alert-error">Utilisation d'une mauvaise URL</div>
						<?php
					}
					if($nombre == 0)
					{
						?>
						<div class="alert alert-error">Pas de résultat</div>
						<?php } ?>
					</div>
				</div>
			<?php require("skull/footer.php"); ?>
		</div>
	<?php include("res/script_home.php"); ?>
</body>