<div id="changeInfo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Info" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Modifier mes informations</h3>
  </div>
  <div class="modal-body">
    <div id="errorContent">
    </div>
    <a id="changeNameButton" class="btn btn-primary btn-block birneo_unselectable">Modifier mon nom et mon prénom</a>
    <div id="changeName" class="well" align="center" style="display: none;">
      <div id="changeNameReply">
      </div>
      <form id="changeNameForm" method="POST" action="<?php echo $link; ?>check/info_name.php"><input type="text" id="name" name="name" value="<?php echo $profile[0]['name']; ?>" /> <input type="text" id="surname" name="surname" value="<?php echo $profile[0]['surname']; ?>" /><br />
      <div class="pull-right"><a id="sendChangeName" class="btn btn-primary birneo_unselectable">Modifier</a></form> <a id="closeChangeName" class="btn birneo_unselectable">Fermer</a></div><br />
    </div>
    <a id="changeSexButton" class="btn btn-danger btn-block birneo_unselectable">Modifier mon sexe</a>
    <div id="changeSex" class="well" align="center" style="display: none;">
     <div id="changeSexReply">
      </div>
     <form id="changeSexForm" method="POST" action="<?php echo $link; ?>check/info_sex.php">
      <?php if($profile[0]['sex'] == "Homme"){ ?>
        <select id="sex" name="sex">
          <option selected="selected">Homme</option>
          <option>Femme</option>
        </select>
      <?php }else{ ?>
        <select id="sex" name="sex">
          <option>Homme</option>
          <option selected="selected">Femme</option>
        </select>
      <?php } ?>
    <div class="pull-right"><a id="sendChangeSex" class="btn btn-danger birneo_unselectable">Modifier</a></form> <a id="closeChangeSex" class="btn birneo_unselectable">Fermer</a></div><br />
    </div>
    <a id="changeJobButton" class="btn btn-primary btn-block birneo_unselectable">Modifier mon emploi</a>
    <div id="changeJob" class="well" align="center" style="display: none;">
      <div id="changeJobReply">
      </div>
      <form id="changeJobForm" method="POST" action="<?php echo $link; ?>check/info_job.php">
      <textarea type="text" id="job" name="job"><?php echo $profile[0]['job']; ?></textarea>
      <div class="pull-right"><a id="sendChangeJob" class="btn btn-primary birneo_unselectable">Modifier</a></form> <a id="closeChangeJob" class="btn birneo_unselectable">Fermer</a></div><br />
    </div>
    <a id="changeSituationButton" class="btn btn-danger btn-block birneo_unselectable">Modifier ma situation amoureuse</a>
    <div id="changeSituation" class="well" align="center" style="display: none;">
      <div id="changeSituationReply">
      </div>
      <form id="changeSituationForm" method="POST" action="<?php echo $link; ?>check/info_situation.php">
        <input type="text" id="situation" name="situation" value="<?php echo $profile[0]['situation']; ?>" />
      </form>
      <div class="pull-right"><a id="sendChangeSituation" class="btn btn-danger birneo_unselectable">Modifier</a></form> <a id="closeChangeSituation" class="btn birneo_unselectable">Fermer</a></div><br />
    </div>
    <a id="changeDescriptionButton" class="btn btn-primary btn-block birneo_unselectable">Modifier ma description</a>
    <div id="changeDescription" class="well" align="center" style="display: none;">
      <div id="changeDescriptionReply">
      </div>
      <form id="changeDescriptionForm" method="POST" action="<?php echo $link; ?>check/info_description.php">
        <textarea id="description" name="description" class="span5" rows="3"><?php echo $profile[0]['description']; ?></textarea>
      <div class="pull-right"><a id="sendChangeDescription" class="btn btn-primary birneo_unselectable">Modifier</a></form> <a id="closeChangeDescription" class="btn birneo_unselectable">Fermer</a></div><br />
    </div>
    <a id="changePasswordButton" class="btn btn-danger btn-block birneo_unselectable">Modifier mon mot de passe</a>
    <div id="changePassword" class="well" align="center" style="display: none;">
      <div id="changePasswordReply">
      </div>
      <form id="changePasswordForm" method="POST" action="<?php echo $link; ?>check/info_password.php"><input type="password" id="oldpassword" name="oldpassword" placeholder="Ancien mot de passe" /> <input type="password" id="newpassword" name="newpassword" placeholder="Nouveau mot de passe" /><br />
      <div class="pull-right"><a id="sendChangePassword" class="btn btn-danger birneo_unselectable">Modifier</a></form> <a id="closeChangePassword" class="btn birneo_unselectable">Fermer</a></div><br />
    </div>
     <a id="changeAvatarButton" class="btn btn-primary btn-block birneo_unselectable">Modifier ma photo de profil</a>
    <div id="changeAvatar" class="well" align="center" style="display: none;">
      <div id="changeAvatarReply">
      </div>
      <form id="changeAvatarForm" method="POST" enctype="multipart/form-data" action="<?php echo $link; ?>check/avatar.php">
        <input type="file" name="avatar" id="avatar" class="input-block-level">
      <div class="pull-right"><a id="sendChangeAvatar" class="btn btn-danger birneo_unselectable">Modifier</a></form> <a id="closeChangeAvatar" class="btn birneo_unselectable">Fermer</a></div><br />
    </div>
    <a id="changeCoverButton" class="btn btn-danger btn-block birneo_unselectable">Modifier l'arrière-plan de mon profil</a>
    <div id="changeCover" class="well" align="center" style="display: none;">
      <div id="changeCoverReply">
      </div>
      <form id="changeCoverForm" method="POST" enctype="multipart/form-data" action="<?php echo $link; ?>check/fond.php">
        <input type="file" name="avatar" id="avatar" class="input-block-level">
      <div class="pull-right"><a id="sendChangeCover" class="btn btn-danger birneo_unselectable">Modifier</a></form> <a id="closeChangeCover" class="btn birneo_unselectable">Fermer</a></div><br />
    </div>
    <br />
    <?php 
      if($profile[0]['type'] == "public")
      {
        ?>
          <a id="goToAnonymous" class="btn btn-inverse birneo_unselectable" onclick="goToAnonymous();"><i id="infoPop" class="icon-white icon-lock"></i> Passer en profil anonyme</a> <a style='cursor: help;margin-left:50px;' data-placement="left" title="Inviter vos amis !" data-content="Inviter des personnes dans votre liste blanche pour qu'il aient accès à votre profil et vous, au sien."></a>
          <br /><br />
          <a id="removeAnonymous" onclick="goToPublic();"></a>
        <?php
      }else
      {
        ?>
          <a id="goToAnonymous" class="btn btn-inverse birneo_unselectable" onclick="goToAnonymous();"><i class='icon-white icon-user'></i> Votre profil est désormais anonyme !</a> <a id="infoPop" style='cursor: help;margin-left:50px;' data-placement="left" title="Inviter vos amis !" data-content="Inviter des personnes dans votre liste blanche pour qu'il aient accès à votre profil et vous, au sien.">Que faire maintenant ?</a>
          <br /><br />
          <a id="removeAnonymous" class="btn btn-primary" onclick="goToPublic();"><i class='icon-white icon-unlock'></i> Passer en profil public</a>
        <?php
      }
    ?>
  <div class="modal-footer">
    <button data-dismiss="modal" class="btn btn-large pull-right">Fermer</button>
  </div>
</div>
</div>