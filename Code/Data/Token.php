<?php

namespace Data;

class Token
{
	var $ID;
	var $TokenType; # auth, activation, password reset, etc
	var $ObjectID;
	var $TokenKey;
	var $Created;
	var $Updated;
	var $Expires; # when the token will expires in seconds
}