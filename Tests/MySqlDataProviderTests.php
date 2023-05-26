<?php 

$u = new Data\User();
$u->Login = "rbforee";
$u->Email = "email@email.com";
$u->Phone = "3333333333";
$u->PasswordHash = password_hash("thisisatest1234", PASSWORD_DEFAULT);

var_dump($u);

$db = new MySqlDataService();
var_dump($db);

$db->Open();
$u = $db->CreateUser($u);


#
# this is just a simple php to show the php current configuration settings 
#
# phpinfo();
#

$u = $db->GetUserByID($u->ID);
var_dump($u);

$u = $db->GetUserByLogin('rbforee');
var_dump($u);

$u->Email = "newemail@email.com";

$db->UpdateUser($u);


$db->DeleteUser($u);



$r = new Data\Role();
$r->Name = "User";
$db->CreateRole($r);

$r = $db->GetRoleByName("User");


$r->Name = "User 1";
$db->UpdateRole($r);

$db->DeleteRole($r);


$t = new Data\Token();
$t->TokenType = "auth";
$t->TokenKey = "123412341234341";
$t->ObjectID = 1;
$t->Expires = 1800;

$t = $db->CreateToken($t);

$id = $t->ID;

var_dump($id);

$t = $db->GetTokenByID($id);

var_dump($t);

$t = $db->GetTokenByObjectID(1);


var_dump($t);

$db->Close();