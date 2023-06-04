<?php

namespace Services;

Interface INotificationService
{
    function Send(string $Message);
}


class EmailNotificationService implements INotificationService
{
    public function Send(string $Message)
    {

    }
}


class SMSNotificationService implements INotificationService
{
    public function Send(string $Message)
    {

    }
}