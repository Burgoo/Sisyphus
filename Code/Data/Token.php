<?php

namespace Data;

class Token
{
	/**
	* Unique id
	*/
	var $ID;	

	/**
	* auth, activation, password reset, etc
	*/
	var $TokenType;

	/**
	* the object id the token is related to, ie user.
	*/
	var $ObjectID; 

	/**
	* public token
	*/
	var $TokenKey;  

	/**
	* created date, used for concurrency
	*/
	var $Created;	

	/**
	* updated date, used for concurrency
	*/
	var $Updated;

	/**
	 * Time in seconds from the Updated date when the token will expire.
	 */
	var $Expires; 
}