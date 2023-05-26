<?php

namespace Services;

class RegisterRequest
{
	var $Login;
	var $Email;
	var $Phone;
	var $Password;
}

class RegisterResponse
{

}

class ActivateRequest
{

}

class ActivateResponse
{

}


interface IAuthenticationService
{
	function Register(RegisterRequest $Request);
	function Activate(ActivateRequest $Request);		
}


class AuthenticationService implements IAuthenticationService
{
	public function Register(RegisterRequest $Request)
	{

	}

	function Activate(ActivateRequest $Request)
	{

	}		


}