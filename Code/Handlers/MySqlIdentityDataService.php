<?php

namespace Handlers;

/*

every record requires a key to be used for updates and deletes

*/
class MySqlIdentityDataService implements \Services\IIdentityDataService
{
	private $conn ;  
	private $Config;
	private $Log;

	function __construct()
	{
		global $Application;

		$this->Config = $Application->Resolve("\Configuration\IMySqlIdentityDataServiceConfiguration");
		$this->Log = $Application->Resolve("\Services\ILogService");
	}

	private function _LogError()
	{
		$this->Log->Write('Connection error: ' . $this->conn->connect_error, "SQL Error");
	}

	public function Open()
	{
		$this->conn = new \mysqli
		(
			$this->Config->DatabaseServer, 
			$this->Config->DatabaseUser, 
			$this->Config->DatabasePassword,
			$this->Config->DatabaseName
		); 
		
		if ($this->conn->connect_error) 
		{
			$this->_LogError(); 
		}
	}

	public function Close()
	{
		$this->conn->close();
	}

	public function GetUserByID(string $ID)
	{		
		$sql = "select * from users where id = {ID}";

		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($ID), $sql); 

		$result = $this->conn->query($sql);

		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		$rtrn = $result->fetch_object("Data\User");
		
		return $rtrn;
	}

	public function GetUserByLogin(string $Login)
	{
		$sql = "select * from users where Login = '{Login}'";
		$sql = str_ireplace("{Login}", $this->conn->real_escape_string($Login), $sql); 

		$result = $this->conn->query($sql);

		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		$rtrn = $result->fetch_object("Data\User");
		
		return $rtrn;
	}

	public function CreateUser(\Data\User $User)
	{
		$sql = "insert into Users (Login, Phone, Email, PasswordHash, Created) select '{Login}', '{Phone}', '{Email}', '{PasswordHash}', current_timestamp";

		$sql = str_ireplace("{Login}", $this->conn->real_escape_string($User->Login), $sql); 
		$sql = str_ireplace("{Phone}", $this->conn->real_escape_string($User->Phone), $sql); 
		$sql = str_ireplace("{Email}", $this->conn->real_escape_string($User->Email), $sql); 
		$sql = str_ireplace("{PasswordHash}", $this->conn->real_escape_string($User->PasswordHash), $sql); 

		$result = $this->conn->query($sql);

		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		return $this->GetUserByID($this->conn->insert_id);
	}

	public function UpdateUser (\Data\User $User)
	{
		$sql = "update users 
		set 
			Login = '{Login}',
			Phone = '{Phone}',
			Email = '{Email}',
			PasswordHash = '{PasswordHash}',
			Updated = current_timestamp
		where ID = {ID}";
		
		$sql = str_ireplace("{Login}", $this->conn->real_escape_string($User->Login), $sql); 
		$sql = str_ireplace("{Phone}", $this->conn->real_escape_string($User->Phone), $sql); 
		$sql = str_ireplace("{Email}", $this->conn->real_escape_string($User->Email), $sql); 
		$sql = str_ireplace("{PasswordHash}", $this->conn->real_escape_string($User->PasswordHash), $sql); 
		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($User->ID), $sql); 

		$result = $this->conn->query($sql);

		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		return $this->GetUserByID($User->ID);
	}

	public function DeleteUser (\Data\User $User)
	{
		$sql = "update users 
		set Deleted = current_timestamp
		where ID = {ID}";
		
		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($User->ID), $sql); 
		
		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}
	}

	public function GetRoleByID(string $ID)
	{
		$sql = "select * from roles where id = {ID}";

		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($ID), $sql); 

		$result = $this->conn->query($sql);		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		$rtrn = $result->fetch_object("Data\Role");
		
		return $rtrn;
	}

	public function GetRoleByName(string $Name)
	{
		$sql = "select * from roles where Name = '{Name}'";

		$sql = str_ireplace("{Name}", $this->conn->real_escape_string($Name), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		$rtrn = $result->fetch_object("Data\Role");
		
		return $rtrn;
	}
	
    public function CreateRole(\Data\Role $Role)
	{
		$sql = "insert into Roles (Name, Created) select '{Name}', current_timestamp";

		$sql = str_ireplace("{Name}", $this->conn->real_escape_string($Role->Name), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		return $this->GetRoleByID($this->conn->insert_id);
	}

	public function UpdateRole(\Data\Role $Role)
	{
		$sql = "update roles 
		set 
			Name = '{Name}',
			Updated = current_timestamp
		where ID = {ID}";
		
		$sql = str_ireplace("{Name}", $this->conn->real_escape_string($Role->Name), $sql); 
		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($Role->ID), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		return $this->GetRoleByID($Role->ID);
	}

	public function DeleteRole(\Data\Role $Role)
	{		
		$sql = "update roles 
		set Deleted = current_timestamp
		where ID = {ID}";
		
		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($Role->ID), $sql); 
		
		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		return $result;
	}

    function CreateUserRole(\Data\UserRole $UserRole)
	{
		$sql = "insert into User_Roles (UserID, RoleID, Created) select {UserID}, {RoleID}, current_timestamp";

		$sql = str_ireplace("{UserID}", $this->conn->real_escape_string($UserRole->UserID), $sql); 
		$sql = str_ireplace("{RoleID}", $this->conn->real_escape_string($UserRole->RoleID), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}		
		
		return $this->GetUserRoleByID($this->conn->insert_id);
	}
	
	function UpdateUserRole(\Data\UserRole $UserRole)
	{
		$sql = "update user_roles 
		set 
			UserID = {UserID},
			RoleID = {RoleID}
			Updated = current_timestamp
		where ID = {ID}";
		
		$sql = str_ireplace("{UserID}", $this->conn->real_escape_string($UserRole->UserID), $sql); 
		$sql = str_ireplace("{RoleID}", $this->conn->real_escape_string($UserRole->RoleID), $sql); 
		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($UserRole->ID), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		return $this->GetUserRoleByID($UserRole->ID);
	}

	function DeleteUserRole(\Data\UserRole $UserRole)
	{
		$sql = "update userroles 
		set Deleted = current_timestamp
		where ID = {ID}";
		
		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($UserRole->ID), $sql); 
		
		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		return true;
	}

	function GetUserRoleByID(string $ID)
	{
		$sql = "select * from userroles where id = {ID}";

		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($ID), $sql); 

		$result = $this->conn->query($sql);

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		$rtrn = $result->fetch_object("Data\Role");

		return $rtrn;
	}
	
	function GetUserRoleByUserID(string $UserID)
	{
		$sql = "select * from userroles where Name = {Name}";

		$sql = str_ireplace("{UserID}", $this->conn->real_escape_string($UserID), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		$rtrn = $result->fetch_object("\Data\Role");
		
		return $rtrn;
	}

	function GetUserRoleByRoleID(string $RoleID)
	{
		$sql = "select * from userroles where RoleID = {RoleID}";

		$sql = str_ireplace("{RoleID}", $this->conn->real_escape_string($RoleID), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		$rtrn = $result->fetch_object("\Data\Role");
		
		return $rtrn;
	}

	function CreateToken(\Data\Token $Token)
	{
		$sql = "insert into Tokens (TokenType, ObjectID, TokenKey, Expires, Created, Updated) 
		select '{TokenType}', {ObjectID}, '{TokenKey}', DATE_ADD(current_timestamp, INTERVAL {Expires} second) , current_timestamp, Current_timestamp";

		$sql = str_ireplace("{TokenType}", $this->conn->real_escape_string($Token->TokenType), $sql); 
		$sql = str_ireplace("{ObjectID}", $this->conn->real_escape_string($Token->ObjectID), $sql); 
		$sql = str_ireplace("{TokenKey}", $this->conn->real_escape_string($Token->TokenKey), $sql); 
		$sql = str_ireplace("{Expires}", $this->conn->real_escape_string($Token->Expires), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		return $this->GetTokenByID($this->conn->insert_id);
	}

	function UpdateToken(\Data\Token $Token)
	{
		$sql = "update Tokens 
		set 
			TokenType = '{TokenType}',
			ObjectID = {ObjectID},
			TokenKey = '{TokenKey}',
			Expires = '{Expires}',
			Updated = current_timestamp
		where ID = {ID}";

		$sql = str_ireplace("{TokenType}", $this->conn->real_escape_string($Token->TokenType), $sql); 
		$sql = str_ireplace("{ObjectID}", $this->conn->real_escape_string($Token->ObjectID), $sql); 
		$sql = str_ireplace("{TokenKey}", $this->conn->real_escape_string($Token->TokenKey), $sql); 
		$sql = str_ireplace("{Expires}", $this->conn->real_escape_string($Token->Expires), $sql); 
		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($Token->ID), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		return $this->GetTokenByID($Token->ID);
	}

	function DeleteToken(\Data\Token $Token)
	{
		$sql = "update Tokens 
		set Deleted = current_timestamp
		where ID = {ID}";
		
		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($Token->ID), $sql); 
		
		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		return true;

	}
	
	function GetTokenByID($ID)
	{
		$sql = "select * from Tokens where ID = {ID}";

		$sql = str_ireplace("{ID}", $this->conn->real_escape_string($ID), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		$rtrn = $result->fetch_object("\Data\Token");
		
		return $rtrn;
	}

	function GetTokenByTokenKey(string $TokenKey)
	{
		$sql = "select * from Tokens where TokenKey = '{TokenKey}'";

		$sql = str_ireplace("{TokenKey}", $this->conn->real_escape_string($TokenKey), $sql); 

		$result = $this->conn->query($sql);
		
		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		$rtrn = $result->fetch_object("Data\Token");
		
		return $rtrn;
	}

	function GetTokenByObjectID(string $ObjectID)
	{
		$sql = "select * from Tokens where ObjectID = '{ObjectID}'";

		$sql = str_ireplace("{ObjectID}", $this->conn->real_escape_string($ObjectID), $sql); 

		$result = $this->conn->query($sql);

		if ($result === false)
		{
			$this->_LogError(); 
			return false;
		}

		$rtrn = $result->fetch_object("Data\Token");

		return $rtrn;
	}
}