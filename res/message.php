<?php
    include("config.php");
    $bdd->query("SET NAMES 'utf8'");
    $id = $_SESSION['userid'];
    $zero = 0;
    
    $bdd->bind("id", $id);
    $bdd->bind("id2", $id);
    $count = $bdd->query("SELECT count(*) FROM discussion WHERE id_1 = :id OR id_2 = :id2 ORDER BY date DESC,readed DESC LIMIT 0,5");
    
    $bdd->bind("id", $id);
    $bdd->bind("id2", $id);
    $req = $bdd->query("SELECT * FROM discussion WHERE id_1 = :id OR id_2 = :id2 ORDER BY date DESC,readed DESC LIMIT 0,5");
    if($count[0]['count(*)'] >= 1)
    {
        foreach($req as $row)
        {
            $id = $row['id'];
            $bdd->bind("iddiscussion", $id);
            $message = $bdd->query("SELECT * FROM messages WHERE discussion = :iddiscussion ORDER BY date DESC,id DESC LIMIT 0,1");
          if(isset($message[0]['id_expediteur']) && $message[0]['id_expediteur'] != $_SESSION['userid'])
          {
            $user = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $message[0]['id_expediteur']));
          } elseif(isset($message[0]['id_destinataire'])) {
            $user = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $message[0]['id_destinataire']));
          }

          if(isset($message[0]))
          {
            ?>
              <li id="message<?php echo $message[0]['id']; ?>"
            onMouseOver="this.style.backgroundColor='#f0f0f0'"
            onMouseOut="this.style.backgroundColor='#ffffff'"
            onclick="document.location.href='../discussion/<?php echo $row['id']; ?>'"
            style="cursor: pointer;">
            <div class="media">
              <a class="pull-left" href="#">
                <img class="media-object img-polaroid" style="max-width: 40px;max-height:40px;padding-left:5px" src="<?php echo base64_decode($user[0]['avatar']); ?>">
              </a>
              <div class="media-body">
                <h4 class="media-heading"><?php echo $user[0]['surname'].' '.$user[0]['name'];?> 
                  <?php 
                  if($row['notifPour'] == $_SESSION['userid'])
                  {
                    echo '<span class="label label-error">Reçu</span></h4> ';
                    
                  } else {
                    echo '<span class="label label-error">Envoyé</span></h4> ';
                  }
                  if($row['notifPour'] == $_SESSION['userid'])
                  {
                    echo '<i class="icon-black icon-arrow-down"></i> '.tronque($message[0]['message'],20);
                    
                  } else {
                    echo '<i class="icon-black icon-arrow-up"></i> '.tronque($message[0]['message'],20);
                  }
                ?>
              </div>
            </div>
          </li>
            <li class="divider"></li>
            <?php
          }
        } ?>
        
      <?php
    } else {
      echo "Vous n'avez pas de message";
      echo "<br />";
      echo "<a href='../inbox'><u>Lancer une discussion</h4></u></a>";
    }
    
    function tronque($chaine, $longueur = 120) 
  {
   
    if (empty ($chaine)) 
    { 
      return ""; 
    }
    elseif (strlen ($chaine) < $longueur) 
    { 
      return $chaine; 
    }
    elseif (preg_match ("/(.{1,$longueur})\s./ms", $chaine, $match)) 
    { 
      return $match [1] . "..."; 
    }
    else 
    { 
      return substr ($chaine, 0, $longueur) . "..."; 
    }
  }
?>