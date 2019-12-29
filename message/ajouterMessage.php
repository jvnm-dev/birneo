<?php 
	require_once dirname(__DIR__) . '/res/config.php';
	
	$t = array();

	$discussion = DestroyHTML($_GET['id']);
	$myID = intval($_SESSION['userid']);

	$verifMessage = $bdd->query("SELECT * FROM messages WHERE id_destinataire=:myid AND discussion=:discussion AND readed=:zero",array("myid"=>$myID,"discussion"=>$discussion,"zero"=>"0"));

	$he = $bdd->query("SELECT * FROM users WHERE id=:idexpediteur",array("idexpediteur"=>$verifMessage[0]['id_expediteur']));

	$id = DestroyHTML($_GET['id']);

	$bdd->query("UPDATE discussion SET readed=:un WHERE id=:id",array("un"=>"1","id"=>$id));
	$bdd->query("UPDATE messages SET readed=:un WHERE discussion=:id AND id_destinataire=:userid",array("un"=>"1","id"=>$id,"userid"=>$_SESSION['userid']));
	$t['erreur'] = "no";
	$t["message"] =
	"
    <div class='media'>
      <a class='pull-left' href='#'>
      <img class='img-polaroid' style='max-width:50px;max-height:70px;' src='".base64_decode($he[0]['avatar'])."' />
      </a>
      <div class='media-body'>
        <h4 class='media-heading'>".$he[0]['surname']." ".$he[0]['name']."</h4>
        <i class='icon-white icon-comment'></i> ".$verifMessage[0]['message']."
        <div class='media'>
          ".$verifMessage[0]['date']."
        </div>
    </div>
    </div>
    <hr />
	";

	echo json_encode($t);

?>