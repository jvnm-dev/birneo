<?php
    include("config.php");
    $bdd->query("SET NAMES 'utf8'");

    $id = $_SESSION['userid'];
    $zero = 0;
    
    $query_count = $bdd->query("SELECT count(*) FROM notification WHERE id_proprio = :id AND readed = :zero ORDER BY id DESC LIMIT 0,5",array("id"=>$id,"zero"=>$zero));
    $count = $query_count[0]['count(*)'];
    if($count >= 1)
    {
      ?>
      
        <?php
        $query_notification = $bdd->query("SELECT * FROM notification WHERE id_proprio = :id AND readed = :zero ORDER BY id DESC LIMIT 0,5",array("id"=>$id,"zero"=>$zero));
        foreach($query_notification as $row)
        {
          $id = $row['id_exp'];
          $bdd->bind("id_exp", $id);
          $user_exp = $bdd->query("SELECT * FROM users WHERE id = :id_exp");
          ?>
          <li id="notif<?php echo $row['id']; ?>" 
            onMouseOver="this.style.backgroundColor='#f0f0f0'"
            onMouseOut="this.style.backgroundColor='#ffffff'"
            onclick="document.location.href='<?php echo "../".$row['link']; ?>'"
            style="cursor: pointer;">
            
            <div class="media" style="cursor: pointer;">
                  <?php 
                    if(!empty($user_exp[0]['avatar']))
                    {
                      ?>
                        <a class="pull-left" href="#">
                          <img src="<?php echo base64_decode($user_exp[0]['avatar']) ?>" class="img-polaroid" style="max-width: 30px;margin-right:5px;">
                        </a>
                      <?php
                    }
                  ?>
                  <div class="media-body" style="margin-left:5px;" style="cursor: pointer;" >
                    <h5 class="media-heading" style="font-weight: 500;cursor: pointer;"><a style="color:grey;text-decoration:none;cursor:pointer;" onclick="supprimerNotif(<?php echo $row['id']; ?>,<?php echo $row['id_proprio']; ?>)"></h5></a>
                    <p style="cursor: pointer;"> <?php echo tronque($row['contenu'],50); ?></p>
                      
                       <!-- <a href="../check/voirSource.php?id=<?php echo $row['id']; ?>" class="birne_unselectable btn btn-primary"><i class="icon-white icon-eye-open"></i></a> 
                        <a class="birne_unselectable btn btn-danger"><i class="icon-white icon-eye-close"></i></a>
                    -->
                  </div>
                </div>
            </li>
            <li class="divider"></li>
            <?php
        } ?>
        
      <?php
    }else
    {
      $id = intval($_SESSION['userid']);
      $un = 1;
      $query_notification = $bdd->query("SELECT * FROM notification WHERE id_proprio = :id AND readed = :un ORDER BY id DESC LIMIT 0,5",array("id"=>$id,"un"=>$un));
      
      $query_count = $bdd->query("SELECT count(*) FROM notification WHERE id_proprio = :id AND readed = :un ORDER BY id DESC LIMIT 0,5",array("id"=>$id,"un"=>$un));      
      $count = $query_count[0]['count(*)'];
      if($count == 0)
      {
        echo "Aucune activité récente de vos amis";
      }
      foreach($query_notification as $row)
        {

          $id = $row['id_exp'];
          $bdd->bind("id_exp", $id);
          $user_exp = $bdd->query("SELECT * FROM users WHERE id = :id_exp");
          ?>
          <li id="notif<?php echo $row['id']; ?>" 
            onMouseOver="this.style.backgroundColor='#f0f0f0'"
            onMouseOut="this.style.backgroundColor='#ffffff'"
            onclick="document.location.href='<?php echo "../".$row['link']; ?>'"
            style="cursor: pointer;">
            <div class="media">
                  <?php 
                    if(!empty($user_exp[0]['avatar']))
                    {
                      ?>
                        <a class="pull-left" href="#">
                          <img src="<?php echo base64_decode($user_exp[0]['avatar']) ?>" class="img-polaroid" style="max-width: 30px;margin-right:5px;">
                        </a>
                      <?php
                    }
                  ?>
                  <div class="media-body" style="margin-left:5px;">
                    <h5 class="media-heading" style="font-weight: 500;"><a style="color:grey;text-decoration:none;cursor:pointer;" onclick="supprimerNotif(<?php echo $row['id']; ?>,<?php echo $row['id_proprio']; ?>)"></h5></a>
                    <p> <?php echo tronque($row['contenu'],50); ?></p>
                      
                       <!-- <a href="../check/voirSource.php?id=<?php echo $row['id']; ?>" class="birne_unselectable btn btn-primary"><i class="icon-white icon-eye-open"></i></a> 
                        <a class="birne_unselectable btn btn-danger"><i class="icon-white icon-eye-close"></i></a>
                    -->
                  </div>
                </div>
            </li>
            <li class="divider"></li>
            <?php
        } 
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