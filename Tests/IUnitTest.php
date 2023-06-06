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

    public $Results = [];
    public $Start;
    public $Stop;
    public $TotalTime;

    function _GenerateString($length)
    {
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }

    public function Run()
    {
        $this->Start = new \DateTime();

        $this->Initialize();
        $arr = get_class_methods($this);
        
        foreach($arr as $key=>$val)
        {
            if ($val == "Terminate" || $val == "Initialize" || substr($val, 0, 1) == "_" || $val == "Run")
            {

            }
            else
            {
                $start = date('d-m-y h:i:s');
                $result = $this->$val();
                $stop = date('d-m-y h:i:s');

                $this->Results[$val] = array ("start" => $start, "stop" => $stop, "result" => $result);
            }
        }

        $this->Terminate();

        $this->Stop = new \DateTime();
        $this->TotalTime = $this->Stop->getTimeStamp() - $this->Start->getTimeStamp();
    }
}