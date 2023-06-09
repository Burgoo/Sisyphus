<?php

namespace Services;

interface IApplicationService
{
   function AddService(string $ServiceName, $ServiceInstance);
   function Resolve(string $ServiceName) ;
   function Start();
   function Stop();
}
