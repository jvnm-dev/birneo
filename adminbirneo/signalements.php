<?php 
    include("../res/config.php");
    $bdd->query("SET NAMES 'utf8'");
    include("../res/secure.php");
    if(!$_SESSION['userid'] == 1 || !$_SESSION['userid'] == 2 || !$_SESSION['userid'] == 3)
    {
        header("Location: ../home");
    }else
    {
    if(isset($_SESSION['adminbirneo']) && $_SESSION['adminbirneo'] != '')
    {

    }else
    {
      header("Location: connect.php");
    }
  }
    error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
     <meta charset="utf-8">
      <title>Administation - Liste des signalements</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="shortcut icon" href="../assets/ico/favicon.png">

    <!-- Loading Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="css/flat-ui.css" rel="stylesheet">

    

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body style="margin-left:40px;">
        <?php include("navbar.php"); ?>
          <div class="container">
            <div class="well">
            <?php 
                    if(isset($_GET['message']) && $_GET['message'] == "ok"){
            ?>
            <center><div class="alert alert-success">L'action a bien été exécutée.</div></center>
            <?php
                    } 
            ?>
            <h3>Liste des signalements</h3>

                <p class="lead">Légende:</p>
                <p><span class="label label-success">Ligne d'information</span> : Signalement réglé.</p>
                <p><span class="label label-danger">Ligne d'information</span> : Signalement en attente.</p>
                <p><span class="label label-warning">Ligne d'information</span> : Signalement pardonné.</p>
                <p>Nom du signalé (id) : Le nom complet de la personne qui a été signalé et l'id de cette personne entre parenthèses.</p>
                <p>Infraction du signalé : Contenu qui a été signalé (publication, commentaire, photo).</p>
                <p>Type de l'infraction (id) : Le premier chiffre est soit 1, 2 ou 3. 1 = Publication; 2 = Commentaire; 3 = photo. Et entre parenthèses, l'id de la publication/du commentaire/de la photo.</p>
                <p>Nom du signaleur (id) : Le nom complet de la personne qui a envoyé le signalement et l'id de cette personne entre parenthèses.</p>
                <p>
                    Action : <li>Réagir vous redirige vers une page vous donnant plusieurs choix de sanctions, ...</li>
                             <li>Pardonner rend la ligne bleue et sera vérifiée par un administrateur.</li>
                </p>
            </div>
                  <br />
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nom du signalé (id)</th>
                  <th>Infraction du signalé</th>
                  <th>Type de l'infraction (id)</th>
                  <th>Nom du signaleur (id)</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              $req = $bdd->query("SELECT * FROM signalement ORDER BY regler ASC");
              foreach($req as $data)
              {
                $type = $data['type'];
                $signaler = $bdd->query("SELECT * FROM users WHERE id = :dataidposter",array("dataidposter"=>$data['id_poster']));
                $signaleur = $bdd->query("SELECT * FROM users WHERE id = :datasignalerpar",array("datasignalerpar"=>$data['signalerPar']));
                if($type == 1)
                {
                  $infractionResult = $bdd->query("SELECT * FROM posts WHERE id=:dataidpost",array("dataidpost"=>$data['id_post']));
                  $infraction = $infractionResult[0]['content'];
                }elseif($type == 2)
                {
                  $infractionResult = $bdd->query("SELECT * FROM comments WHERE id=:dataidpost",array("dataidpost"=>$data['id_post']));
                  $infraction = $infractionResult[0]['content'];
                }else
                {
                  $infraction = $data['id_post']." type non reconnu";
                }
                if ($data['regler'] == 0) {
                  $class="class='danger'";
                }elseif($data['regler'] == 1)
                {
                  $class="class='success'";
                }else
                {
                  $class="class='warning'";
                }

                ?>
                  <tr <?php echo $class; ?>>
                  <td style="color:black;"><?php echo $data['id'] ?></td>
                  <td><a style="color:black;text-decoration:underline;" href="../profile/<?php echo $signaler[0]['username']; ?>"><?php echo $signaler[0]['surname'],' ',$signaler[0]['name'],' ('.$data['id_poster'].')'; ?></a></td>
                  <td style="color:black;"><?php echo $infraction; ?></td>
                  <td style="color:black;"><?php echo $data['type'],' (',$data['id_post'].')'; ?></td>
                  <td style="color:black;"><a style="color:black;text-decoration:underline;" href="../profile/<?php echo $signaleur[0]['username']; ?>"><?php echo $signaleur[0]['surname'],' ',$signaleur[0]['name'],' ('.$data['signalerPar'].')'; ?></a></td>
                  <td style="color:black;"><?php if($data['regler'] == 0){ ?><a class="btn btn-primary" href="punish.php?id=<?php echo $signaler[0]['id']; ?>&affaire=<?php echo $data['id']; ?>">Fiche informative</a> <?php }else{ ?><a class="btn btn-primary" target="_blank" href="../rapport/<?php echo $data['id']; ?>">Rapport</a><?php } ?></td>
                  </tr>
                <?php
              }
            ?>
                
              </tbody>
            </table>
          </div>

    <!-- Load JS here for greater good =============================-->
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script src="js/flatui-checkbox.js"></script>
    <script src="js/flatui-radio.js"></script>
    <script src="js/jquery.tagsinput.js"></script>
    <script src="js/jquery.placeholder.js"></script>
  </body>
</html>
