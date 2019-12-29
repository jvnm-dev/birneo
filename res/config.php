<?php
	session_start();
	$debug = 0;
 	 
 	$annonce = 
 	"
 	<li>
 		Mise à jour en 1.4.3αυ <a class='btn btn-danger' href='http://birneo.wordpress.com/2013/11/13/mise-a-jour-1-4-3%ce%b1%cf%85-hashtag-vimeo-	bouton-bbcode/' target='_blank'> Voir les modifications</a>
 	</li>
 	<li>
 		La migration a été complétée avec succès !
 	</li>
 	";  
 
 	$link = "../";
	//NE PAS MODIFIER ICI
	
		
	 
	/////////////////////

	if(!isset($_SESSION['userid']) && !isset($index) && !isset($rapport))
	{
		header("location: ../welcome");
	}

	require_once __DIR__ . '/mysql/Db.class.php';
	$bdd = new Db();
	function get_ip_address() 
	{             
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
		        if (array_key_exists($key, $_SERVER) === true){
		            foreach (explode(',', $_SERVER[$key]) as $ip){
		                $ip = trim($ip); // just to be safe

		                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
		                    return $ip;
		                }
		            }
		        }
		    }
	}

	$ip = get_ip_address();
          

	if(isset($_SESSION['userid']))
  	{
	    if(!isset($_SESSION['token']))
	    {
	      $_SESSION['token'] = md5(time()*rand(1440,2560));
	    }
	   	date_default_timezone_set("Europe/Brussels");
	    $time = date("Y-m-d H:i:s");

        $query = $bdd->query("UPDATE users SET last_visite = :ls  WHERE id = :id",array("ls"=> $time,"id"=> $_SESSION['userid']));
        $amIOnline = $bdd->query("SELECT * FROM users WHERE id = :id", array("id"=> $_SESSION['userid']));
        if($amIOnline[0]['online'] == 0)
        {
            $query = $bdd->query("UPDATE users SET online = :stat WHERE id = :id",array("stat"=>"1","id"=> $_SESSION['userid'])); 
        }
		$query = $bdd->query("UPDATE users SET last_visite = :ls  WHERE id = :id",array("ls"=> $time,"id"=> $_SESSION['userid']));
		$limit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
		
		$query = $bdd->query("UPDATE users SET online = :stat WHERE last_visite < :limit",array("stat"=> "0","limit"=> $limit));

		if($amIOnline[0]['suspendu'] == 1 && !isset($rapport))
		{
			header("Location: ../suspendu");
		}

		/*if($amIOnline[0]['admin'] != 1)
		{
			header("Location: ../maintenance");
		}*/

		if(empty($amIOnline[0]['ip']) || $amIOnline[0]['ip'] != $_SERVER['REMOTE_ADDR'])
		{
            $query = $bdd->query("UPDATE users SET ip = :ip WHERE id = :id",array("ip"=> $_SERVER['REMOTE_ADDR'],"id"=> $_SESSION['userid'])); 
		}else {
			$banned_ip_req = $bdd->query("SELECT * FROM banip");
			foreach($banned_ip_req as $row){
				if($row['ip'] == $ip)
				{
					header("Location: ../suspendu");
				}
			}
		}
  	}

  	$version = "Version 1.4.3αυ"; 

  	function DestroyHTML($str) // Fonction de sécurisation du contenu envoyé au serveur lors des requętes (Prévient des failles XSS).
    {
	    $str = htmlspecialchars(stripslashes(nl2br(trim($str))));
	    return $str;
    }

  	class Base{
		public $table;
		public function read($fields=null,$condition=null){
			global $bdd;
			if($fields==null){		$fields = "*";		}
			if($condition ==null) {		$condition = "";	}
			try{
 					$table = $this->table;
					$req = $bdd->query("SELECT * FROM ".$table." WHERE id = :id", array("id"=> $this->id));
    				foreach($req as $i => $v){
					$this->$i = $v;
				}
			}
			catch(Exception $e){
				$e->getMessage();
			}
		}
	}

function logMoiCa($texte,$fichier)
{
	$date = date("Y-m-d").' '.date("H:i:s");
	$file = fopen($fichier, 'a+');
	  
	fwrite($file, $texte." -> ".$date."\n<br/>");
	  
	fclose($file);
}

?>