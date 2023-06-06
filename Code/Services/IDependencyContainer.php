<?php

namespace Services;

interface IDependencyContainer
{
    function AddService($Service);
    function ResolveService($Service);
}