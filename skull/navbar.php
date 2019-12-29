<?php 

  include("functions/notification.func.php");
  /*include("modal/notification.php"); */
  function get_notifications()
  {
    global $bdd;
    $id = intval($_SESSION['userid']);
    $zero = 0;
    $query_notification = $bdd->query("SELECT count(*) FROM notification WHERE id_proprio=:id AND readed=:zero ORDER BY id DESC LIMIT 0,5",array("id"=>$id,"zero"=>$zero));
    $count = $query_notification[0]['count(*)'];
    if($count >= 1)
    {
      ?>
      
        <?php

        foreach($query_notification as $row)
        {
          $user_exp = $bdd->query("SELECT * FROM users WHERE id=:rowidexp",array("rowidexp"=>$row['id_exp']));
          ?>
          <li id="notif<?php echo $row['id']; ?>" 
            onMouseOver="this.style.backgroundColor='#f0f0f0'"
            onMouseOut="this.style.backgroundColor='#ffffff'">
            <div class="media">
                  <a class="pull-left" href="#">
                    <img src="<?php echo base64_decode($user_exp[0]['avatar']) ?>" class="img-polaroid" style="max-width: 30px;margin-right:5px;">
                  </a>
                  <div class="media-body" style="margin-left:5px;">
                    <h5 class="media-heading" style="font-weight: 500;"> <?php echo $user_exp[0]['surname'],' ', $user_exp[0]['name'], ' ', $row['action']; ?>: <a style="color:grey;text-decoration:none;cursor:pointer;" onclick="supprimerNotif(<?php echo $row['id']; ?>,<?php echo $row['id_proprio']; ?>)"><i class="icon-white icon-remove" style="float:right;padding-right:10px;"></h5></i></a>
                    <p> “<?php echo tronque($row['contenu'],50); ?>”</p>
                      
                       <!-- <a href="../check/voirSource.php?id=<?php echo $row['id']; ?>" class="birne_unselectable btn btn-primary"><i class="icon-white icon-eye-open"></i></a> 
                        <a class="birne_unselectable btn btn-danger"><i class="icon-white icon-eye-close"></i></a>
                    -->
                  </div>
                </div>
            </li>
            <li class="divider"></li>
            <?php
        } ?>
        <a class="btn-block btn btn-danger"><i class="icon-white icon-refresh"></i> Voir 5 autres notifications</a><li>
        
      <?php
    }else
    {
      echo "<p id='NewNotificationText'>Aucune activité récente de la part de vos amis</p>";
      $query_notification =  $bdd->query("SELECT count(*) FROM notification WHERE id_proprio=:userid AND readed=:readed ORDER BY id DESC",array("userid"=>$_SESSION['userid'],"readed"=>"1"));
      $count2 = $query_notification[0]['count(*)'];

      if($count2 >= 1)
      {
        ?>
          <a id="showOldNotification" class="birneo_unselectable btn btn-primary"><i class="icon-white icon-eye-open"></i> Voir les notifications déjà lues</a>
        
          <div id="oldNotification" style="display:none;">
          <?php
            foreach($query_notification2 as $row)
            {
              $user_exp = $bdd->query("SELECT * FROM users WHERE id=:rowidexp",array("rowidexp"=>$row['id_exp']));

              ?>
                <div class="well">
                    <div class="media">
                      <a class="pull-left" href="#">
                        <img src="<?php echo base64_decode($user_exp[0]['avatar']) ?>" class="img-polaroid" style="max-width: 50px;">
                      </a>
                      <div class="media-body">
                        <h4 class="media-heading" style="font-weight: 500;"><?php echo $user_exp[0]['surname'],' ', $user_exp[0]['name'], ' ', $row['action']; ?></h4>
                        <div class="media">
                          <blockquote>
                            <p><?php echo tronque($row['contenu'],50); ?></p>
                          </blockquote>
                          <a href="../check/voirSource.php?id=<?php echo $row['id']; ?>" class="birne_unselectable btn btn-primary"><i class="icon-white icon-eye-open"></i> Voir la source</a> 
                          <a class="birne_unselectable btn btn-danger"><i class="icon-white icon-eye-close"></i> Désactiver les notifications pour cet utilisateur</a>
                        </div>
                      </div>
                    </div>
                  </div>
              <?php
            }
          ?>
          </div>
      <?php
      }
            
    }
  }
