<?php

interface IDataService
{
    # user
	function GetUserByID(string $UserID);
	function GetUserByLogin(string $LoginID);
	function CreateUser(Data\User $User);
	function UpdateUser(Data\User $User);
	function DeleteUser(Data\User $User);
    
    # role 
	function GetRoleByID(string $RoleID);
	function GetRoleByName(string $Name);	
    function CreateRole(Data\Role $Role);
	function UpdateRole(Data\Role $Role);
	function DeleteRole(Data\Role $Role);

    # user role
	function GetUserRoleByID(string $ID);
	function GetUserRoleByUserID(string $UserID);
	function GetUserRoleByRoleID(string $UserID);

    function CreateUserRole(Data\UserRole $UserRole);
	function UpdateUserRole(Data\UserRole $UserRole);
	function DeleteUserRole(Data\UserRole $UserRole);

    # Token 
    function CreateToken(Data\Token $Token);
	function UpdateToken(Data\Token $Token);
	function DeleteToken(Data\Token $Token);

	function GetTokenByID($ID);
	function GetTokenByTokenKey(string $TokenKey);
	function GetTokenByObjectID(string $ObjectID);
        
}