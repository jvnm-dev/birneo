<?php
/**
 *  DB - Une classe simple pour votre BDD
 *
 * @author		Author: Vivek Wicky Aswal. (https://twitter.com/#!/VivekWickyAswal)
 * @git 		https://github.com/indieteq-vivek/PHP-MySQL-PDO-Database-Class
 * @version     0.2ab
 * @french      Robot from ibuild.fr 
 *
 */
require("Log.class.php");
class DB
{
	# @object, L'objet PDO
	private $pdo;

	# @object, Objet PDOStatement
	private $sQuery;

	# @array,  Les paramètres pour la base de donnée
	private $settings;

	# @bool ,  Connecté à la base de données
	private $bConnected = false;

	# @object, L'objet pour l'historique des erreurs	
	private $log;

	# @array, Les paramètres de la requête SQL
	private $parameters;
		
       /**
	*   Constructeur de base
	*
	*	1. On instancie la classe Log
	*	2. Connexion à la BDD
	*	3. Création du tableau des paramètres
	*/
		public function __construct()
		{ 			
			$this->log = new Log();	
			$this->Connect();
			$this->parameters = array();
		}
	
       /**
	*	Cette méthode permet la connexion à la BDD
	*	
	*	1. Lecture des infos de settings.ini.php 
	*	2. On mets les infos du fichier settings dans le tableau des paramètres
	*	3. Tentative de connexion à la BDD
	*	4. Si la connexion échoue alors un log est créée et une erreur reportée.
	*/
		private function Connect()
		{
			$this->settings = parse_ini_file("settings.ini.php");
			$dsn = 'mysql:dbname='.$this->settings["dbname"].';host='.$this->settings["host"].'';
			try 
			{
				# Lecture des paramètres du fichier INI
				$this->pdo = new PDO($dsn, $this->settings["user"], $this->settings["password"]);
				$this->pdo->exec("set names utf8");
				# On peut maintenant sauvegarder chaque erreur fatale dans l'historique
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				# Désactive l'émulation des instructions préparées, utilisation des vraies instructions préparées à la place
				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				
				# La connexion a abouti, on règle le booléen à true.
				$this->bConnected = true;
			}
			catch (PDOException $e) 
			{
				# Inscription dans l'historique en cas d'erreur
				echo $this->ExceptionLog($e->getMessage());
				die();
			}
		}
       /**
	*	Chaque fonctions, instructions qui doivent éxécuter différentes requêtes SQL utilisent cette fonction.
	*	
	*	1. SI le script n'est pas connecté à la BDD, alors on se connecte depuis Connect()
	*	2. On prepare la requête avec PDO::prepare
	*	3. Bind des paramètres, paramétrage de la requête
	*	4. On execute la requête
	*	5. En cas d'erreur : on enregistre l'erreur et la requête
	*	6. On remet à zéro les paramètres
	*/	
		private function Init($query,$parameters = "")
		{
		# Connexion à la BDD
		if(!$this->bConnected) { $this->Connect(); }
		try {
				# Préparation de la requête
				$this->sQuery = $this->pdo->prepare($query);
				
				# Ajouter des paramètres à l'ensemble du tableau des paramètres
				$this->bindMore($parameters);

				# On bind les paramètres
				if(!empty($this->parameters)) {
					foreach($this->parameters as $param)
					{
						$parameters = explode("\x7F",$param);
						$this->sQuery->bindParam($parameters[0],$parameters[1]);
					}		
				}

				# On exécute le SQL
				$this->succes 	= $this->sQuery->execute();		
			}
			catch(PDOException $e)
			{
					# Inscription dans l'historique et affichage en direct en cas d'erreur SQL
					echo $this->ExceptionLog($e->getMessage(),$this->sQuery->queryString);
					die();
			}

			# Remise à zéro des paramètres
			$this->parameters = array();
		}
		
       /**
	*	@void 
	*
	*	Ajout d'un paramètre au tableau de paramètres.
	*	@param string $para  
	*	@param string $value 
	*/	
		public function bind($para, $value)
		{	
			$this->parameters[sizeof($this->parameters)] = ":" . $para . "\x7F" . $value;
		}
       /**
	*	@void
	*	
	*	Permet l'ajout de plus de paramètres.
	*	@param array $parray
	*/	
		public function bindMore($parray)
		{
			if(empty($this->parameters) && is_array($parray)) {
				$columns = array_keys($parray);
				foreach($columns as $i => &$column)	{
					$this->bind($column, $parray[$column]);
				}
			}
		}
       /**
	*   	Si la requête SQL contient une instruction SELECT elle retourne un tableau contenant toutes les lignes du jeu de résultats
	*	Si l'instruction SQL est une instruction DELETE, INSERT ou UPDATE elle renvoie le nombre de lignes affectées
	*
	*   	@param  string $query
	*	@param  array  $params
	*	@param  int    $fetchmode
	*	@return mixed
	*/			
		public function query($query,$params = null,$fetchmode = PDO::FETCH_ASSOC)
		{
			$query = trim($query);

			$this->Init($query,$params);

			if (stripos($query, 'select') === 0){
				return $this->sQuery->fetchAll($fetchmode);
			}
			elseif (stripos($query, 'insert') === 0 ||  stripos($query, 'update') === 0 || stripos($query, 'delete') === 0) {
				return $this->sQuery->rowCount();	
			}	
			else {
				return NULL;
			}
		}

		public function lastID(){
	   		return $this->pdo->lastInsertId();
		}

       /**
	*	Retourne un tableau qui représente une colonne du jeu de résultats
	*
	*	@param  string $query
	*	@param  array  $params
	*	@return array
	*/	
		public function column($query,$params = null)
		{
			$this->Init($query,$params);
			$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);		
			
			$column = null;

			foreach($Columns as $cells) {
				$column[] = $cells[0];
			}

			return $column;
			
		}	
       /**
	*	Retourne un tableau qui représente une ligne du jeu de résultats
	*
	*	@param  string $query
	*	@param  array  $params
	*   	@param  int    $fetchmode
	*	@return array
	*/	
		public function row($query,$params = null,$fetchmode = PDO::FETCH_ASSOC)
		{				
			$this->Init($query,$params);
			return $this->sQuery->fetch($fetchmode);			
		}
       /**
	*	Retourne la valeur d'un seul champ / colonne
	*
	*	@param  string $query
	*	@param  array  $params
	*	@return string
	*/	
		public function single($query,$params = null)
		{
			$this->Init($query,$params);
			return $this->sQuery->fetchColumn();
		}
       /**	
	* Écrit l'erreur et la requête dans le journal et renvoie l'exception
	*
	* @param  string $message
	* @param  string $sql
	* @return string
	*/
	private function ExceptionLog($message , $sql = "")
	{
		$exception  = 'Unhandled Exception. <br />';
		$exception .= $message;
		$exception .= "<br /> You can find the error back in the log.";

		if(!empty($sql)) {
			# Ajoute la requête SQL dans l'historique
			$message .= "\r\nRaw SQL : "  . $sql;
		}
			# Inscription du message d'erreur dans l'historique
			$this->log->write($message);

		return $exception;
	}


}

?>