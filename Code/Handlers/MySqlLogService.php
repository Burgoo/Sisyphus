<?php

namespace Handlers;

class MySqlLogService implements \Services\ILogService
{
    private $config;

    function __construct()
    {
        global $Application;

        $this->config = $Application->Resolve("\Configuration\IMySqlLogServiceConfiguration");
    }

    function Write(string $Message, string $Category) : void    
    {
        error_log($Message);
    }
}