<?php
// Path: MVC/models/model.php
class Model
{
	public $mysqli;
	private $today;
	
	public function __construct()
	{
		$this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if($this->mysqli->connect_error) 
		{
			$this->logError('model - __construct');
		}
	}

	public function logError($msg = '')
	{
		$this->today = date("n/j/Y g:ia");   
		error_log($this->today . ' Error #: ' . $this->mysqli->connect_errno . ' - ' . $this->mysqli->connect_error . ' - ' . $msg . "\n" , 3, ERR_LOG."db_errors.log");
		exit();
	}

	public function deleteUser($table, $condition, $val) 
	{
		$query = "DELETE FROM ". $table . " WHERE " . $condition . " = " . $val . " LIMIT 1"; 

		if($this->mysqli->query($query)) 
		{
			if($this->mysqli->affected_rows)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$this->logError('model - deleteUser '.$query);
		}		
	}	

	public function insertData($table, $fields, $vals) 
	{
		$column = implode(",", $fields);
		$value = implode(",", $vals);
		$query = "INSERT INTO ". $table . "(" . $column . ") VALUES (" . $value . ")"; 

		if($this->mysqli->query($query)) 
		{
			if($this->mysqli->affected_rows)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$this->logError('model - insertData '.$query);
		}		
	}	
	
	public function checkMatch($table, $field, $val) 
	{
		$query = "SELECT * FROM " . $table . " WHERE " . $field . "= '" . $this->mysqli->real_escape_string($val) . "'";
		
		if($result = $this->mysqli->query($query)) 
		{
			if($result->num_rows)
			{
				return $result->fetch_array();
			}
			else
			{
				return false;
			}
		}
		else
		{
			$this->logError($query);
		}
	}		
	/*
	public function __destruct() 
	{
		$this->mysqli->close();
	}	
	*/
}
?>