<?php 
	function get_member_informations($id)
	{
	  global $bdd;
	  $bdd->bind("iduser",$id);
	  $dn = $bdd->query("SELECT * FROM users WHERE id = :iduser");
	  $dn[0]['avatar'] = base64_decode($dn[0]['avatar']);
	  return $dn;
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
		'<iframe src="//player.vimeo.com/video/$1?portrait=0&color=333" width="460" height="300" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
	); 

	

	return preg_replace($find,$replace,$text);
	}

	function marquage($chaine)
	{
		$chaine = preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i','<a href="../profile/$1" target="_blank">@$1</a>',$chaine);
		return $chaine;
	}

	function hashtag($chaine)
	{
		$chaine = preg_replace('#\#([a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ_-]+)#i','<a href="../pshashtag/$1" target="_blank">#$1</a>',$chaine);
		return $chaine;
	}

	function hashtag_comments($chaine)
	{
		$chaine = preg_replace('#\#([a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ_-]+)#i','<a href="../cshashtag/$1" target="_blank">#$1</a>',$chaine);
		return $chaine;
	}



	function get_comments($id)
	{
		global $bdd;
		$query_commentaire = $bdd->query("SELECT * FROM comments WHERE id_publication=:id",array("id"=>$id));
		foreach($query_commentaire as $row)
    	{
    		$dn = $bdd->query("SELECT * FROM users WHERE id=:rowidposter",array("rowidposter"=>$row['id_poster']));
			$avatar = base64_decode($dn[0]['avatar']);
			$username = $dn[0]['username'];
			$row['content'] = place_smiley($row['content']);
			$row['content'] = urlToLink($row['content']);
			$row['content'] = YoutubeRedirectDiv($row['content']);
			$row['content'] = showBBcodes($row['content']);
			$row['content'] = hashtag_comments($row['content']);
			
			$date = date("d-m-Y", strtotime($row['date']));
			$date = str_replace("-", "/", $date);
	        $heure = date("H:i", strtotime($row['date']));
			?>
				<div id="commentaire<?php echo $row['id']; ?>" class="span4 commentaire" style="padding:5px;margin:0px;">
					<p><img src="<?php echo $avatar; ?>" class="img-polaroid" style="max-width: 30px;"> <strong><a style="color:#444444;" href="../profile/<?php echo $dn[0]['username']; ?>"><?php echo $dn[0]['surname']," ",$dn[0]['name']; ?></a></strong><?php if($row['id_poster'] == $_SESSION['userid']){ ?><a onclick="removeComment(<?php echo $row['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $row['id']; ?>,<?php echo $row['id_poster']; ?>,2)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><u class="pull-right">Signaler</u></a><?php } ?></p>
					<p style="font-size: 12px;"><i class="icon-black icon-comment"></i> <?php echo marquage($row['content']); ?></p>
					<small class="pull-right" style="color: grey;"><?php echo $date; ?> à <?php echo $heure; ?></small>
				</div>
			<?php
    	}
	}

	function get_publication($id)
	{
		global $bdd;
    	$query_publication = $bdd->query("SELECT * FROM posts WHERE id_poster=:id ORDER BY id DESC",array("id"=>$id));
    	$dn = $bdd->query("SELECT * FROM users WHERE id=:id",array("id"=>$id));
		$dn[0]['avatar'] = base64_decode($dn[0]['avatar']);
    	foreach($query_publication as $row)
    	{
    		$req = $bdd->query("SELECT count(*) FROM vote WHERE id_publication = :rowid AND id_user = :userid",array("rowid"=>$row['id'],"userid"=>$_SESSION['userid']));
			$count = $req[0]['count(*)'];
			$date = date("d-m-Y", strtotime($row['date']));
			$date = str_replace("-", "/", $date);
	        $heure = date("H:i", strtotime($row['date']));
	        $row['content'] = place_smiley($row['content']);
			$row['content'] = urlToLink($row['content']);
			$row['content'] = YoutubeURLtoEmbed($row['content']);
			$row['content'] = YoutubeRedirectDiv($row['content']);
			$row['content'] = showBBcodes($row['content']);
			$row['content'] = hashtag($row['content']);
			
			if($row['type'] != 1)
			{

	    		?>
	    			<div id="publication<?php echo $row['id'] ?>" class="span5 well">
	    			<?php if($row['id_poster'] == $_SESSION['userid']){ ?><a onclick="removePost(<?php echo $row['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $row['id']; ?>,<?php echo $row['id_poster']; ?>,1)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><u class="pull-right">Signaler</u></a><?php } ?>
	    				<h2><img src="<?php echo $dn[0]['avatar']; ?>" class="img-polaroid" style="max-width: 50px;"> <?php echo $dn[0]['surname']," ",$dn[0]['name']; ?> <?php if($row['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $row['categorie']; ?></small><?php } ?></h2>
	    				<p>
	    					<?php 
		    				if(isset($row['photo']) && $row['photo'] != ''){
		    					echo "<blockquote>".marquage($row['content'])."</blockquote>";
		    					echo '<img style="max-height:600px;" class="img-polaroid" src="../photo/'.$row['photo'].'" />';
		    				}else
		    				{
		    					echo marquage($row['content']);
		    				}
		    				?>
	    				</p>
	    				<small style="color: grey;">Le <?php echo $date; ?> à <?php echo $heure; ?></small>
	    				<p><a id="btnlike<?php echo $row['id']; ?>" onclick="addlike(<?php echo $row['id']; ?>,<?php echo $row['vote']; ?>);" class="btn like birneo_unselectable"><i id="like<?php echo $row['id']; ?>" <?php if($count == 0){ ?>class="icon-white icon-heart-empty"><?php }else{ ?> class="icon-white icon-heart"> <?php } ?></i> (<span id="vote<?php echo $row['id']; ?>"><?php echo $row['vote']; ?></span>)</a> <a class="btn btn-danger birneo_unselectable"><i class="icon-white icon-comment"></i> Commentaires (<span id="commentCount<?php echo $row['id'] ?>"><?php echo $row['comments']; ?></span>)</a> <span id="commentLoader<?php echo $row['id']; ?>" style="display:none;"> <img  name="commentLoader" src="http://127.0.0.1/assets/img/loader.gif" width="16"> </span></p>
	    				<div id="error<?php echo $row['id']; ?>"></div>
	    				<div id="commentaireDiv<?php echo $row['id']; ?>">
	    					<?php 
	    						get_comments($row['id']); 
	    						
	    					?>
	    				</div>
	    				<form id="formComment<?php echo $row['id'] ?>" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
	    					<textarea id="addCommentaire<?php echo $row['id'] ?>" onKeyPress="addComment(<?php echo $row['id'] ?>);"  name="addCommentaire<?php echo $row['id'] ?>" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
	    					<input id="idForCommentaire" type="text" style="display:none;" value="<?php echo $row['id'] ?>"/> 
    					</form>
	    				<?php /* if($id == $_SESSION['userid']){ ?><a class="btn btn-danger pull-right"><i class="icon-white icon-remove"></i> Supprimer</a><?php } */ ?>
	    			</div>
	    		<?php
	    	}else
	    	{
	    		$sender = $bdd->query("SELECT * FROM users WHERE id=:rowdest",array("rowdest"=>$row['dest']));
	    		$receiver = $bdd->query("SELECT * FROM users WHERE id=:idposter",array("idposter"=>$row['id_poster']));
	    		$date = date("d-m-Y", strtotime($row['date'])); 
				$date = str_replace("-", "/", $date);
				
	    		?>
	    		<div id="publication<?php echo $row['id'] ?>" class="span5 well">
	    		<?php if($row['id_poster'] == $_SESSION['userid']){ ?><a onclick="removePost(<?php echo $row['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $row['id']; ?>,<?php echo $row['id_poster']; ?>,1)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><u class="pull-right">Signaler</u></a><?php } ?>
					<h3><img src="<?php echo base64_decode($sender[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <a style="color:#444444" href="<?php echo $sender[0]['username']; ?>"><?php echo $sender[0]['surname']," ",$sender[0]['name'], "</a> <i class='icon-black icon-arrow-right'></i> ", $receiver[0]['surname']," ",$receiver[0]['name']; ?> <?php if($row['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $row['categorie']; ?></small><?php } ?></h3>
					<p><?php echo marquage($row['content']); ?></p>
					<small style="color: grey;">Le <?php echo $date; ?> à <?php echo $heure; ?></small>
					<p><a id="btnlike<?php echo $row['id']; ?>" onclick="addlike(<?php echo $row['id']; ?>,<?php echo $row['vote']; ?>);" class="btn like birneo_unselectable"><i id="like<?php echo $row['id']; ?>" <?php if($count == 0){ ?>class="icon-white icon-heart-empty"><?php }else{ ?> class="icon-white icon-heart"> <?php } ?></i> (<span id="vote<?php echo $row['id']; ?>"><?php echo $row['vote']; ?></span>)</a> <a class="btn btn-danger birneo_unselectable"><i class="icon-white icon-comment"></i> Commentaires (<span id="commentCount<?php echo $row['id'] ?>"><?php echo $row['comments']; ?></span>)</a> <span id="commentLoader<?php echo $row['id']; ?>" style="display:none;"> <img  name="commentLoader" src="http://127.0.0.1/assets/img/loader.gif" width="16"> </span></p>
					<div id="error<?php echo $row['id'] ?>"></div>
					<div id="commentaireDiv<?php echo $row['id']; ?>">
	    					<?php 
	    						get_comments($row['id']); 
	    						
	    					?>
	    				</div>
	    				<form id="formComment<?php echo $row['id'] ?>" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
	    					<textarea id="addCommentaire<?php echo $row['id'] ?>" onKeyPress="addComment(<?php echo $row['id'] ?>);"  name="addCommentaire<?php echo $row['id'] ?>" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
	    					<input id="idForCommentaire" type="text" style="display:none;" value="<?php echo $row['id'] ?>"/> 
    					</form>
					<?php /* if($id == $_SESSION['userid']){ ?><a class="btn btn-danger pull-right"><i class="icon-white icon-remove"></i> Supprimer</a><?php } */ ?>
				</div>
	    			<?php
	    	}
    	}
    	$query_post_numbers = $bdd->query("SELECT count(*) FROM posts WHERE id_poster=:id ORDER BY id DESC",array("id"=>$id));
    	$post_numbers = $query_post_numbers[0]['count(*)'];
    	if($post_numbers == 0)
    	{
    		return 0;
    	}else
    	{
    		return 1;
    	}

	}

	function get_friends_exp($id)
	{
		global $bdd;
		$query_publication = $bdd->query("SELECT * FROM friends WHERE id_exp=:id AND active=:active",array("id"=>$id,"active"=>"1"));
    	//$dn = mysql_fetch_array($query_publication);
    	foreach($query_publication as $row)
    	{
    		$dn = $bdd->query("SELECT * FROM users WHERE id=:rowiddest",array("rowiddest"=>$row['id_dest']));
			$avatar = base64_decode($dn[0]['avatar']);
			$username = $dn[0]['username'];
			echo '<a href="'.$username.'"><img align="center" src="'.$avatar.'" class="well avatar" style="max-width: 50px;display:none;padding: 2px;margin:5px"></a>';
    	}
	}
	function get_friends_dest($id)
	{
		global $bdd;
		$query_publication = $bdd->query("SELECT * FROM friends WHERE id_dest=:id AND active=:active",array("id"=>$id,"active"=>"1"));
    	//$dn = mysql_fetch_array($query_publication);
    	foreach($query_publication as $row)
    	{
    		$dn = $bdd->query("SELECT * FROM users WHERE id=:rowidexp",array("rowidexp"=>$row['id_exp']));
			$avatar = base64_decode($dn[0]['avatar']);
			$username = $dn[0]['username'];
			echo '<a href="'.$username.'"><img align="center" src="'.$avatar.'" class="well avatar" style="max-width: 50px;display:none;padding: 2px;margin:5px"></a>';
    	}
	}
	 function friendRequestExist()
  {
    global $bdd;
    $username = $_GET['username'];
    $profil = $bdd->query("SELECT id FROM users WHERE username=:username",array("username"=>$username));
    $id_exp = intval($_SESSION['userid']);
    $id_dest = $profil[0]['id'];
    $query = $bdd->query("SELECT count(*) FROM friends WHERE (id_exp=:idexp1 AND id_dest=:iddest1) OR (id_exp=:iddest2 AND id_dest=:idexp2)",array(
    	"idexp1"=>$id_exp,
    	"iddest1"=>$id_dest,
    	"iddest2"=>$id_dest,
    	"idexp2"=>$id_exp
    ));
    return $query['count(*)'];
  }
  function friendRequestAccept()
  {
    global $bdd;
    $username = $_GET['username'];
    $profil = $bdd->query("SELECT id FROM users WHERE username=:username",array("username"=>$username));
    $id_exp = $_SESSION['userid'];
    $id_dest = $profil[0]['id'];
    $query = $bdd->query("SELECT count(*) FROM friends WHERE (id_exp='$id_exp' AND id_dest='$id_dest' AND active=1)
                        OR
                        (id_exp='$id_dest' AND id_dest='$id_exp' AND active=1)");
    return $query[0]['count(*)'];
  }
  function verificationExp()
  {
    global $bdd;
    $username = $_GET['username'];
    $profil = $bdd->query("SELECT id FROM users WHERE username=:username",array("username"=>$username));
    $id_exp = $_SESSION['userid'];
    $id_dest = $profil[0]['id'];
    $query = $bdd->query("SELECT count(*) FROM friends WHERE (id_exp=:idexp1 AND id_dest=:iddest1) OR (id_exp=:iddest2 AND id_dest=:idexp2)",array(
    	"idexp1"=>$id_exp,
    	"iddest1"=>$id_dest,
    	"iddest2"=>$id_dest,
    	"idexp2"=>$id_exp
    ));
    return $query[0]['count(*)'];
  }
  function isExpediteur()
  {
    global $bdd;
    $username = $_GET['username'];
    $req_profil = $bdd->query("SELECT id FROM users WHERE username=:username",array("username"=>$username));
    $profil = $req_profil->fetch();
    $id_exp = $_SESSION['userid'];
    $id_dest = $profil[0]['id'];
    $query = $bdd->query("SELECT COUNT(id_invitation) FROM friends WHERE (id_exp=:idexp AND id_dest=:iddest)",array("idexp"=>$id_exp,"iddest"=>$id_dest));
    return $query[0]['count(*)'];
  }

?>