?>
<div class="navbar navbar-fixed-top">
         <div class="navbar-inner">
           <div class="container">
             <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
             </button>
             <a class="brand" href="<?php echo '../home' ?>">Birneo</a>
             <div class="nav-collapse collapse">
               <ul class="nav">
                  <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b> 
                      <span style="font-size:14px;">Parcourir</span>
                   </a>
                   <ul class="dropdown-menu"> 
                     <li><a href="<?php echo '../home' ?>"><i class="icon-black icon-home"></i> Flux d'actualité</a></li>
                     <li class="divider"></li>
                     <li class="nav-header">Découvrez</li>
                     <li><a href="<?php echo '../home?filtre=photo' ?>"><i class="icon-black icon-picture"></i> Flux des photos</a></li>
                     <?php
                        $count_billet_support = $bdd->query("SELECT count(*) FROM bug WHERE statut=:statut",array("statut"=>"0"));
                        $nbr_billet_support = $count_billet_support[0]['count(*)'];
                        if($my_info[0]["admin"] == 1){
                          ?> 
                            <li><a href="../buglist">Billet(s)</a>
                          <?php
                          if($nbr_billet_support > 0){
                            ?>
                              <span id='nbreNotif' class='badge badge-important' style=""><?php echo $nbr_billet_support; ?></span></li>
                            <?php
                          }
                        }
                      ?>
                     <li class="divider"></li>
                     <li class="nav-header">Hashtags</li>
                     <li><a href="<?php echo '../phashtag' ?>"><i class="icon-bullhorn"></i> #Publications</a></li>
                     <li><a href="<?php echo '../chashtag' ?>"><i class="icon-comment"></i> #Commentaires</a></li>
                     <li class="divider"></li>
                     <li class="nav-header">Partagez</li>
                     <li><a href="<?php echo '../debats' ?>"><i class="icon-globe"></i> Débats</a></li>
                   </ul>
                 </li>
               </ul>
                <form class="navbar-search pull-left" method="POST" action="../check/searchFriend.php" style="margin-top:6px;">
                  <input id="search" name="search" autocomplete="off" data-placement="bottom" title="Recherche rapide" data-content="Pour commencer, tapez '@'. Ensuite tapez le nom de la personne que vous recherchez." style="border-radius:30px;font-size:14px;" type="text" class="search-query" placeholder="Recherche (@Nom d'utilisateur)">
                </form>

               <ul class="nav pull-right">

                

                <li class="dropdown">
                   <a id="notifNavbar"  href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b> Notifications 
                    <span id='nbreNotif' class='badge badge-important' style="display:none;"></span></a>
                   <ul class="dropdown-menu">
                    <li align="center" style="border: solid 1px #f0f0f0;margin-bottom:5px;text-align:center;"><center><h4>Vos notifications <a href="../notifications" class="colorBirneo" style="text-decoration:none;" title="Voir toutes les notifications"><i class="icon-white icon-share-alt"></i></a></h4></center></li>
                     <li id="notifAGet" style="min-width: 380px;margin-left:10px;margin-bottom:5px;">

                     </li>
                   </ul>
                 </li>
                <li class="dropdown">
                   <a id="messageNavbar" href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b> Messagerie
                    <span id='nbreMessage' class='badge badge-important' style="display:none;"></span></a>
                   <ul class="dropdown-menu">
                    <li align="center" style="border: solid 1px #f0f0f0;margin-bottom:5px;text-align:center;"><center><h4>Vos discussions <a href="../inbox" class="colorBirneo" style="text-decoration:none;" title="Aller à la boîte de réception"><i class="icon-white icon-share-alt"></i></a></h4></center></li>
                    <li id="messageAGet" style="min-width: 250px;margin-left:10px;margin-bottom:5px;">

                    </li> 
                   </ul>
                 </li>
                 <!-- xxxxxxxxxxxxxxxxxxxxxxxxx -->
                <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b> 
                    <?php 
                      echo $my_info[0]["surname"].' '.$my_info[0]["name"];
                      
                    ?>
                  </a>
                   <ul class="dropdown-menu">
                     <li><a href="<?php echo '../profile/'.$my_info[0]["username"]; ?>"><i class="icon-black icon-user"></i> Mon profil</a></li>
                    <!-- <li><a href="<?php echo $link.'inbox'; ?>"><i class="icon-black icon-inbox"></i> Boîte de réception</a></li>-->
                     <li><a href="<?php echo '../portfolio/'.$my_info[0]["username"]; ?>"><i class="icon-black icon-picture"></i> Portfolio</a></li>
                     <li><a href="<?php echo '../themes/'; ?>"><i class="icon-black icon-th"></i> Thèmes</a></li>
                     <li><a href="../support"><i class="icon-black icon-flag"></i> Signaler un problème</a></li>
                     <?php 
                        if($my_info[0]['admin'] == 1)
                        {
                          ?>
                            <li><a href="<?php echo '../adminbirneo?token='.$_SESSION['token']; ?>"><i class="icon-black icon-folder-close"></i> Administration</a></li>
                          <?php
                        } 
                      ?>
                     <!--<li><a href="#notification" role="button" data-toggle="modal"><i class="icon-white icon-eye-open"></i>
                      Notifications
                      <?php 
                       // if(count_notification() >= 1)
                        //{
                         // echo " <span class='badge badge-important'>".count_notification()."</span>";
                        //} 
                      ?>
                    </a></li> -->
                    <li><a href="../logout"><i class="icon-black icon-off"></i> Déconnexion</a></li>

                     <!--<li class="divider"></li>
                     <li class="nav-header">Nav header</li>
                     <li><a href="#">Separated link</a></li>
                     <li><a href="#">One more separated link</a></li>-->
                   </ul>
                 </li>
                 

               
                
              </ul>
             </div><!--/.nav-collapse -->
           </div>
         </div>
       </div>
