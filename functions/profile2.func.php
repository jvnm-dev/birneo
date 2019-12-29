<?php
	
	require_once __DIR__ . '/mysql/Db.class.php';
	$bdd = new Db();

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
		    "<img src='".$link."assets/img/content.gif' title=':)'  />",
			"<img src='".$link."assets/img/content.gif' title=':)'  />",
			"<img src='".$link."assets/img/rire.gif' title=':D'  />",
			"<img src='".$link."assets/img/rire.gif' title=':D'  />",
			"<img src='".$link."assets/img/rire.gif' title=':D'  />",
			"<img src='".$link."assets/img/rire.gif' title=':D'  />",
			"<img src='".$link."assets/img/langue.gif' title=':p'  />",
			"<img src='".$link."assets/img/langue.gif' title=':-p'  />",
			"<img src='".$link."assets/img/langue.gif' title=':P'  />",
			"<img src='".$link."assets/img/langue.gif' title=':-P'  />",
			"<img src='".$link."assets/img/^^.gif' title='^^'  />",
			"<img src='".$link."assets/img/^^.gif' title='^^'  />",
			"<img src='".$link."assets/img/^^.gif' title='^^'  />",
			"<img src='".$link."assets/img/love.gif' title='<3'  />",
			"<img src='".$link."assets/img/etonne.gif' title=':o'  />",
	        "<img src='".$link."assets/img/etonne.gif' title=':o'  />",
	        "<img src='".$link."assets/img/etonne.gif' title=':o'  />",
	        "<img src='".$link."assets/img/etonne.gif' title=':o'  />",
	        "<img src='".$link."assets/img/pascontent.gif' title=':('  />",
	        "<img src='".$link."assets/img/pascontent.gif' title=':('  />",
	        "<img src='".$link."assets/img/semitriste.gif' title=':/'  />",
	        "<img src='".$link."assets/img/triste.gif' title=\":'(\"  />",
	        "<img src='".$link."assets/img/triste.gif' title=\":'(\"  />",
	       	"<br />"

		);
		$var = str_replace($smileys_code, $smileys, $var);
		return $var;
	}

	function marquage($chaine)
	{
		$chaine = preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i','<a href="'.$link.'profile/$1" target="_blank">@$1</a>',$chaine);
		return $chaine;
	}

	function get_comment($id)
	{
		global $bdd;
		

		foreach($query_commentaire as $row)
    	{
    		$dn = $bdd->query("SELECT * FROM users WHERE id=:rowidposter",array("rowidposter"=>$row['id_poster']));
			$avatar = base64_decode($dn[0]['avatar']);
			$username = $dn[0]['username'];
			$row['content'] = place_smiley($row['content']);
			$row['content'] = marquage($row['content']);
			?>
				<div class="span4 commentaire" style="padding:5px;margin:0px;">
					<p><img src="<?php echo $avatar; ?>" class="img-polaroid" style="max-width: 30px;" /> <strong> <?php echo $dn[0]['surname']," ",$dn[0]['name']; ?></strong><a id="removeComment" style="color: #92acc3;text-decoration:none;cursor:pointer;"><i class="icon-black icon-remove pull-right"></i></a></p>
					<p style="font-size: 12px;"><i class="icon-black icon-comment"></i> <?php echo $row['content']; ?></p>
				</div>
			<?php
    	}
	}
	
?>