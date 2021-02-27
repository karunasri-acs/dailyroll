<?php
include "constants.php";
class Database
{
     
    private $host = HOST;
    private $db_name = DATABASE;
    private $username = USERNAME;
    private $password = PASSWORD;
    public $conn;
     
    public function dbConnection()
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
			//echo"hghgfhg";
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
        //echo"connected" ;
        return $this->conn;
    }
}
?>