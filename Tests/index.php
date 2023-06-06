<?php 

require_once("config.php");

$App = new ApplicationService();

$App->AddService("\Services\ILogService", function() { return new \Handlers\ErrorLogService(); } ) ;
$App->AddService( "\Services\IIdentityDataService", function() { return new \Handlers\MySqlIdentityDataService(); } );

#$App->Start();
#$App->Stop();