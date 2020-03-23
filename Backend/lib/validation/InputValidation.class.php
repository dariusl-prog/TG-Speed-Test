<?php
/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	15 November 2007
Class name :	InputValidation.class.php

Description :
this script contains the class with all input validation functions
************************************************************************************************************************/


// include the ErrorStore class
require_once(LIB_BACKEND_DIR . 'error/ErrorStore.class.php');


class InputValidation
{
/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	15 November 2007
Function name :	validateNotBlank

Description :
checks that the length is not 0
if it is it returns false
then based on leftCantBeBlankYN and rightCantBeBlankYN checks to see that not all / some character are not blank
if all are blank then return false

Input :
[1] string = the string that you want to check if its not blank, mandatory
[2] leftCantBeBlankYN = specify if spaces are allowed on the left of the string, 1 = no spaces are allowed, default = 1, optional
[3] rightCantBeBlankYN = specify if spaces are allowed on the right of the string, 1 = no spaces are allowed, default = 1, optional

Output :
true = string in putted is not blank
false = string in putted is blank

Error codes :
Length can't be 0.
First characters can't be blank.
Last characters can't be blank.
All characters can't be blank.

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function validateNotBlank($string , $leftCantBeBlankYN = 'y' , $rightCantBeBlankYN = 'y')
	{
		// define all error needed in this function
		$error1 = 'Length can\'t be 0.';
		$error2 = 'First characters can\'t be blank.';
		$error3 = 'Last characters can\'t be blank.';
		$error4 = 'All characters can\'t be blank.';

		$len = strlen($string);

		// check if the length is 0, if so the s_string is blank
		if(0 == $len)
		{
			ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($len);

			unset($string);
			unset($leftCantBeBlankYN);
			unset($rightCantBeBlankYN);

			return false;
		}

		// check if the left of the string can't be blank
		if('y' == $leftCantBeBlankYN)
		{
			// if left can't be blank, check if the first character is a blank, and if so set an error
			if(' ' == substr($string , 0 , 1))
			{
				ErrorStore :: errorSet('error' , $error2 , $_SERVER['SCRIPT_NAME'] , __LINE__);

				unset($len);

				unset($string);
				unset($leftCantBeBlankYN);
				unset($rightCantBeBlankYN);

				return false;
			}
		}

		// check if the right of the s_string can't be blank
		if('y' == $rightCantBeBlankYN)
		{
			// if right can't be blank, check if the last character is a blank, and if so set an error
			if(' ' == substr($string , $len - 1))
			{
				ErrorStore :: errorSet('error' , $error3 , $_SERVER['SCRIPT_NAME'] , __LINE__);

				unset($len);

				unset($string);
				unset($leftCantBeBlankYN);
				unset($rightCantBeBlankYN);

				return false;
			}
		}

		// iterate through the s_string, and if any character is not a space, return true
		for($i_count = 0; $i_count < $len; $i_count ++)
		{
			if($string[$i_count] != ' ')
			{
				unset($len);

				unset($string);
				unset($leftCantBeBlankYN);
				unset($rightCantBeBlankYN);

				return true;
			}
		}

		// if if made it this far, it must have only found blanks in the s_string, so return an error
		ErrorStore :: errorSet('error' , $error4 , $_SERVER['SCRIPT_NAME'] , __LINE__);

		unset($len);

		unset($string);
		unset($leftCantBeBlankYN);
		unset($rightCantBeBlankYN);

		return false;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	15 November 2005
Function name :	validateEmail

Description :
validates an email address

Input :
[1] email = the email address that you want to validate, mandatory

Output :
true = email address is valid
false = email address is not valid

Error codes :
Email address $email is not valid

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function fn_validate_email($email)
	{
		// define all error needed in this function
		$error1 = 'Email address ' . $email . ' is not valid';

		if(!filter_var($email , FILTER_VALIDATE_EMAIL))
		{
			ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($email);

			return false;
		}

		unset($email);

		return true;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	15 November 2005
Function name :	validateFileName

Description :
this function is used when you want to create a file
it firstly check weather the name you enter is okay (i.e. not blank, no illegal characters etc.)
checks weather the directory you entered exists, and if not, if specified, create the directories that are missing
after that, if specified, it will check if a file already exists by that name

Input :
[1] fileName = file name you want to validate to validate, mandatory
[2] createDirYN = weather to create directories if they don't exist, 'y' = create directories, default = 'n', optional
[3] fileCantExistYN = weather to check if a file already exists by that name, 'y' = check it, default = 'y', optional

Output :
true = file name is valid
false = file name is not valid

Error codes :
Path and file name cant be blank.
Illegal characters in full path or file name ($fileName).
Illegal character in file name ($baseFileName).
File name can't be blank.
Could not create directory ($path).
Directory ($path) doesn't exist.
File ($file) exists and can't be over ridden.

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function validateFileName($fileName , $createDirYN = 'n' , $fileCantExistYN = 'y')
	{
		// define all error needed in this function
		$error1 = 'Path and file name can\'t be blank.';
		$error2 = 'Illegal characters in full path or file name (' . $fileName . ').';
		$error3 = 'Illegal characters in file name (' . $baseFileName . ').';
		$error4 = 'File name can\'t be blank.';
		$error5 = 'Could not create directory (' . $path . ').';
		$error6 = 'Directory (' . $path . ') doesn\'t exist.';
		$error7 = 'File (' . $path . ') already exists and can\'t be over ridden.';

		// check if the file name entered is not blank, if so return error
		if(!self :: check_not_blank($fileName))
		{
			ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($fileName);
			unset($createDirYN);
			unset($fileCantExistYN);

			return false;
		}

		// check for illegal characters in the file name entered, if so return error
		if(preg_match('/\:|\*|\?|\"|\<|\>|\|/' , $fileName))
		{
			ErrorStore :: errorSet('error' , $error2 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($fileName);
			unset($createDirYN);
			unset($fileCantExistYN);

			return false;
		}

		$baseFileName = basename($fileName);

		// check the base file name for more illegal characters, if so return error
		if(preg_match('/\\|\//' , $baseFileName))
		{
			ErrorStore :: errorSet('error' , $error3 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($baseFileName);

			unset($fileName);
			unset($createDirYN);
			unset($fileCantExistYN);

			return false;
		}

		// i can't remember exactly what this does, but its needed for the next if, for file name validation
		$baseFileName = preg_replace('/\./' , '\.' , $baseFileName);

		// after the above replace, check that the base file name is not blank, i don't remember exactly what the second condition is, but if it fails, return error
		if(!check_not_blank($baseFileName) || !preg_match('/' . $baseFileName . '$/' , $fileName))
		{
			ErrorStore :: errorSet('error' , $error4 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($baseFileName);

			unset($fileName);
			unset($createDirYN);
			unset($fileCantExistYN);

			return false;
		}

		// i don't remember exactly what this line is doing, but its needed
		$baseFileName = preg_replace('/\\\./' , '.' , $baseFileName);

		// i think this is replacing any duplicate slashes (/) with a single slash
		$fileName = preg_replace('/(\/){2,}|(\\\){1,}/' , '/' , $fileName);

		$dirs = explode('/' , $fileName);

		$path = '';

		// iterate through each directory, making sure it exists
		foreach($dirs as $dir)
		{
			// check that the "directory" is not the base file name, if so you have iterated through all directories, so stop
			if($dir != $baseFileName)
			{
				$path .= $dir . '/';

				// check if the directory doesn't exist, if it does carry on, if it doesn't either try create or set error
				if(!is_dir($path))
				{
					// check if create s_dir is 1, if so attempt to create the directory, else return error
					if('y' == $createDirYN)
					{
						// attempt to create the directory, if not set an error
						if(!mkdir($path))
						{
							$path = substr($path , 0 , strlen($path) - 1);

							ErrorStore :: errorSet('error' , $error5 , $_SERVER['SCRIPT_NAME'] , __LINE__);

							unset($baseFileName);
							unset($dirs);
							unset($dir);
							unset($path);

							unset($fileName);
							unset($createDirYN);
							unset($fileCantExistYN);

							return false;
						}
					}
					else
					{
						$path = substr($path , 0 , strlen($path) - 1);

						ErrorStore :: errorSet('error' , $error6 , $_SERVER['SCRIPT_NAME'] , __LINE__);

						unset($baseFileName);
						unset($dirs);
						unset($dir);
						unset($path);

						unset($fileName);
						unset($createDirYN);
						unset($fileCantExistYN);

						return false;
					}
				}
			}
		}

		unset($baseFileName);
		unset($dirs);
		unset($dir);
		unset($path);

		// check if the file can't exist
		if('y' == $fileCantExistYN)
		{
			// if the file does exist return an error
			if(file_exists($fileName))
			{
				ErrorStore :: errorSet('error' , $error7 , $_SERVER['SCRIPT_NAME'] , __LINE__);

				unset($fileName);
				unset($createDirYN);
				unset($fileCantExistYN);

				return false;
			}
		}

		unset($fileName);
		unset($createDirYN);
		unset($fileCantExistYN);

		return true;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	06 January 2008
Function name :	validateCharsStrict

Description :
this function checks a given string for illegal characters
its is the most strict and only allows letter (upper and lower case) numbers dashes and underscores (-_)
this function should be used to check fields like user names, passwords etc.

Input :
[1] $string = the string you want to validate

Output :
true = if string does not contain illegal characters
false = if string does contain illegal characters

Error codes :
String ($string) contains illegal characters.

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function fn_validate_chars_strict($string)
	{
		// define all error needed in this function
		$error1 = 'String (' . $string . ') contains illegal characters.';

		if(!preg_match('/^[\w-]+$/' , $string))
		{
			ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($string);

			return false;
		}

		unset($string);

		return true;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	06 January 2008
Function name :	validateCharsModerate

Description :
this function checks a given string for illegal characters
its is the second most strict and only allows letter (upper and lower case) numbers
dashes, underscores, exclamation marks, at symbol, equals, plus, colon, comma and full stop (-_!@=+:,.)
this function should be used to check fields less important than user names, passwords etc.

Input :
[1] $string = the string you want to validate

Output :
true = if string does not contain illegal characters
false = if string does contain illegal characters

Error codes :
String ($string) contains illegal characters.

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function validateCharsModerate($string)
	{
		// define all error needed in this function
		$error1 = 'String (' . $string . ') contains illegal characters.';

		if(!preg_match('/^[\w-!@=+:,.]+$/' , $string))
		{
			ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($string);

			return false;
		}

		unset($string);

		return true;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	06 January 2008
Function name :	fnValidateCharsLenient

Description :
this function checks a given string for illegal characters
its is the second most strict and only allows letter (upper and lower case) numbers
dashes, underscores, exclamation marks, at symbol, equals, plus, colon, comma, full stop, forward slash and back slash (-_!@=+:,./\)
this function should be used to check fields where just about anything goes, like a description of something

Input :
[1] $string = the string you want to validate

Output :
true = if string does not contain illegal characters
false = if string does contain illegal characters

Error codes :
String ($string) contains illegal characters.

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function fnValidateCharsLenient($string)
	{
		// define all error needed in this function
		$error1 = 'String (' . $string . ') contains illegal characters.';

		if(!preg_match('/^[\w-!@=+:,.\/\\\]+$/' , $string)) {
			ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($string);

			return false;
		}

		unset($string);

		return true;
	}
}
?>