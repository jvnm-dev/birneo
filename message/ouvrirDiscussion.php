<?php 
	if(!isset($_SESSION['userid']))
	{
		session_start();
	}

	require_once dirname(__DIR__) . '/res/mysql/Db.class.php';
	$bdd = new Db();
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
          "<img src='../assets/img/triste.gif' title=\":'(\"  />",
          "<img src='../assets/img/triste.gif' title=\":'(\"  />"

	    );
	    $var = str_replace($smileys_code, $smileys, $var);
	    return $var;
	}
	$getid = intval($_GET['id']);
	$discussion = $bdd->query("SELECT * FROM discussion WHERE id=:getid",array("getid"=>$getid));
	if($discussion[0]['readed'] == 0)
    {
      if($discussion[0]['notifPour'] == $_SESSION['userid'])
      {
        $bdd->query("UPDATE discussion SET readed=:readed WHERE id=:getid",array("readed"=>"1","getid"=>$getid));
      }
    }
	 $query_message = $bdd->query("SELECT * FROM messages WHERE discussion=:getid ORDER BY date DESC LIMIT 0,15",array("getid"=>$getid));

	  foreach($query_message as $row)
	  {
	    $expediteur = $bdd->query("SELECT * FROM users WHERE id= :idexpediteur",array("idexpediteur"=>$row['id_expediteur']));
	    $destinataire = $bdd->query("SELECT * FROM users WHERE id= :iddestinataire",array("iddestinataire"=>$row['id_destinataire']));

	    if($expediteur[0]['id'] == $_SESSION['userid'])
	    {
	      $id = $destinataire[0]['id'];
	      $avatar = $destinataire[0]['avatar'];
	      $nom = $destinataire[0]['name'];
	      $prenom = $destinataire[0]['surname'];
	    }else
	    {
	      $id = $expediteur[0]['id'];
	      $avatar = $expediteur[0]['avatar'];
	      $nom = $expediteur[0]['name'];
	      $prenom = $expediteur[0]['surname'];
	    }
	    $date = date("d-m-Y", strtotime($row['date']));
	    $heure = date("H:i", strtotime($row['date']));
	    $row['message'] = place_smiley($row['message']);
	    $bdd->query("UPDATE discussion SET readed=:readed WHERE id = :getid",array("readed"=>"1","getid"=>$getid));
	    $bdd->query("UPDATE messages SET readed=:readed WHERE discussion = :getid AND id_destinataire = :userid",array("readed"=>"1","getid"=>$getid,"userid"=>$_SESSION['userid']));
	  ?>
	      	
	        <div class="media">
	          <a class="pull-left" href="#">
	          <img class="img-polaroid" style="max-width:50px;max-height:70px;" src="<?php echo base64_decode($expediteur[0]['avatar']); ?>" />
	          </a>
	          <div class="media-body">
	            <h4 class="media-heading"><?php echo $expediteur[0]['surname'], ' ', $expediteur[0]['name']; ?></h4>
	            <i class="icon-white icon-comment"></i> <?php echo $row['message']; ?>
	             
	            <!-- Nested media object -->
	            <div class="media">
	              <?php echo $heure,' ',str_replace('-' ,'/',$date); ?>
	            </div>
	        </div>
	        </div>
	        <hr />
	      
	  <?php 
	  }
	  ?>
	  <a href="../discussion/<?php echo $getid; ?>">Voir tous les messages</a>