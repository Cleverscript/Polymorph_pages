<?php
class CDatabase {
	protected $connections = array();
	protected $dbName;
	protected $dbUser;
	protected $dbPass;
	protected $dbHost;

	public function __construct(
		string $dbName, 
		string $dbUser, 
		string $dbPass, 
		string $dbHost = '127.0.0.1') 
	{
		$this->dbName = $dbName;
		$this->dbUser = $dbUser;
		$this->dbPass = $dbPass;	
		$this->dbHost = $dbHost;
	}

	public function ConnectToDB(string $pfx) 
	{
		if (in_array($pfx, $this->connections))
		{
			return $this->connections[$pfx];
		}

        try {
			$this->connections[$pfx] = new PDO(
				'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName . '', 
				$this->dbUser, 
				$this->dbPass,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
			);
        }
        catch(PDOException $e) {
            print($e->getMessage());
        }

		return $this->connections[$pfx];
	}
}
?>