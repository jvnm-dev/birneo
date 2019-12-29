  <body>
      <?php
        include("skull/navbar.php");
        require "class/profile.php";
        
        $userid = $profile[0]['id'];

        function isAmis($id,$id2){
          global $bdd;
          $req = $bdd->query("SELECT count(*) FROM friends WHERE id_exp=:idun1 AND id_dest=:iddeux1 OR  id_exp=:iddeux2 AND id_dest=:idun2",array(
            "idun1"=>$id,
            "iddeux1"=>$id2,
            "iddeux2"=>$id2,
            "idun2"=>$id
          ));
          $count = $req[0]['count(*)'];
          return $count;
        }

        function isDest($id,$id2)
        {
          global $bdd;
          $req = $bdd->query("SELECT count(*) FROM friends WHERE id_exp=:id AND id_dest=:id2",array("id"=>$id,"id2"=>$id2));
          $count = $req[0]['count(*)'];
          return $count;
        }

        $active = $bdd->query("SELECT * FROM friends WHERE id_exp = :id_exp1 AND id_dest = :id_dest1 AND active = 1 OR id_exp = :id_dest2 AND id_dest = :id_exp2 AND active = 1",array(
            "id_exp1"=>$userid,
            "id_dest1"=>$_SESSION['userid'],
            "id_dest2"=>$_SESSION['userid'],
            "id_exp2"=>$userid
          ));

        if($active[0]['active'] == 1)
        {
          $isActive = 1;
        }else
        {
          $isActive = 0;
        }

        if(isAmis($userid,$_SESSION['userid']) == 0 && $_SESSION['userid'] != $userid)
        {
          ?>
          <div class='container' style='margin-top:-10px;'>
              <div class='well'>
                <div class='alert alert-error'>
                  Accès au profil refusé
                </div>
                  <h1>Ce profil est privé. <a class="btn btn-large btn-primary" href="<?php echo $link; ?>check/demanderPermission.php?username=<?php echo DestroyHTML($_GET['username']); ?>"><i class="icon-white icon-unlock"></i> Demander la permission</a></h1>
                  <p>L'utilisateur que vous recherchez a activé la fonction "anonyme".</p>
                  <p>Vous pouvez <a  style='color:black' href="<?php echo $link; ?>check/demanderPermission.php?username=<?php echo DestroyHTML($_GET['username']); ?>">demander à être dans sa liste blanche*</a>.</p>
                  <p><small>*La "liste blanche" est la liste des utilisateurs permis à accéder à ce profil.</small></p>
              </div>
          
          <?php
        }elseif(isAmis($userid,$_SESSION['userid']) == 1 && $isActive == 1 || $_SESSION['userid'] == $userid) {
          include("profile.anonyme.part2.php");
        }else
        {
          if(isDest($userid,$_SESSION['userid']) == 1)
          {
            ?>
              <div class='container' style='margin-top:-10px;'>
              <div class='well'>
                  <h1>Répondre à la demande d'amitié</h1>
                  <a href="<?php echo $link; ?>check/repondreOuiAnonyme.php?exp=<?php echo $userid; ?>&dest=<?php echo $_SESSION['userid']; ?>" class="btn btn-large btn-primary">Accepter l'invitation</a> <a href="<?php echo $link; ?>check/repondreNonAnonyme.php?exp=<?php echo $userid; ?>&dest=<?php echo $_SESSION['userid']; ?>" class="btn btn-large btn-danger">Refuser l'invitation</a>
              </div>
            <?php
          }else
          {
            ?>
              <div class='container' style='margin-top:-10px;'>
              <div class='well'>
                  <h1>En attente d'une réponse à votre invitation</h1>
                  <p>L'utilisateur que vous recherchez n'a pas encore répondu à votre demande.</p>
              </div>
            <?php
          }
        }
      ?>
      

     <?php include("res/script_profil.php"); ?>
   </body>