<?php

/**
 * 
 * Application Class contains all of the application level facilities like
 * 
 * Dependency Injection containers
 *  
 */
class ApplicationService implements \Services\IApplicationService
{
    private $Services;

    function __construct()
    {
        $this->Services = array();        
    }

    public function AddService($ServiceName, $ServiceFactory)
    {
        $this->Services[$ServiceName] = $ServiceFactory;
        return $this;
    }

    public function Resolve($ServiceName) 
    {
        $func = $this->Services[$ServiceName];
        return $func();
    }

    public function Start()  
    {
        
    }

    public function Stop()
    {

    }
}