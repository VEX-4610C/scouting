<?php
register_shutdown_function( "fatal_handler" );

function fatal_handler() {
}
/**
 *  DB - A simple database class 
 *
 * @author		Author: Vivek Wicky Aswal. (https://twitter.com/#!/VivekWickyAswal)
 * @git 		https://github.com/indieteq/PHP-MySQL-PDO-Database-Class
 * @version      0.2ab
 *
 */
	class Log {
			
		    # @string, Log directory name
		    	private $path = '/logs/';
			
		    # @void, Default Constructor, Sets the timezone and path of the log files.
			public function __construct() {
				//date_default_timezone_set('America/NewYork');	
				$this->path  = dirname(__FILE__)  . $this->path;	
			}
			
		   /**
		    *   @void 
		    *	Creates the log
		    *
		    *   @param string $message the message which is written into the log.
		    *	@description:
		    *	 1. Checks if directory exists, if not, create one and call this method again.
	            *	 2. Checks if log already exists.
		    *	 3. If not, new log gets created. Log is written into the logs folder.
		    *	 4. Logname is current date(Year - Month - Day).
		    *	 5. If log exists, edit method called.
		    *	 6. Edit method modifies the current log.
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
			 *  Gets called if log exists. 
			 *  Modifies current log and adds the message to the log.
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
class DB
{
	# @object, The PDO object
	private $pdo;

	# @object, PDO statement object
	public $sQuery;

	# @array,  The database settings
	private $settings;

	# @bool ,  Connected to the database
	private $bConnected = false;

	# @object, Object for logging exceptions	
	private $log;

	# @array, The parameters of the SQL query
	private $parameters;
		
       /**
	*   Default Constructor 
	*
	*	1. Instantiate Log class.
	*	2. Connect to database.
	*	3. Creates the parameter array.
	*/
		public function __construct()
		{ 			
			$this->log = new Log();	
			$this->Connect();
			$this->parameters = array();
		}
	
       /**
	*	This method makes connection to the database.
	*	
	*	1. Reads the database settings from a ini file. 
	*	2. Puts  the ini content into the settings array.
	*	3. Tries to connect to the database.
	*	4. If connection failed, exception is displayed and a log file gets created.
	*/
		private function Connect()
		{
			$this->settings = parse_ini_file("settings.ini.php");
			//var_dump($this->settings);
			$dsn = 'mysql:dbname='.$this->settings["dbname"].';host='.$this->settings["host"].'';
			try 
			{
				# Read settings from INI file, set UTF8
				$this->pdo = new PDO($dsn, $this->settings["user"], $this->settings["password"], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				# We can now log any exceptions on Fatal error. 
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				# Disable emulation of prepared statements, use REAL prepared statements instead.
				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			
				
				# Connection succeeded, set the boolean to true.
				$this->bConnected = true;
			}
			catch (PDOException $e) 
			{
				# Write into log
				echo $this->ExceptionLog($e->getMessage());
				die();
			}
		}
	/*
	 *   You can use this little method if you want to close the PDO connection
	 *
	 */
	 	public function CloseConnection()
	 	{
	 		# Set the PDO object to null to close the connection
	 		# http://www.php.net/manual/en/pdo.connections.php
	 		$this->pdo = null;
	 	}
		
       /**
	*	Every method which needs to execute a SQL query uses this method.
	*	
	*	1. If not connected, connect to the database.
	*	2. Prepare Query.
	*	3. Parameterize Query.
	*	4. Execute Query.	
	*	5. On exception : Write Exception into the log + SQL query.
	*	6. Reset the Parameters.
	*/	
		private function Init($query,$parameters = "")
		{
		# Connect to database
		if(!$this->bConnected) { $this->Connect(); }
		try {
				# Prepare query
				$this->sQuery = $this->pdo->prepare($query);
				
				# Add parameters to the parameter array	
				$this->bindMore($parameters);

				# Bind parameters
				if(!empty($this->parameters)) {
					foreach($this->parameters as $param)
					{
						$parameters = explode("\x7F",$param);
						$this->sQuery->bindParam($parameters[0],$parameters[1]);
					}		
				}

				# Execute SQL 
				$this->succes 	= $this->sQuery->execute();		
			}
			catch(PDOException $e)
			{
					# Write into log and display Exception
					echo $this->ExceptionLog($e->getMessage(), $query );
					die();
			}

			# Reset the parameters
			$this->parameters = array();
		}
		
       /**
	*	@void 
	*
	*	Add the parameter to the parameter array
	*	@param string $para  
	*	@param string $value 
	*/	
		public function bind($para, $value)
		{	
			$this->parameters[sizeof($this->parameters)] = ":" . $para . "\x7F" . utf8_encode($value);
		}
       /**
	*	@void
	*	
	*	Add more parameters to the parameter array
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
	*   	If the SQL query  contains a SELECT or SHOW statement it returns an array containing all of the result set row
	*	If the SQL statement is a DELETE, INSERT, or UPDATE statement it returns the number of affected rows
	*
	*   	@param  string $query
	*	@param  array  $params
	*	@param  int    $fetchmode
	*	@return mixed
	*/			
		public function query($query,$params = null, $fetchmode = PDO::FETCH_ASSOC)
		{
			$query = trim($query);

			$this->Init($query,$params);

			$rawStatement = explode(" ", $query);
		
			// Which SQL statement is used 
			$statement = strtolower($rawStatement[0]);
			if ( $statement === 'call' || $statement === 'select' || $statement === 'show') {
				return $this->sQuery->fetchAll($fetchmode);
			}
			elseif ($statement === 'insert' ||  $statement === 'update' || $statement === 'delete' ) {
				return $this->sQuery->rowCount();	
			}	

			else {
				return NULL;
			}
		}
		
      /**
       *  Returns the last inserted id.
       *  @return string
       */	
		public function lastInsertId() {
			return $this->pdo->lastInsertId();
		}	
		
       /**
	*	Returns an array which represents a column from the result set 
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
	*	Returns an array which represents a row from the result set 
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
	*	Returns the value of one single field/column
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
		public function getAll($query,$params = null)
		{
			if(!$this->sQuery == null) {
				 $this->sQuery->fetchAll();
				 $this->sQuery->closeCursor();
			}
			$this->Init($query,$params);
			$this->parameters = array();
			return $this->sQuery->fetchAll(PDO::FETCH_ASSOC);
		}
       /**	
	   
	* Writes the log and returns the exception
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
			# Add the Raw SQL to the Log
			$message .= "\r\nRaw SQL : "  . $sql;
		}
			# Write into log
			$this->log->write($message);

		return $exception;
	}			
}
?>
