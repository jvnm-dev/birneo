<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');
	$bdd->query("SET NAMES 'utf8'");
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
			"<3",
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
		'<iframe src="//player.vimeo.com/video/$1?portrait=0&color=333" width="560" height="300" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
	);

	

	return preg_replace($find,$replace,$text);
	}

	function marquage($chaine)
	{
		$chaine = preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i','<a href="../profile/$1" target="_blank">@$1</a>',$chaine);
		return $chaine;
	}

	function hashtag_comments($chaine)
	{
		$chaine = preg_replace('#\#([a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ_-]+)#i','<a href="../cshashtag/$1" target="_blank">#$1</a>',$chaine);
		return $chaine;
	}

	$contenu = DestroyHTML($_POST['content']);
	$id_publication = DestroyHTML(intval($_POST['id_publication']));
	
	$publication = $bdd->query("SELECT * FROM posts WHERE id=:id_publication",array("id_publication"=>$id_publication));

	$req = $bdd->query("SELECT count(*) FROM comments WHERE id_publication = :id_publication",array("id_publication"=>$id_publication));
	$count = $req[0]['count(*)'];
	$t = array();
	$t["nombre"] = $count;	
	date_default_timezone_set('Europe/Brussels');

	$date = date('Y-m-d H:i:s', time() - 7200);
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	if($_POST['content'] != '')
	{
		$id = $_SESSION['userid'];
		$link = "publication/".$id_publication;
		$bdd->query("UPDATE posts SET comments = comments+:un WHERE id=:id_publication",array("un"=>"1","id_publication"=>$id_publication));
		$bdd->query("INSERT INTO comments(id_poster,content,id_publication,date) VALUES (:id,:contenu,:id_publication,:datee)",array(
				"id"=>$id,
				"contenu"=>$contenu,
				"id_publication"=>$id_publication,
				"datee"=>$date
			));
		
		if($publication[0]['id_poster'] != $_SESSION['userid']){
			$notifieur = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
			$contenu = $notifieur[0]['surname']." ".$notifieur[0]['name']." a commenté votre publication";
			$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id_proprio,:id_exp,:readed,:link)",array(
					"contenu"=>$contenu,
					"id_proprio"=>$publication[0]['id_poster'],
					"id_exp"=>$_SESSION['userid'],
					"readed"=>"0",
					"link"=>$link
				));		
			$verifFollowReq = $bdd->query("SELECT count(*) FROM follow WHERE id_followed = :id_followed AND id_follower = :id_follower AND id_post = :id_post",array(
					"id_followed"=>$publication[0]['id_poster'],
					"id_follower"=>$_SESSION['userid'],
					"id_post"=>$publication[0]['id'],
				));
			$verifFollow = $verifFollowReq[0]['count(*)'];
			if($verifFollow == 0){
				$bdd->query("INSERT INTO follow(id_followed,id_follower,type,id_post) VALUES(:id_followed,:id_follower,:type,:id_post)",array(
						"id_followed"=>$publication[0]['id_poster'],
						"id_follower"=>$_SESSION['userid'],
						"type"=>"1",
						"id_post"=>$publication[0]['id']
					));
			}
		}
		$notifieur = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
		$content = $notifieur[0]['surname']." ".$notifieur[0]['name']." a commenté votre publication";
		$query_follow = $bdd->query("SELECT * FROM follow WHERE id_followed=:id_followed AND id_post = :id_post AND type = :type",array(
			"id_followed"=>$publication[0]['id_poster'],
			"id_post"=>$id_publication,
			"type"=>"1"
			));
    	foreach($query_follow as $row)
    	{
    		if($row['id_follower'] != $_SESSION['userid'])
    		{
    			$bdd->query("INSERT INTO notification(contenu,id_proprio,id_exp,readed,link) VALUES(:contenu,:id_proprio,:id_exp,:readed,:link)",array(
					"contenu"=>$content,
					"id_proprio"=>$row['id_follower'],
					"id_exp"=>$_SESSION['userid'],
					"readed"=>"0",
					"link"=>$link
				));
    		}
		}

		$me = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
		$t["erreur"] = "no";
		$contenu = place_smiley($contenu);
		$t["comment"] =
		"
	      <div class='span4 commentaire' style='padding:5px;margin:0px;'>
	        <p><img src='".base64_decode($me[0]['avatar'])."' class='img-polaroid' style='max-width: 30px;'> <strong>".$me[0]['surname']." ".$me[0]['name']."</strong></p>
	        <p style='font-size: 12px;'><i class='icon-black icon-comment'></i> ".DestroyHTML($_POST['content'])."</p>
	      </div>
	    ";
	}

	echo json_encode($t);
	
?>