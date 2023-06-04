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
	function Authenticate(AuthenticateRequest $Request);		
}

class AuthenticateRequest
{

}

class AuthenticateResponse
{

}


class AuthenticationService implements IAuthenticationService
{
	public function Register(RegisterRequest $Request)
	{

	}

	function Activate(ActivateRequest $Request)
	{

	}		

	function Authenticate(AuthenticateRequest $Request)
	{

	}

}