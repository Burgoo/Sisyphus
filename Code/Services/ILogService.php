<?php

namespace Services;

interface ILogService 
{
    function Write(string $Message, string $Category) : void;
}