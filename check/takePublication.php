<?php 
	require("../res/config.php"); 
	$bdd->query("SET NAMES 'utf8'");
	require("../functions/home.func.php");
	$limit = intval($_POST['load']) * 10;
	$query_publication = $bdd->query("SELECT * FROM posts ORDER BY id DESC LIMIT :limit,10",array("limit"=>$limit));
	$my_info = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
	
	if(isset($_GET['filtre'])){
		$filtre = DestroyHTML($_GET['filtre']);
	}
	
	foreach($query_publication as $row) 
	{
		$req = $bdd->query("SELECT count(*) FROM vote WHERE id_publication = :rowid AND id_user = :userid",array("rowid"=>$row['id'],"userid"=>$_SESSION['userid']));
		$count = $req[0]['count(*)'];
		$date = date("d-m-Y", strtotime($row['date']));
		$date = str_replace("-", "/", $date);
        $heure = date("H:i", strtotime($row['date']));
		if($row['type'] != 1)
		{
			$dn = $bdd->query("SELECT * FROM users WHERE id=:rowidposter",array("rowidposter"=>$row['id_poster']));
			$dn[0]['avatar'] = base64_decode($dn[0]['avatar']);
			$row['content'] = place_smiley($row['content']);
            $row['content'] = urlToLink($row['content']);
            $row['content'] = marquage($row['content']);
            $row['content'] = YoutubeURLtoEmbed($row['content']);
            $row['content'] = YoutubeRedirectDiv($row['content']);
            $row['content'] = showBBcodes($row['content']);
            $row['content'] = hashtag($row['content']);
			

    		?>
    			<div id="publication<?php echo $row['id'] ?>" class="span6 well generatedPost">
    			<?php if($row['id_poster'] == $_SESSION['userid'] || $my_info[0]['admin'] == 1){ ?><a onclick="removePost(<?php echo $row['id']; ?>)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a><?php }else{ ?><a onclick="signaler(<?php echo $row['id']; ?>,<?php echo $row['id_poster']; ?>,1)" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-warning-sign pull-right"></i></a><?php } ?>
    				<h2><img src="<?php echo $dn[0]['avatar']; ?>" class="img-polaroid" style="max-width: 50px;"> <a style="color: #444444;" href="../profile/<?php echo $dn[0]['username'] ?>"><?php echo $dn[0]['surname']," ",$dn[0]['name']; ?></a> <?php if($row['categorie'] != "Aucune"){ ?><small style="font-size: 15px;"><i class="icon-globe icon-white"></i> <?php echo $row['categorie']; ?></small><?php } ?></h2>
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
?>