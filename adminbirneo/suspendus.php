<?php 
    include("../res/config.php");
    include("../res/secure.php");

    $admin = $bdd->query("SELECT * FROM users WHERE id =:userid",array("userid"=>$_SESSION['userid']));

    if($admin[0]['admin'] == 0)
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
      <title>Administation - Liste des comptes suspendus</title>
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
            <h3>Liste des comptes suspendus</h3>
              <h6><b>Attention !</b> Voici les utilisateurs "ennemis":</h6>
              <ul>
                <li><span  style="margin-right:40px;">COUTURIER AXEL (255) => Exploitation de failles</span> <u>Ne jamais réactiver</u></li>
              </ul>
            </div>
                  <br />
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>Nom du signalé (id)</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              $req = $bdd->query("SELECT * FROM users WHERE suspendu = 1");
              
             
                foreach($req as $data)
                {
                  ?>
                    <tr>
                    <td><a style="color:black;text-decoration:underline;" href="../profile/<?php echo $data['username']; ?>"><?php echo $data['surname'],' ',$data['name'],' ('.$data['id'].')'; ?></a></td>
                    <td><a href="reactiver.php?id=<?php echo $data['id']; ?>&token=<?php echo $_SESSION['token']; ?>" class="btn btn-info">Réactiver</a></td>
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
