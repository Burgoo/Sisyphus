<?php

namespace Handlers;

class ErrorLogService implements \Services\ILogService
{
    private $Config;

    function __construct()
    {
        global $Application;
        $this->Config = $Application->Resolve("\Configuration\IMySqlLogServiceConfiguration");
    }

    public function Write(string $Message, string $Category = "msg")
    {
		$conn = new \mysqli
		(
			$this->Config->DatabaseServer, 
			$this->Config->DatabaseUser, 
			$this->Config->DatabasePassword,
			$this->Config->DatabaseName
		); 
		
		if ($conn->connect_error) {
			/* Use your preferred error logging method here */
			error_log('Connection error: ' . $conn->connect_error);
		}

		$sql = "insert into log (category, message, created) select '{category}', '{message}', current_timestamp;";

		$sql = str_ireplace("{category}", $conn->real_escape_string($Message), $sql); 
		$sql = str_ireplace("{message}", $conn->real_escape_string($Category), $sql); 

        $conn->query($sql);

		if ($conn->query($sql) === FALSE) 
		{
            error_log("Error: " . $sql . $conn->error);
		}		

		$conn->close(); 
    }
}