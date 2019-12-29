<?php
  header('Content-type: text/html; charset=utf-8');
  require "res/config.php";
  $bdd->query("SET NAMES 'utf8'");
  require "res/secure.php";
  require "functions/profile.func.php";
  require "req/profile.req.php";
  

 
?>
<!DOCTYPE html>
<html lang="fr">
  <?php 
    include("req/profile.head.php");
  ?>

  <?php 
  switch ($profil[0]['type']) {
    case 'public':
        include("req/profile.public.php");
        include("skull/footer.php");
      break;
    case 'anonyme':
        include("req/profile.anonyme.php");
        include("skull/footer.php");
    break;
    default:
        include("skull/navbar.php");
        ?>
        <div class="container" style="margin-top:40px;">
          <div class="row">
            <div class="alert alert-error">
              <p>Ce profil n'existe pas ou n'existe plus. Veuillez vérifier le lien que vous avez utilisé.</p>
              <p>Contactez le support si le problème persiste, ou si ce compte existait auparavant.</p>
            </div>
          </div>
        </div>
        <?php
        include("res/script_profil.php");
    break;
  }
    
  ?>
</html>
