<div class="container" style="margin-top: 30px;">
        <div class="row">
          <div class="span3 well" align="center">
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
          <?php 
            if($profile[0]['id'] == $_SESSION['userid'])
            {
          ?>
          <a href="#changeInfo" role="button" data-toggle="modal" class="btn btn-primary btn-block"><i class="icon-white icon-cogs" style="margin-right: 10px;"></i> Paramètres</a><br />
           <?php
            }else
            {
              
            }

           ?>
           <p><a id="profile_photo" href="<?php echo base64_decode($profil[0]['avatar']); ?>"><img align="center" src="<?php echo base64_decode($profil[0]['avatar']); ?>" class="avatar" style="max-width: 150px;display:none;"></a></p>
            
            <span style="font-weight:normal">
             <div class="page-header">
             <h3 align="center" style="margin-top:-20px;margin-bottom:-10px;text-align:center;margin-bottom:4px;"><?php echo $profile[0]['username']; ?></h3>
             <?php 
                  if($profile[0]['online'] == 1)
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
              if($profile[0]['id'] == $_SESSION['userid'])
              {
                ?>

                <div class="page-header">
                    <h3>Ajouter un ami</h3>
                    <?php
                    if(isset($_GET['message']) && $_GET['message'] == "ok")
                    {
                      ?>
                        <p class="badge badge-success">Invitation envoyée</p>
                      <?php
                    }
                    ?>
                    <form id="ajouterAmi" method="POST" action="<?php echo $link; ?>check/ajouterAmiAnonyme.php">
                      <input id="pseudoAmi" name="pseudoAmi" type="text" placeholder="@Nom d'utilisateur" style="margin-bottom: -27px;">
                    </form>
                    <a id="ajouterAmiSubmitAnonyme" class="btn btn-block btn-primary" style="width:82.5%"><i class="icon-white icon-plus"></i> Ajouter</a>
                </div>
                <?php
              }
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
                }
            
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
              ?>
              <div class="commentaire">
                  <a onclick="insertTag('[b]','[/b]','contenu');" class="btn"><i class="icon icon-bold"></i></a>
                  <a onclick="insertTag('[quote]','[/quote]','contenu');" class="btn"><i class="icon icon-comment"></i></a>
                  <a onclick="insertTag('[i]','[/i]','contenu');" class="btn"><i class="icon icon-italic"></i></a>
                  <a onclick="insertTag('[u]','[/u]','contenu');" class="btn" style="padding-top:2px;"><b>U</b></a>
                  <a onclick="insertTag('[color=CouleurEnAnglais]','[/color]','contenu');" class="btn"><i class="icon icon-tint"></i></a>
                  <a onclick="insertTag('[progress=50%]','[/progress]','contenu');" class="btn"><i class="icon icon-tasks"></i></a>
                  <a onclick="insertTag('[vimeo=id_de_la_video]','[/vimeo]','contenu');" class="btn"><img width="16" height="16" src="http://www.birneo.com/assets/img/vimeo-icon.png" /></a>
              </div>
              <form id="publier" align="left">
                <textarea id="contenu" name="contenu" rows="4" style="width: 96%;resize: none;" placeholder="Qu'avez-vous à lui dire ?"></textarea><br />
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
           <h3 align="left">Liste blanche (<?php echo $friends_count; ?>)</h3>
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