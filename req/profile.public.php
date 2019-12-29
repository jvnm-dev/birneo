  <body>
      <?php

        include("skull/navbar.php");
        require "class/profile.php";
       
      ?>
      <div class="container" style="margin-top: 30px;">
        <div class="row">
          <div class="span3 well" align="center">
          <?php 
            if($profil[0]['id'] == $_SESSION['userid'])
            {
          ?>
          <a href="#changeInfo" role="button" data-toggle="modal" class="btn btn-primary btn-block"><i class="icon-white icon-cogs" style="margin-right: 10px;"></i> Paramètres</a><br />
           <?php
            }else
            {
              
                
              
            }
           ?>
            <?php if($profil[0]['verified'] == 1 && $profil[0]['suspendu'] == 0){ ?> <h4><i class="icon-black icon-ok-sign"></i> <b>Compte certifié</b> <?php }elseif($profil[0]['suspendu'] == 1){
              ?>
                <h4><i class="icon-black icon-eye-close"></i> <b>Compte suspendu</b>
              <?php
            }elseif($profil[0]['CM'] == 1 && $profil[0]['suspendu'] == 0){
	            ?>
	             <h4><b><i class="icon-black icon-star"></i> Community Manager </b>
	            <?php
            }
            
            ?></span></h3>
           <p><a id="profile_photo" data-toggle="lightbox" href="#profile_photoBox"><img align="center" src="<?php echo base64_decode($profil[0]['avatar']); ?>" class="avatar" style="max-width: 150px;display:none;"></a></p>
              <div id="profile_photoBox" class="lightbox hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class='lightbox-content'>
                  <img src="<?php echo base64_decode($profil[0]['avatar']); ?>">
                  <div class="lightbox-caption"><p>Photo de profil de <?php echo $profil[0]['surname'],' ',$profil[0]['name'];  ?></p></div>
                </div>
              </div>
              <div class="page-header">
                <h3 align="center" style="margin-top:-20px;margin-bottom:-10px;text-align:center;margin-bottom:4px;"><?php echo $profil[0]['username']; ?>
                <?php 
                  if($profil[0]['online'] == 1)
                  {
                    ?>
                      <h4 style="color:green"><i class="icon-ok-sign"></i> En ligne</h4>
                    <?php
                  }else
                  {
                    ?>
                      <h4 style="color:red"><i class="icon-remove-sign"></i> Hors ligne</h4>
                    <?php
                  }
                ?>
              </div>
              <?php  
                if($profil[0]['id'] != $_SESSION['userid'])
                {
                  $id_profil = $profil[0]['id'];
                  $amis = $bdd->query("SELECT * FROM friends WHERE id_exp = :userid1 AND id_dest = :idprofil1
                                                            OR    id_dest = :userid2 AND id_exp = :idprofil2",array(
                                                            "userid1"=>$_SESSION['userid'],
                                                            "idprofil1"=>$id_profil,
                                                            "userid2"=>$_SESSION['userid'],
                                                            "idprofil2"=>$id_profil
                                                          ));
                  $amis_count = $bdd->query("SELECT count(*) FROM friends WHERE id_exp = :userid1 AND id_dest = :idprofil1
                                                            OR    id_dest = :userid2 AND id_exp = :idprofil2",array(
                                                            "userid1"=>$_SESSION['userid'],
                                                            "idprofil1"=>$id_profil,
                                                            "userid2"=>$_SESSION['userid'],
                                                            "idprofil2"=>$id_profil
                                                          ));
                  $isAmisVerif1 = $amis_count[0]['count(*)'];
                  $isAmisVerif2 = $amis[0]['active'];
                  if($isAmisVerif1 == 1 AND $isAmisVerif2 == 1)
                  {
                    ?>
                      <p><a id="enleverAmis" onmouseover="enleverAmisOver()" onmouseout="enleverAmisOut()" onclick="removeFriends();" class="btn btn-block disabled" style=""><i class="icon-ok"></i> Amis</a></p>
                    <?php
                  }elseif($isAmisVerif1 == 1)
                  {
                    if($amis[0]['id_exp'] == $_SESSION['userid'])
                    {
                      ?>
                        <p><a class="btn btn-block disabled">Demande envoyée</a></p>
                      <?php
                    }else
                    {
                      ?>
                        <p><a id="acceptOrDecline" onclick="acceptRequestFriends();" class="btn btn-danger" style="width:40%;"><i class="icon-ok"></i> Accepter</a> <a id="Decline" onclick="declineRequestFriends();" class="btn btn-danger" style="width:40%;"><i class="icon-remove"></i> Refuser</a></p>
                      <?php
                    }
                    ?>
                    <?php
                  }else
                  {
                    ?>
                      <p><a id="sendFriendRequest" class="btn btn-block btn-danger" onclick="sendFriendRequest();">Ajouter à mes amis</a></p>
                    <?php
                  }
                }

                if($profil[0]['id'] != $_SESSION['userid'])
                {
                  $idFollowed = $profil[0]['id'];
                  $verifFollowReq = $bdd->query("SELECT count(*) FROM follow WHERE id_followed = :idfollowed AND id_follower = :userid AND type = :zero",array(
                                                  "idfollowed"=>$idFollowed,
                                                  "userid"=>$_SESSION['userid'],
                                                  "zero"=>"0"
                                                ));
                  $verifFollow = $verifFollowReq[0]['count(*)'];
                  if($verifFollow == 0){
                    ?>
                      <a class="btn btn-primary btn-block" onclick="follow(<?php echo $idFollowed; ?>);"><i class="icon-white icon-thumbs-up" style="margin-right: 10px;"></i> Suivre les publications</a><br />
                    <?php
                  }else
                  {
                    ?>
                      <a class="btn btn-primary btn-block" onclick="unfollow(<?php echo $idFollowed; ?>);"><i class="icon-white icon-thumbs-down" style="margin-right: 10px;"></i> Ne plus suivre les publications</a><br />
                    <?php
                  }
                }

                if($profil[0]['id'] != $_SESSION['userid'])
                {
                  ?>
                  <a class="btn btn-danger btn-block" href="<?php echo $link; ?>inbox?envoyerA=<?php echo $profil[0]['username']; ?>"><i class="icon icon-comment"></i> Lui envoyer un message</a><br/>
                  <?php
                }
                ?>
              
              <div class="commentaire">
                  <a onclick="insertTag('[b]','[/b]','contenu');" class="btn"><i class="icon icon-bold"></i></a>
                  <a onclick="insertTag('[quote]','[/quote]','contenu');" class="btn"><i class="icon icon-comment"></i></a>
                  <a onclick="insertTag('[i]','[/i]','contenu');" class="btn"><i class="icon icon-italic"></i></a>
                  <a onclick="insertTag('[u]','[/u]','contenu');" class="btn" style="padding-top:2px;"><b>U</b></a>
                  <a onclick="insertTag('[color=CouleurEnAnglais]','[/color]','contenu');" class="btn"><i class="icon icon-tint"></i></a>
                  <a onclick="insertTag('[progress=50%]','[/progress]','contenu');" class="btn"><i class="icon icon-tasks"></i></a>
                  <a onclick="insertTag('[vimeo=id_de_la_video]','[/vimeo]','contenu');" class="btn" style="padding-bottom:2px;"><img width="16" height="16" src="http://www.birneo.com/assets/img/vimeo-icon.png" /></a>
               </div>
              <form id="publier" align="left">
                <textarea id="contenu" name="contenu" rows="4" style="width: 94%;resize: none;" placeholder="Qu'avez-vous à lui dire ?"></textarea><br />
                <select id="categorie" name="categorie" value="Aucune" placeholder="Catégorie" style="display:none;">
                  <option>Aucune</option>
                  <option>Actualité</option>
                  <option>Humour</option>
                  <option>People</option>
                  <option>Musique</option>
                  <option>Internet</option>
                  <option>Jeux vidéo</option>
                </select>
               <?php
                if($profil[0]['id'] != $_SESSION['userid'])
                {
                  ?>
                    <input id="type" name="type" type="int" value="1" style="display:none;" />
                    <input id="dest" name="dest" type="int" value="<?php echo $profil[0]['id']; ?>" style="display:none;" />
                  <?php
                } 
                
               ?>
                <a id="publierSubmit" class="btn btn-primary birneo_unselectable" style="width: 40.6%;"><i class="icon-white icon-comment pull-left"></i> Dire</a>  <a id="publierVider" class="btn birneo_unselectable" style="width: 40.6%;"><i class="icon-white icon-trash pull-left"></i> Vider</a>
            </form>
            <div class="page-header">
              <h3>Infos personnelles</h1>
            </div>
            <span style="font-weight:normal">
             <h4 align="left">Nom: <?php echo $profil[0]['surname'], " ", $profil[0]['name']; ?></h4>
             <h4 align="left">Sexe: <?php echo $profil[0]['sex']; ?></h4>
             <h4 align="left">Emploi: <?php echo $profil[0]['job']; ?></h4>
             <h4 align="left">Situation: <?php echo $profil[0]['situation']; ?></h4>
             <h4 align="left">Description:<br /> <blockquote><?php echo $profil[0]['description']; ?></blockquote></h4>
            </span>
            <?php  
              $friends_count_dest_req = $bdd->query("SELECT count(*) FROM friends WHERE id_exp = :userid AND active = :un",array("userid"=>$profil[0]['id'],"un"=>"1"));
              $friends_count_exp_req = $bdd->query("SELECT count(*) FROM friends WHERE id_dest = :userid AND active = :un",array("userid"=>$profil[0]['id'],"un"=>"1"));
              $miniature_exp_req = $bdd->query("SELECT * FROM friends WHERE id_exp = :userid AND active = :un LIMIT 3",array("userid"=>$profil[0]['id'],"un"=>"1"));
              $miniature_dest_req = $bdd->query("SELECT * FROM friends WHERE id_dest = :userid AND active = :un LIMIT 3",array("userid"=>$profil[0]['id'],"un"=>"1"));
      
              $friends_count_dest = $friends_count_dest_req[0]['count(*)'];
              $friends_count_exp = $friends_count_exp_req[0]['count(*)'];
              $friends_count = $friends_count_dest + $friends_count_exp;
            ?>
           
           <h3 align="left">Portfolio <small><a href="<?php echo $link; ?>portfolio/<?php echo $profil[0]['username']; ?>" class="btn btn-primary">Voir <i class="icon-arrow-right"></i></a></small></h3>
              <?php 

                $photo_req = $bdd->query("SELECT * FROM photo WHERE id_proprio = :profileid ORDER BY id DESC LIMIT 6",array("profileid"=>$profil[0]['id']));
                    
                foreach($photo_req as $data)
                {

              ?>
                  <img class="img-polaroid" style="max-width: 75px;max-height:75px;" src="<?php echo $link; ?>photo/<?php echo base64_decode($data['name']); ?>" />
              <?php 
                }
              ?> 
           <h3 align="left">Amis (<?php echo $friends_count; ?>)</h3>
           <?php
              foreach($miniature_exp_req as $data)
              {
                $user = $bdd->query("SELECT * FROM users WHERE id=:dataid",array("dataid"=>$data['id_dest']));
                ?>
                  <a href="./<?php echo $user[0]['username']; ?>"><img class="img-polaroid" style="max-width: 75px;max-height:75px;" src="<?php echo base64_decode($user[0]['avatar']); ?>" /></a>
                <?php
              }
              foreach($miniature_dest_req as $data)
              {
                $user = $bdd->query("SELECT * FROM users WHERE id=:dataid",array("dataid"=>$data['id_exp']));
                ?>
                  <a href="./<?php echo $user[0]['username']; ?>"><img class="img-polaroid" style="max-width: 75px;max-height:75px;" src="<?php echo base64_decode($user[0]['avatar']); ?>" /></a>
                <?php
              }
              ?>
                  <a href="<?php echo $link; ?>amis/<?php echo $profil[0]['username']; ?>" class="btn btn-primary btn-block" style="margin-top: 5px;">
                    Voir tous 
                    <?php
                    if($profil[0]['id'] == $_SESSION['userid'])
                    {
                      echo "vos"; 
                    }else
                    {
                      echo "ses";
                    }
                    ?>
                    amis
                  </a>
           
          </div>
          <div class="span8 well">
            <h1>Publications de <?php echo $profil[0]['surname'], " ", $profil[0]['name']; ?></h1><br />
            <div id="toutLeMondePublicationHide" style="display:none;">
              <div id="amisPublication">
                <div class='span5 well'>
                  <?php
                    $getusername = DestroyHTML($_GET['username']);
                    $user = $bdd->query("SELECT * FROM users WHERE id=:dataid",array("dataid"=>$_SESSION['userid']));
                    $receiver = $bdd->query("SELECT * FROM users WHERE username=:getusername",array("getusername"=>$getusername));
                  ?>

                  <?php if($profil[0]['id'] != $_SESSION['userid']){
                    ?>
                                          <h3><img src="<?php echo base64_decode($user[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <?php echo $user[0]['surname']," ",$user[0]['name'], " <i class='icon-black icon-arrow-right'></i> ", $receiver[0]['surname']," ",$receiver[0]['name']; ?></h3>
                    <?php
                  }else{
                    ?>
                                            <h3><img src="<?php echo base64_decode($user[0]['avatar']); ?>" class="img-polaroid" style="max-width: 50px;"> <?php echo $user[0]['surname']," ",$user[0]['name']; ?></h3>
                    <?php
                  } ?>
                  <div id='toutLeMondePublication'>
                  </div>
                  <span class="label label-important">Rafraichissez la page pour pouvoir commenter ou aimer cette publication</span>
                </div>
              </div>
            </div>
            <?php
            
            if(get_publication($id) != 1)
            {
              ?>
              <p><div id="emptyPublication" class="alert alert-error span6">Il n'y a aucune publication.</div></p>
              <?php
            }
             ?>
          </div>
        </div>
        <?php
        if($id == $_SESSION['userid']) { include("modal/change_info.php"); }
      ?>

     <?php include("res/script_profil.php"); ?>
   </body>