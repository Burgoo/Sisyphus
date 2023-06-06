<?php 
namespace Tests;

interface IUnitTest 
{
    function Initialize();
    function Terminate();
    function Run(); 
}

abstract class UnitTestBase implements IUnitTest
{
    abstract function Initialize();
    abstract function Terminate();

    var $Tests = [];

    function _GenerateString($length)
    {
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }

    public function Run()
    {
        $this->Initialize();

        $arr = get_class_methods($this);
    
        foreach($arr as $key=>$val)
        {
            if ($val == "Terminate" || $val == "Initialize" || substr($val, 0, 1) == "_" || $val == "Run")
            {

            }
            else
            {
                echo "<br/>Executing $val";
                $this->$val();
            }
        }

        $this->Terminate();
    }
}