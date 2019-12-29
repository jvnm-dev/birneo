<?php
    include_once("config.php");
    include_once("../functions/profile.func.php");
    $query = $bdd->query("SELECT * FROM users WHERE id='{$_SESSION['userid']}'");
    $dn = $query->fetch();
    $dn['avatar'] = base64_decode($dn['avatar']);

  if(get_publication($_SESSION['userid']) != 1)
  {
    ?>
    <div class="alert alert-error span6">Il n'y a aucune publication.</div>
    <?php
  }
   ?>