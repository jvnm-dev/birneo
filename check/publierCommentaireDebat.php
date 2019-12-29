<?php
	include('../res/config.php');
	header('Content-type: text/html; charset=utf-8');

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


	$contenu = DestroyHTML($_POST['content']);
	$id_publication = DestroyHTML(intval($_POST['id_publication']));

	$publication = $bdd->query("SELECT * FROM posts WHERE id=:id_publication",array("id_publication"=>$id_publication));
	
	$req = $bdd->query("SELECT count(*) FROM comments WHERE id_publication = '$id_publication'");
	$count = $req[0]['count(*)'];
	$t = array();
	$t["nombre"] = $count;	
	date_default_timezone_set('Europe/Brussels');
	$date = date("Y-m-d").' '.date("H:i");
//	$t["erreur"] = "<div class='alert alert-error' id='erreur'>Formulaire incorrect</div>";
	
	if($_POST['content'] != '')
	{
		$id = $_SESSION['userid'];
		$link = "publication/".$id_publication;
		$bdd->query("INSERT INTO comments_debat(id_poster,content,id_publication,date) VALUES (:id,:contenu,:id_publication,:datee)",array(
				"id"=>$id,
				"contenu"=>$contenu,
				"id_publication"=>$id_publication,
				"datee"=>$date
			));
		$t["erreur"] = "no";
		$me = $bdd->query("SELECT * FROM users WHERE id=:userid",array("userid"=>$_SESSION['userid']));
		
		$contenu = place_smiley($contenu);
		$t["comment"] =
		"
	      <div class='span4 commentaire' style='padding:5px;margin:0px;'>
	        <p><img src='".base64_decode($me[0]['avatar'])."' class='img-polaroid' style='max-width: 30px;'> <strong>".$me[0]['surname']." ".$me[0]['name']."</strong></p>
	        <p style='font-size: 12px;'><i class='icon-black icon-comment'></i> ".$_POST['content']."</p>
	      </div>
	    ";
	}

	echo json_encode($t);
	
?>