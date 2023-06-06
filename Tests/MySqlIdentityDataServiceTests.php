<?php 
namespace Tests;

echo "hello";

require_once("IUnitTest.php");

spl_autoload_register(function ($class) {

    include '../code/' . $class . '.php';
});

$Application = new \ApplicationService();

$Application->
    AddService
    (
        "\Configuration\IMySqlIdentityDataServiceConfiguration", 
        function() 
        {  
            $rtrn =  new \Configuration\IMySqlIdentityDataServiceConfiguration (); 
            $rtrn->DatabaseName = "Sisyphus";
            $rtrn->DatabasePassword = "root";
            $rtrn->DatabaseServer = "localhost";
            $rtrn->DatabaseUser = "root";
            return $rtrn;
        }
    )->
    AddService(
        "\Configuration\IMySqlLogServiceConfiguration", 
        function() 
        {  
            $rtrn =  new \Configuration\IMySqlLogServiceConfiguration (); 
            $rtrn->DatabaseName = "Sisyphus";
            $rtrn->DatabasePassword = "root";
            $rtrn->DatabaseServer = "localhost";
            $rtrn->DatabaseUser = "root";
            return $rtrn;
        }
    )->
    AddService("\Services\ILogService", function() { return new \Handlers\MySqlLogService(); } )->
    AddService("\Services\IMySqlIdentityDataService", function() { return new \Handlers\MySqlIdentityDataService(); } );

/**
 * 
 * Smoke test for the MySqlDataService handler
 * 
 */
class MySqlIdentityDataServiceTests extends UnitTestBase
{
    var $db ;
    var $log ; 

    function Initialize()
    {
        global $Application;

        $this->log = $Application->Resolve("\Services\ILogService");
        $this->db = $Application->Resolve("\Services\IMySqlIdentityDataService");
        $this->db->Open();
    }

    function Terminate()
    {
        $this->db->Close();
    }

    function CreateUser()
    {
        $u = new \Data\User();
        $u->Login = "rbforee";
        $u->Email = "email@email.com";
        $u->Phone = "3333333333";
        $u->PasswordHash = password_hash("thisisatest1234", PASSWORD_DEFAULT);
    
        $u = $this->db->CreateUser($u);

        return true;
    }

    function _GenerateRole()
    {
        $r = new \Data\Role();
        $r->Name = $this->_GenerateString(50);
        return $r; 
    }

    function _GenerateUser()
    {
        $u = new \Data\User();
        $u->Login = $this->_GenerateString(10);
        $u->Email = $this->_GenerateString(10) . "@" . $this->_GenerateString(10) . ".com";
        $u->Phone = "3333333333";
        $u->PasswordHash = password_hash("thisisatest1234", PASSWORD_DEFAULT);
        return $u;
    } 

    function _GenerateToken()
    {
        $t = new \Data\Token();
        $t->TokenType = $this->_GenerateString(5); 
        $t->TokenKey = $this->_GenerateString(100);
        $t->ObjectID = 1;
        $t->Expires = 1800;

        return $t;
    }

    function GetUserByID()
    {
        $u = $this->_GenerateUser();
        $u = $this->db->CreateUser($u);    
        $u = $this->db->GetUserByID($u->ID);
        
        return true;
    }


    function GetUserByLoginID()
    {
        $u = $this->_GenerateUser();
        $u = $this->db->CreateUser($u);    
        $u = $this->db->GetUserByLogin($u->Login);

        return true;

    }

    function UpdateUser()
    {
        $u = $this->_GenerateUser();
        $u = $this->db->CreateUser($u);    
        $u->Email = "newemail@email.com";
        $this->db->UpdateUser($u);

        return true;
    }

    function DeleteUser()
    {
        $u = $this->_GenerateUser();
        $u = $this->db->CreateUser($u);    
        $this->db->DeleteUser($u);

        return true;
    }

    function CreateRole()
    {
        $r = $this->_GenerateRole();
        $r = $this->db->CreateRole($r);

        return true;
    }

    function UpdateRole()
    {
        $r = $this->_GenerateRole();
        $r = $this->db->CreateRole($r);
        $r->Name = "User 1";
        $this->db->UpdateRole($r);
        return true;
    }

    function DeleteRole()
    {
        $r = $this->_GenerateRole();
        $r = $this->db->CreateRole($r);
        $this->db->DeleteRole($r);
        return true;
    }

    function CreateToken()
    {
        $t = $this->_GenerateToken();        
        $t = $this->db->CreateToken($t);
        return true;
    }
}


$t = new MySqlIdentityDataServiceTests();

$t->Run();