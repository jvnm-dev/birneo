<?php 
	if(!isset($_SESSION['userid']))
	{
		session_start();
	}

	require_once dirname(__DIR__) . '/res/mysql/Db.class.php';
	$bdd = new Db();
	$bdd->query('SET NAMES utf8')
?>
<ul class="nav nav-list" style="border:none;">

<?php 
	$query_discussion = $bdd->query("SELECT * FROM discussion WHERE id_1 = :userid1 OR id_2 = :userid2 ORDER BY date desc",array("userid1"=>$_SESSION['userid'],"userid2"=>$_SESSION['userid']));
	foreach($query_discussion as $discussion)
	{
		$query_message = $bdd->query("SELECT count(*) FROM messages WHERE discussion = :discussionid",array("discussionid"=>$discussion['id']));
		$query_message2 = $bdd->query("SELECT * FROM messages WHERE discussion = :discussionid AND id_destinataire = :userid",array("discussionid"=>$discussion['id'],"userid"=>$_SESSION['userid']));
		$nonlu = 0;

		foreach($query_message2 as $row)
		{
			if($row['readed'] == 0)
			{
				$nonlu++;
			}
		}

		$nbreMessage = $query_message[0]['count(*)'];
		if($nbreMessage <= 1)
		{
			$message = "message";
		}else
		{
			$message = "messages";
		}


		if($discussion['id_1'] == $_SESSION['userid'])
		{
			$user = $bdd->query("SELECT * FROM users WHERE id = :discussionid2",array("discussionid2"=>$discussion['id_2']));
		}else
		{
			$user = $bdd->query("SELECT * FROM users WHERE id = :discussionid1",array("discussionid1"=>$discussion['id_1']));
		}
		$me = $bdd->query("SELECT * FROM users WHERE id = :userid",array("userid"=>$_SESSION['userid']));
		
		if(isset($user[0]))
		{
			?>
				<li class=" birneo_unselectable"  style="cursor: pointer;"><a onclick="ouvrirDiscussion(<?php echo $discussion['id']; ?>)">Conversation avec  <?php echo $user[0]['surname'],' ',$user[0]['name']; ?><br /><?php echo $nbreMessage,' ',$message; ?>
			<?php 
		}
		if($nonlu>0)
		{
			?>
			<br /><?php echo $nonlu; ?> message(s) non lu(s)
			<?php
		} ?>
		</a></li>
		<?php

	}
?>
</ul>