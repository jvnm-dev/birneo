<?php
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
		$replace = '<br/><iframe width="500" height="300" src="http://www.youtube.com/embed/$2" frameborder="0" allowfullscreen></iframe>';
 		$text = preg_replace($search, $replace, $var, '1');

 		return $text;
	}

	function YoutubeRedirectDiv($var) {
		$search = '#<a(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*<\/a>#x';
		$replace = '<br/><div class="alert alert-info"><strong>Vidéo masqué !</strong> <a target="_blank" href="http://www.youtube.com/watch?v=$2">Voir cette vidéo (YouTube)</a></div>';
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
		'<iframe src="//player.vimeo.com/video/$1?portrait=0&color=333" width="560" height="300" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
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

function get_publication_all($filtre)
{
	global $bdd;
	if($filtre == 0)
	{
		$query_publication = $bdd->query("SELECT * FROM posts WHERE type = :type ORDER BY id DESC LIMIT 0,10",array("type"=>"0"));
		$count = $bdd->query("SELECT count(*) FROM posts");
		$nbr = $count[0]['count(*)'];

		$my_info = $bdd->query("SELECT * FROM users WHERE id = :userid",array("userid"=>$_SESSION['userid']));

		foreach($query_publication as $row)
		{
			$req = $bdd->query("SELECT count(*) FROM vote WHERE id_publication = :rowid AND id_user = :userid",array("rowid"=>$row['id'],"userid"=>$_SESSION['userid']));
			$count = $req[0]['count(*)'];
			$date = date("d-m-Y", strtotime($row['date']));
			$date = str_replace("-", "/", $date);
	        $heure = date("H:i", strtotime($row['date']));
			if($row['type'] != 1)
			{
				$dn = $bdd->query("SELECT * FROM users WHERE id = :rowidposter",array("rowidposter"=>$row['id_poster']));
				$dn[0]['avatar'] = base64_decode($dn[0]['avatar']);

				$row['content'] = place_smiley($row['content']);
				$row['content'] = urlToLink($row['content']);
				$row['content'] = marquage($row['content']);
				$row['content'] = YoutubeURLtoEmbed($row['content']);
				$row['content'] = YoutubeRedirectDiv($row['content']);
				$row['content'] = showBBcodes($row['content']);
				$row['content'] = hashtag($row['content']);
				

	    		?>
	    			<div id="publication<?php echo $row['id'] ?>" class="span6 well " style="overflow:hidden">
	    			<?php if($row['id_poster'] == $_SESSION['userid'] || $my_info[0]['admin'] == 1){ ?><a onclick="removePost(<?php echo $row['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $row['id']; ?>,<?php echo $row['id_poster']; ?>,1)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><u class="pull-right">Signaler</u></a><?php } ?>
	    				<h2><img src="<?php echo $dn[0]['avatar']; ?>" class="img-polaroid" style="max-width: 50px;"> <a style="color: #444444;" href="../profile/<?php echo $dn[0]['username'] ?>"><?php echo $dn[0]['surname']," ",$dn[0]['name']; ?></a> <?php if($row['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $row['categorie']; ?></small><?php } ?></h2>
	    				<p>
	    					<?php 
		    				if(isset($row['photo']) && $row['photo'] != ''){
		    					echo "<blockquote>".$row['content']."</blockquote>";
		    					echo '<img style="max-height:600px;" class="img-polaroid" src="../photo/'.$row['photo'].'" />';
		    				}else
		    				{
		    					echo $row['content'];
		    				}
		    				?>
	    				</p>
	    				<small style="color: grey;">Le <?php echo $date; ?> à <?php echo $heure; ?></small>
	    				<p><a id="btnlike<?php echo $row['id']; ?>" onclick="addlike(<?php echo $row['id']; ?>,<?php echo $row['vote']; ?>);" class="btn like birneo_unselectable"><i id="like<?php echo $row['id']; ?>" <?php if($count == 0){ ?>class="icon-white icon-heart-empty"><?php }else{ ?> class="icon-white icon-heart"> <?php } ?></i> (<span id="vote<?php echo $row['id']; ?>"><?php echo $row['vote']; ?></span>)</a> <a class="btn btn-danger birneo_unselectable"><i class="icon-white icon-comment"></i> Commentaires (<span id="commentCount<?php echo $row['id'] ?>"><?php echo $row['comments']; ?></span>)</a> <span id="commentLoader<?php echo $row['id']; ?>" style="display:none;"> <img  name="commentLoader" src="http://birneo.com/assets/img/loader.gif" width="16"> </span></p>
	    				<div id="error<?php echo $row['id']; ?>"></div>
	    				<div id="commentaireDiv<?php echo $row['id']; ?>">
	    					<?php 
								get_comments($row['id']);
								$id_du_commentaire = "formComment".$row['id'];
							?>
	    				</div>
	    				
	    				<form id="formComment<?php echo $row['id'] ?>" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
	    					<textarea id="addCommentaire<?php echo $row['id'] ?>" 
	    						onKeyPress=
	    						"
	    							addComment(<?php echo $row['id'] ?>); 
	    						"

	    						name="addCommentaire<?php echo $row['id'] ?>" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
	    					<input id="idForCommentaire" type="text" style="display:none;" value="<?php echo $row['id'] ?>"/> 
						</form>
	    				<?php /* if($id == $_SESSION['userid']){ ?><a class="btn btn-danger pull-right"><i class="icon-white icon-remove"></i> Supprimer</a><?php } */ ?>
	    			</div>
	    		<?php
	    	}else
	    	{
	    		$sender = $bdd->query("SELECT * FROM users WHERE id = :rowdest",array("rowdest"=>$row['dest']));
	    		$receiver = $bdd->query("SELECT * FROM users WHERE id = :rowidposter",array("rowidposter"=>$row['id_poster']));

				$row['content'] = place_smiley($row['content']);
				$row['content'] = urlToLink($row['content']);
				$row['content'] = marquage($row['content']);
				$row['content'] = YoutubeURLtoEmbed($row['content']);
				$row['content'] = YoutubeRedirectDiv($row['content']);
				$row['content'] = showBBcodes($row['content']);
				$row['content'] = hashtag($row['content']);
						?>
	    		<div id="publication<?php echo $row['id'] ?>" class="span6 well" style="overflow:hidden">
		    	<?php if($row['id_poster'] == $_SESSION['userid'] || $my_info[0]['admin'] == 1){ ?><a onclick="removePost(<?php echo $row['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $row['id']; ?>,<?php echo $row['id_poster']; ?>,1)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><u class="pull-right">Signaler</u></a><?php } ?>
					<h3><img src="<?php echo base64_decode($sender[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <a style="color: #444444;" href="../profile/<?php echo $sender[0]['username'] ?>"><?php echo $sender[0]['surname']," ",$sender[0]['name'], "</a> <i class='icon-black icon-arrow-right'></i> <a style='color: #444444;' href='../profile/".$receiver[0]['username']."'>", $receiver[0]['surname']," ",$receiver[0]['name'], "</a>"; ?> <?php if($row['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $row['categorie']; ?></small><?php } ?></h3>
					<p><?php echo $row['content'] ?></p>
					<small style="color: grey;">Le <?php echo $date; ?> à <?php echo $heure; ?></small>
					<p><a id="btnlike<?php echo $row['id']; ?>" onclick="addlike(<?php echo $row['id']; ?>,<?php echo $row['vote']; ?>);" class="btn like birneo_unselectable"><i id="like<?php echo $row['id']; ?>" <?php if($count == 0){ ?>class="icon-white icon-heart-empty"><?php }else{ ?> class="icon-white icon-heart"> <?php } ?></i> (<span id="vote<?php echo $row['id']; ?>"><?php echo $row['vote']; ?></span>)</a> <a class="btn btn-danger birneo_unselectable"><i class="icon-white icon-comment"></i> Commentaires (<span id="commentCount<?php echo $row['id'] ?>"><?php echo $row['comments']; ?></span>)</a> <span id="commentLoader<?php echo $row['id']; ?>" style="display:none;"> <img  name="commentLoader" src="http://birneo.com/assets/img/loader.gif" width="16"> </span></p>
					<div id="error<?php echo $row['id']; ?>"></div>
					<div id="commentaireDiv<?php echo $row['id']; ?>">
						<?php 
							get_comments($row['id']);
						?>
					</div>
					<form id="formComment<?php echo $row['id'] ?>" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
						<textarea id="addCommentaire<?php echo $row['id'] ?>" onKeyUp="if(event.keyCode == 13){ addComment(<?php echo $row['id'] ?>); }"  name="addCommentaire" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
						<input id="idForCommentaire" type="text" style="display:none;" value="<?php echo $row['id'] ?>"/> 
					</form>
					<?php /* if($id == $_SESSION['userid']){ ?><a class="btn btn-danger pull-right"><i class="icon-white icon-remove"></i> Supprimer</a><?php } */ ?>
				</div>
	    			<?php
	    	}
		}
	}elseif($filtre == 1){
		
		
			$query_publication = $bdd->query("SELECT * FROM posts WHERE type=:type1 OR type=:type2  ORDER BY date DESC",array("type1"=>"0","type2"=>"0"));
			$count = $bdd->query("SELECT count(*) FROM posts");
			$nbr = $count[0]['count(*)'];
			foreach($query_publication as $row)
			{
				$query_friends = $bdd->query("SELECT count(*) FROM friends WHERE id_exp = :userid1 AND id_dest = :rowidposter1 AND active = :active1 OR id_dest = :userid2 AND id_exp = :rowidposter2 AND active = :active2",array(
					"userid1"=>$_SESSION['userid'],
					"rowidposter1"=>$row['id_poster'],
					"active1"=>"1",
					"userid2"=>$_SESSION['userid'],
					"rowidposter2"=>$row['id_poster'],
					"active2"=>"1"
				));
				$copain = $query_friends[0]['count(*)'];

				if($copain == 1)
				{
				$req = $bdd->query("SELECT count(*) FROM vote WHERE id_publication = :rowid AND id_user = :userid",array("rowid"=>$row['id'],"userid"=>$_SESSION['userid']));
				$count = $req[0]['count(*)'];
				$date = date("d-m-Y", strtotime($row['date']));
				$date = str_replace("-", "/", $date);
		        $heure = date("H:i", strtotime($row['date']));
				if($row['type'] != 1)
				{
					$dn = $bdd->query("SELECT * FROM users WHERE id = :rowidposter",array("rowidposter"=>$row['id_poster']));
					$dn[0]['avatar'] = base64_decode($dn[0]['avatar']);
					$row['content'] = place_smiley($row['content']);
					$row['content'] = urlToLink($row['content']);
					$row['content'] = marquage($row['content']);
					$row['content'] = YoutubeURLtoEmbed($row['content']);
					$row['content'] = YoutubeRedirectDiv($row['content']);
					$row['content'] = showBBcodes($row['content']);
					$row['content'] = hashtag($row['content']);
							    		?>
		    			<div id="publication<?php echo $row['id'] ?>" class="span6 well " style="overflow:hidden">
		    			<?php if($row['id_poster'] == $_SESSION['userid'] || $my_info[0]['admin'] == 1){ ?><a onclick="removePost(<?php echo $row['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $row['id']; ?>,<?php echo $row['id_poster']; ?>,1)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><u class="pull-right">Signaler</u></a><?php } ?>
		    				<h2><img src="<?php echo $dn[0]['avatar']; ?>" class="img-polaroid" style="max-width: 50px;"> <a style="color: #444444;" href="../profile/<?php echo $dn[0]['username'] ?>"><?php echo $dn[0]['surname']," ",$dn[0]['name']; ?></a> <?php if($row['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $row['categorie']; ?></small><?php } ?></h2>
		    				<p>
		                      <?php 
		                      if(isset($row['photo']) && $row['photo'] != ''){
		                        echo "<blockquote>".$row['content']."</blockquote>";
		                        echo '<img style="max-height:600px;" class="img-polaroid" src="../photo/'.$row['photo'].'" />';
		                      }else
		                      {
		                        echo $row['content'];
		                      }
		                      ?>
		                    </p>
		    				<small style="color: grey;">Le <?php echo $date; ?> à <?php echo $heure; ?></small>
		    				<p><a id="btnlike<?php echo $row['id']; ?>" onclick="addlike(<?php echo $row['id']; ?>,<?php echo $row['vote']; ?>);" class="btn like birneo_unselectable"><i id="like<?php echo $row['id']; ?>" <?php if($count == 0){ ?>class="icon-white icon-heart-empty"><?php }else{ ?> class="icon-white icon-heart"> <?php } ?></i> (<span id="vote<?php echo $row['id']; ?>"><?php echo $row['vote']; ?></span>)</a> <a class="btn btn-danger birneo_unselectable"><i class="icon-white icon-comment"></i> Commentaires (<span id="commentCount<?php echo $row['id'] ?>"><?php echo $row['comments']; ?></span>)</a> <span id="commentLoader<?php echo $row['id']; ?>" style="display:none;"> <img  name="commentLoader" src="http://birneo.com/assets/img/loader.gif" width="16"> </span></p>
		    				<div id="error<?php echo $row['id']; ?>"></div>
		    				<div id="commentaireDiv<?php echo $row['id']; ?>">
		    					<?php 
									get_comments($row['id']);
								?>
		    				</div>
		    				<form id="formComment<?php echo $row['id'] ?>" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
		    					<textarea id="addCommentaire<?php echo $row['id'] ?>" 
		    						onKeyPress=
		    						"
		    							addComment(<?php echo $row['id'] ?>); 
		    						"

		    						name="addCommentaire<?php echo $row['id'] ?>" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
		    					<input id="idForCommentaire" type="text" style="display:none;" value="<?php echo $row['id'] ?>"/> 
							</form>
		    				<?php /* if($id == $_SESSION['userid']){ ?><a class="btn btn-danger pull-right"><i class="icon-white icon-remove"></i> Supprimer</a><?php } */ ?>
		    			</div>
		    		<?php
					}
				}
			}
		}elseif($filtre == 2){
		
		
			$query_publication = $bdd->query("SELECT * FROM posts WHERE photo IS NOT NULL  ORDER BY date DESC");
			$count = $bdd->query("SELECT count(*) FROM posts");
			$nbr = $count[0]['count(*)'];
			foreach($query_publication as $row)
			{
				$query_friends = $bdd->query("SELECT count(*) FROM friends WHERE id_exp = :userid1 AND id_dest = :rowidposter1 AND active = :active1 OR id_dest = :userid2 AND id_exp = :rowidposter2 AND active = :active2",array(
					"userid1"=>$_SESSION['userid'],
					"rowidposter1"=>$row['id_poster'],
					"active1"=>"1",
					"userid2"=>$_SESSION['userid'],
					"rowidposter2"=>$row['id_poster'],
					"active2"=>"1"
				));
				$copain = $query_friends[0]['count(*)'];

				
				$req = $bdd->query("SELECT count(*) FROM vote WHERE id_publication = :rowid AND id_user = :userid",array("rowid"=>$row['id'],"userid"=>$_SESSION['userid']));
				$count = $req[0]['count(*)'];

				$date = date("d-m-Y", strtotime($row['date']));
				$date = str_replace("-", "/", $date);
		        $heure = date("H:i", strtotime($row['date']));
				if($row['type'] != 1)
				{
					$dn = $bdd->query("SELECT * FROM users WHERE id = :id_poster",array("id_poster"=>$row['id_poster']));
					$dn[0]['avatar'] = base64_decode($dn[0]['avatar']);
					$row['content'] = place_smiley($row['content']);
					$row['content'] = urlToLink($row['content']);
					$row['content'] = marquage($row['content']);
					$row['content'] = YoutubeURLtoEmbed($row['content']);
					$row['content'] = YoutubeRedirectDiv($row['content']);
					$row['content'] = showBBcodes($row['content']);
					$row['content'] = hashtag($row['content']);
							    		
					?>
		    			<div id="publication<?php echo $row['id'] ?>" class="span6 well " style="overflow:hidden">
		    			<?php if($row['id_poster'] == $_SESSION['userid'] || $my_info[0]['admin'] == 1){ ?><a onclick="removePost(<?php echo $row['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $row['id']; ?>,<?php echo $row['id_poster']; ?>,1)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><u class="pull-right">Signaler</u></a><?php } ?>
		    				<h2><img src="<?php echo $dn[0]['avatar']; ?>" class="img-polaroid" style="max-width: 50px;"> <a style="color: #444444;" href="../profile/<?php echo $dn[0]['username'] ?>"><?php echo $dn[0]['surname']," ",$dn[0]['name']; ?></a> <?php if($row['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $row['categorie']; ?></small><?php } ?></h2>
		    				<p>
		                      <?php 
		                      if(isset($row['photo']) && $row['photo'] != ''){
		                        echo "<blockquote>".$row['content']."</blockquote>";
		                        echo '<img style="max-height:600px;" class="img-polaroid" src="../photo/'.$row['photo'].'" />';
		                      }else
		                      {
		                        echo $row['content'];
		                      }
		                      ?>
		                    </p>
		    				<small style="color: grey;">Le <?php echo $date; ?> à <?php echo $heure; ?></small>
		    				<p><a id="btnlike<?php echo $row['id']; ?>" onclick="addlike(<?php echo $row['id']; ?>,<?php echo $row['vote']; ?>);" class="btn like birneo_unselectable"><i id="like<?php echo $row['id']; ?>" <?php if($count == 0){ ?>class="icon-white icon-heart-empty"><?php }else{ ?> class="icon-white icon-heart"> <?php } ?></i> (<span id="vote<?php echo $row['id']; ?>"><?php echo $row['vote']; ?></span>)</a> <a class="btn btn-danger birneo_unselectable"><i class="icon-white icon-comment"></i> Commentaires (<span id="commentCount<?php echo $row['id'] ?>"><?php echo $row['comments']; ?></span>)</a> <span id="commentLoader<?php echo $row['id']; ?>" style="display:none;"> <img  name="commentLoader" src="http://birneo.com/assets/img/loader.gif" width="16"> </span></p>
		    				<div id="error<?php echo $row['id']; ?>"></div>
		    				<div id="commentaireDiv<?php echo $row['id']; ?>">
		    					<?php 
									get_comments($row['id']);
								?>
		    				</div>
		    				<form id="formComment<?php echo $row['id'] ?>" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
		    					<textarea id="addCommentaire<?php echo $row['id'] ?>" 
		    						onKeyPress=
		    						"
		    							addComment(<?php echo $row['id'] ?>); 
		    						"

		    						name="addCommentaire<?php echo $row['id'] ?>" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
		    					<input id="idForCommentaire" type="text" style="display:none;" value="<?php echo $row['id'] ?>"/> 
							</form>
		    				<?php /* if($id == $_SESSION['userid']){ ?><a class="btn btn-danger pull-right"><i class="icon-white icon-remove"></i> Supprimer</a><?php } */ ?>
		    			</div>
		    		<?php
					}
				
			}
		}
	

}
function get_comments($id)
{
	global $bdd;
	$query_commentaire = $bdd->query("SELECT * FROM comments WHERE id_publication=:id LIMIT 0,3",array("id"=>$id));
	$query_commentaire_count = $bdd->query("SELECT count(*) FROM comments WHERE id_publication=:id",array("id"=>$id));

	$nbr_commentaire = $query_commentaire_count[0]['count(*)'];

	$my_info = $bdd->query("SELECT * FROM users WHERE id = :userid",array("userid"=>$_SESSION['userid']));

	foreach($query_commentaire as $row)
	{
		$dn = $bdd->query("SELECT * FROM users WHERE id= :id_poster",array("id_poster"=>$row['id_poster']));

		$avatar = base64_decode($dn[0]['avatar']);
		$username = $dn[0]['username'];
		$row['content'] = place_smiley($row['content']);
		$row['content'] = urlToLink($row['content']);
		$row['content'] = marquage($row['content']);
		$row['content'] = YoutubeRedirectDiv($row['content']);
		$row['content'] = showBBcodes($row['content']);
		$row['content'] = hashtag_comments($row['content']);
				
		$date = date("d-m-Y", strtotime($row['date']));
		$date = str_replace("-", "/", $date);
        $heure = date("H:i", strtotime($row['date']));
		?>  
			<div id="commentaire<?php echo $row['id']; ?>" class="span4 commentaire" style="padding:5px;margin:0px;overflow:hidden">
				<p><img src="<?php echo $avatar; ?>" class="img-polaroid" style="max-width: 30px;"> <strong><a style="color:#444444;" href="../profile/<?php echo $dn[0]['username']; ?>"><?php echo $dn[0]['surname']," ",$dn[0]['name']; ?></a></strong><?php if($row['id_poster'] == $_SESSION['userid'] || $my_info[0]['admin'] == 1){ ?><a onclick="removeComment(<?php echo $row['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $row['id']; ?>,<?php echo $row['id_poster']; ?>,2)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><u class="pull-right">Signaler</u></a><?php } ?></p>
				<p style="font-size: 12px;"><i class="icon-black icon-comment"></i> <?php echo $row['content']; ?></p>
				<small class="pull-right" style="color: grey;"><?php echo $date; ?> à <?php echo $heure; ?></small> 
			</div>
		<?php
	}

	if($nbr_commentaire > 3){ 
		?>
			<div class="span4 commentaire" style="padding:5px;margin:0px;overflow:hidden">
				<a class="btn btn-primary" href="../publication/<?php echo $id; ?>" target="_blank">Voir tous les commentaires</a>
			</div>
		<?php
	}
}

function get_publication_amis()
{
	global $bdd;
	$query_publication = $bdd->query("SELECT * FROM posts WHERE id_poster<>:userid ORDER BY id DESC",array("userid"=>$_SESSION['userid']));
	foreach($query_publication as $row)
	{
		$id = $row['id_poster'];
		$dn = $bdd->query("SELECT * FROM users WHERE id=:id",array("id"=>$id));
		$dn[0]['avatar'] = base64_decode($dn[0]['avatar']);
		$myid = $_SESSION['userid'];
		try{
			$isFriendReq = $bdd->query("
				SELECT count(*) FROM friends WHERE id_exp=:id1 AND id_dest=:myid1 AND active=:active1
										 OR id_exp=:myid2 AND id_dest=:id2 AND active=:active2
				",array("id1"=>$id,"myid1"=>$myid,"active1"=>"1","myid2"=>$myid,"id2"=>$id,"active2"=>"1"));
			$isFriend = $isFriendReq[0]['count(*)'];
		}
		catch(Exception $e){
			die($e);
		}

		if($isFriend == 1)
		{
			$req = $bdd->query("SELECT * FROM vote WHERE id_publication = :rowid AND id_user = :userid",array("rowid"=>$row['id'],"userid"=>$_SESSION['userid']));
			$count = $req[0]['count(*)'];
			if($row['type'] != 1)
			{
				$dn = $bdd->query("SELECT * FROM users WHERE id = :rowidposter AND NOT id = :userid",array("rowidposter"=>$row['id_poster'],"userid"=>$_SESSION['userid']));
				$dn[0]['avatar'] = base64_decode($dn[0]['avatar']);
	    		?>
	    			<div id="<?php echo $row['id'] ?>" class="span6 well">
	    				<h2><img src="<?php echo $dn[0]['avatar']; ?>" class="img-polaroid" style="max-width: 50px;"> <?php echo $dn[0]['surname']," ",$dn[0]['name']; ?> <?php if($row['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $row['categorie']; ?></small><?php } ?></h2>
	    				<p><?php echo $row['content'] ?></p>
	    				<p><a id="btnlike<?php echo $row['id']; ?>" onclick="addlike(<?php echo $row['id']; ?>);" class="btn like birneo_unselectable"><i id="like<?php echo $row['id']; ?>" <?php if($count == 0){ ?>class="icon-white icon-heart-empty"><?php }else{ ?> class="icon-white icon-heart"> <?php } ?></i> (<span id="vote<?php echo $row['id']; ?>"><?php echo $row['vote']; ?></span>)</a> <a class="btn btn-danger birneo_unselectable"><i class="icon-white icon-comment"></i> Commentaires (<span id="commentCount<?php echo $row['id'] ?>"><?php echo $row['comments']; ?></span>)</a> <span id="commentLoader<?php echo $row['id']; ?>" style="display:none;"> <img  name="commentLoader" src="http://birneo.com/assets/img/loader.gif" width="16"> </span></p>
	    				<div id="error<?php echo $row['id']; ?>"></div>
	    				<div id="commentaireDiv<?php echo $row['id']; ?>">
    					<?php 
    						get_comments($row['id']); 
    						
    					?>
	    				</div>
	    				<form id="formComment<?php echo $row['id'] ?>" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
	    					<textarea id="addCommentaire<?php echo $row['id'] ?>" onKeyPress="if(event.keyCode == 13){ addComment(<?php echo $row['id'] ?>); }"  name="addCommentaire" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
	    					<input id="idForCommentaire" type="text" style="display:none;" value="<?php echo $row['id'] ?>"/> 
						</form>
	    				<?php /* if($id == $_SESSION['userid']){ ?><a class="btn btn-danger pull-right"><i class="icon-white icon-remove"></i> Supprimer</a><?php } */ ?>
	    			</div>
	    		<?php
	    	}else
	    	{
	    		$sender = $bdd->query("SELECT * FROM users WHERE id= :rowdest",array("rowdest"=>$row['dest']));
	    		$receiver = $bdd->query("SELECT * FROM users WHERE id= :rowidposter",array("rowidposter"=>$row['id_poster']));
	    		
	    		?>
	    		<div id="<?php echo $row['id'] ?>" class="span6 well">
					<h3><img src="<?php echo base64_decode($sender[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <?php echo $sender[0]['surname']," ",$sender[0]['name'], " <i class='icon-black icon-arrow-right'></i> ", $receiver[0]['surname']," ",$receiver[0]['name']; ?> <?php if($row['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $row['categorie']; ?></small><?php } ?></h3>
					<p><?php echo $row['content'] ?></p>
					<p><a id="btnlike<?php echo $row['id']; ?>" onclick="addlike(<?php echo $row['id']; ?>);" class="btn like birneo_unselectable"><i id="like<?php echo $row['id']; ?>" <?php if($count == 0){ ?>class="icon-white icon-heart-empty"><?php }else{ ?> class="icon-white icon-heart"> <?php } ?></i> (<span id="vote<?php echo $row['id']; ?>"><?php echo $row['vote']; ?></span>)</a> <a class="btn btn-danger birneo_unselectable"><i class="icon-white icon-comment"></i> Commentaires (<span id="commentCount<?php echo $row['id'] ?>"><?php echo $row['comments']; ?></span>)</a> <span id="commentLoader<?php echo $row['id']; ?>" style="display:none;"> <img  name="commentLoader" src="http://birneo.com/assets/img/loader.gif" width="16"> </span></p>
    				<div id="error<?php echo $row['id']; ?>"></div>
    				<div id="commentaireDiv<?php echo $row['id']; ?>">
    					<?php 
    						get_comments($row['id']); 
    						
    					?>
    				</div>
    				<form id="formComment<?php echo $row['id'] ?>" class="span4" style="margin:0;padding:5px;background-color: #F5F5F5;">
    					<textarea id="addCommentaire<?php echo $row['id'] ?>" onKeyPress="if(event.keyCode == 13){ addComment(<?php echo $row['id'] ?>); }"  name="addCommentaire" placeholder="Ajouter un commentaire..." data-placement="right" title="Astuce" data-content="Pour envoyer le commentaire, pressez la touche Entrée." style="width:95%;max-width:95%;" ></textarea>
    					<input id="idForCommentaire" type="text" style="display:none;" value="<?php echo $row['id'] ?>"/> 
					</form>
					<?php /* if($id == $_SESSION['userid']){ ?><a class="btn btn-danger pull-right"><i class="icon-white icon-remove"></i> Supprimer</a><?php } */ ?>
				</div>
	    			<?php
	    		}
		}
		
		
	}
	/*$post_numbers = $query_publication->fetchColumn();
	if($post_numbers == 0)
	{
		return 0;
	}else
	{
		return 1;
	}*/

}

?>