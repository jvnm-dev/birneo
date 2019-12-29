<?php 
       /* *
	* Log 			Une classe qui permet la création d'un historique des erreurs PDO / SQL
	* @author		Author: Vivek Wicky Aswal. (https://twitter.com/#!/VivekWickyAswal)
	* @git 			https://github.com/indieteq-vivek/PHP-MySQL-PDO-Database-Class
	* @version      0.1a
	* @french       Robot from ibuild.fr 
	*/
	class Log {
			
		    # @string, Répertoire de l'historique des erreurs
		    	private $path = '/logs/';
			
		    # @void, Constructeur de base, définit le fuseau horaire et le chemin de l'historique des erreurs
			public function __construct() {
				date_default_timezone_set('Europe/Amsterdam');	
				$this->path  = dirname(__FILE__)  . $this->path;	
			}
			
		   /**
		    *   @void 
		    *	Créée l'historique
		    *
		    *   @param string $message contient le message qui sera écrit dans l'historique
		    *	@description:
		    *	 1. Vérification : Si le dossier existe, on continue, sinon on créée un dossier et on rappele l'instruction.
	            *	 2. On vérifie si un log existe déjà.
		    *	 3. Si il n'existe pas, on le met en place dans le dossier logs
		    *	 4. Logname est la date courante(Année - Mois - Jour).
		    *	 5. Si un log existe déjà alors on appel la méthode edit
		    *	 6. La méthode edit modifie le log exitant
		    */	
			public function write($message) {
				$date = new DateTime();
				$log = $this->path . $date->format('Y-m-d').".txt";

				if(is_dir($this->path)) {
					if(!file_exists($log)) {
						$fh  = fopen($log, 'a+') or die("Fatal Error !");
						$logcontent = "Time : " . $date->format('H:i:s')."\r\n" . $message ."\r\n";
						fwrite($fh, $logcontent);
						fclose($fh);
					}
					else {
						$this->edit($log,$date, $message);
					}
				}
				else {
					  if(mkdir($this->path,0777) === true) 
					  {
 						 $this->write($message);  
					  }	
				}
			 }
			
			/** 
			 *  @void
			 *  Elle est appelée si l'historique des erreurs existe
			 *  Modifie l'historique actuel
			 *
			 * @param string $log
			 * @param DateTimeObject $date
			 * @param string $message
			 */
			    private function edit($log,$date,$message) {
				$logcontent = "Time : " . $date->format('H:i:s')."\r\n" . $message ."\r\n\r\n";
				$logcontent = $logcontent . file_get_contents($log);
				file_put_contents($log, $logcontent);
			    }
		}
?>