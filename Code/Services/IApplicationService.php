<?php

interface IApplicationService
{
   function GetDependencyContainer() : \Services\IDependencyContainer;
   function Start();
   function Stop();
}