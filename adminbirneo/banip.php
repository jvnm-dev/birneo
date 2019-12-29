<?php 

    require("../res/config.php");

    $id = DestroyHTML($_GET['id']);
    $signalement = DestroyHTML($_GET['signalement']);

    $ip_req = $bdd->query("SELECT * FROM users WHERE id=:id",array("id"=>$id));
    $ip = $ip_req[0]['ip'];

    $bdd->query("INSERT INTO banip(ip,id_membre) 
                             VALUES (:ip,:id)",array("ip"=>$ip,"id"=>$id));

    $bdd->query("UPDATE users SET suspendu = 1 WHERE id=:id",array("id"=>$id));

    $bdd->query("UPDATE signalement SET regler = 1 WHERE id=:signalement",array("signalement"=>$signalement));
    $texte = "L'admin ou modérateur qui porte l'id \"".$_SESSION['userid']."\" a ban ip le compte de l'utilisateur portant l'id \"".$id."\"";
            logMoiCa($texte,"../logs/admin.txt");
    
    

    

    header("Location: ./signalements.php?message=ok");

?>