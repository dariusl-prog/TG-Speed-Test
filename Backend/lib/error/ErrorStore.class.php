<?php
/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	24 August 2017
Script name :	ErrorStore.class.php

Description :
this script contains a custom error class
with this class we can set and record all the error that take place during script execution
different error types include:
	error = major error, write error to log file display error on screen and stop processing
	warning = minor error (eg user input error), display error to screen
************************************************************************************************************************/


class ErrorStore
{
/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	24 August 2017
Function name :	getErrors

Description :
creates a static array of error messages
and allows you to retrieve it

Input :

Output :
errors = the array with all the error messages

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	public function &getErrors()
	{
		static $errorStore;

		return $errorStore;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	24 August 2017
Function name :	errorSet

Description :
creates a new element in the error array with the variables passed

Input :
[1] message = the error message, default = "", mandatory
[2] type = the type of error, error = minor error , warning = major error, default = error, optional
[3] script = the script where the error occurred, default = "", optional
[4] line = the line where the error occurred, default = "", optional
[5] lineDifference = a number to add to the line number (it just makes it easier, as in most places in my code I need to minus 2 from the actual line number)

Output :

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function errorSet($message , $type = 'error' , $script = '' , $line = 0 , $lineDifference = -2)
	{
		$errors = &ErrorStore :: getErrors();

		$errors[] = array('message' => $message , 'type' => $type , 'script' => $script , 'line' => $line + $lineDifference);
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	24 August 2017
Function name : getMessage

Description :
returns an error message
by default it will return the last error message

Input :
[1] errorNumber = the array index of the error that you want to retrieve, default -1, optional

Output :
either the latest message in the errorStore array
or the message from a specific error

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function getMessage($errorNumber = -1)
	{
		return self :: getBase('message' , $errorNumber);
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	24 August 2017
Function name : getType

Description :
returns an error type
by default it will return the last error type

Input :
[1] errorNumber = the array index of the error that you want to retrieve, default -1, optional

Output :
either the latest type in the errorStore array
or the type from a specific error

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function getType($errorNumber = -1)
	{
		return self :: getBase('type' , $errorNumber);
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	24 August 2017
Function name : getScript

Description :
returns an error script
by default it will return the last error script

Input :
[1] errorNumber = the array index of the error that you want to retrieve, default -1, optional

Output :
either the latest script in the errorStore array
or the script from a specific error

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function getScript($errorNumber = -1)
	{
		return self :: getBase('script' , $errorNumber);
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	24 August 2017
Function name : getLine

Description :
returns an error type
by default it will return the last error line

Input :
[1] errorNumber = the array index of the error that you want to retrieve, default -1, optional

Output :
either the latest line in the errorStore array
or the line from a specific error

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function getLine($errorNumber = -1)
	{
		return self :: getBase('line' , $errorNumber);
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	24 August 2017
Function name : fn_error_get_msg

Description :
returns an error
by default it will return the last error

Input :
[1] errorNumber = the array index of the error that you want to retrieve, default -1, optional

Output :
either the latest in the errorStore array
or a specific error

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	private function getBase($what , $errorNumber = -1)
	{
		$errorStore = &ErrorStore :: getErrors();

		$error = array();

		if(-1 == $errorNumber)
			$error = end($errorStore);
		else
			$error = $errorStore[$errorNumber];

		return $error[$what];
	}
}
?>