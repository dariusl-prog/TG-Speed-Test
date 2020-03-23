<?php
/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	17 July 2010
Script name :	MysqlSingleton.class.php

Description :
this script contains a class to handle all requests to the data base
with wrapper functions to connect and do queries
************************************************************************************************************************/


// include the ErrorStore class, Ini class and Validation class
require_once(LIB_BACKEND_DIR . 'error/ErrorStore.class.php');
require_once(LIB_BACKEND_DIR . 'file/Ini.class.php');
require_once(LIB_BACKEND_DIR . 'validation/InputValidation.class.php');


class MysqlSingleton
{
/************************************************************************************************************************
Class variables :
[1] db = a connection to the data base, private static, default false
[2] storedConfigFile = an optional config file name, if no config name is given the script will pull the name of the application, private static, default ''
[3] storedHost = the host of the mysql server, if no host is given, it will be drawn from the config file, private static, default ''
[4] storedUser_name = the user name of the mysql server, if no user name is given, it will be drawn from the config file, private static, default ''
[5] storedPassword = the password of the mysql server, if no password is given, it will be drawn from the config file, private static, default ''
[6] storedDataBase = the data base of the mysql server, if no data base is given, it will be drawn from the config file, private static, default ''
************************************************************************************************************************/
	private static $db = false;
	private static $storedConfigFile = '';
	private static $storedHost = '';
	private static $storedUserName = '';
	private static $storedPassword = '';
	private static $storedDataBase = '';

	// the constructor is set to private so so nobody can create a new instance using "new"
	private function __construct() {}

	// like the constructor, we make __clone private so nobody can clone the instance
	private function __clone() {}

/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	17 July 2010
Function name :	connect

Description :
creates a connection to the data base, only if there isn't a connect already present

Input :
[1] $config = array, optional
	the keys in the function will be turned into variables, with their corresponding values
	possible keys for the array
	host = the mysql server
	userName = the mysql user name
	password = the mysql password
	dataBase = the data base you want to connect to
	configFile = a config file which will hold the above variables

Output :
false if there is an error creating the data base connection

Error messages :
Config file not found.
Some connection variables are missing.
error returned from mysqli_connect_errno()

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	private function connect($config = array())
	{
		// define errors
		$error1 = 'Config file not found.';
		$error2 = 'Some connection variables are missing.';

		// check if the $db variable is already a resource, if so return true
		if(self :: $db && 0 == self :: $db -> connect_errno)
			return self :: $db;

		// check if any arguments were passed, if so then extract the variables from the array
		if(!empty($config))
		{
			foreach($config as $key => $value)
			{
				switch($key)
				{
					case 'host' :
					case 'user_name' :
					case 'password' :
					case 'data_base' :
					case 'config_file' :
						$$key = $value;

					break;
				}
			}

			unset($key);
			unset($value);
			unset($config);
		}

		// check if the data base info has been sent to the function, if not check the class variables
		if(!isset($host) && InputValidation :: validateNotBlank(self :: $storedHost))
			$host = self :: $storedHost;

		if(!isset($userName) && InputValidation :: validateNotBlank(self :: $storedUserName))
			$userName = self :: $storedUserName;

		if(!isset($password) && InputValidation :: validateNotBlank(self :: $storedPassword))
			$password = self :: $storedPassword;

		if(!isset($dataBase) && InputValidation :: validateNotBlank(self :: $storedDataBase))
			$dataBase = self :: $storedDataBase;

		if(!isset($configFile) && InputValidation :: validateNotBlank(self :: $storedConfigFile))
			$configFile = self :: $storedConfigFile;

		// check if any of the connection variables have not been passed, if so read the mysql.ini file to extract them
		if(!isset($host) && !isset($userName) && !isset($password) && !isset($dataBase))
		{
			// if no config file is set, then look in the document root, and get the name of the project from there
			if(!isset($configFile))
				$configFile = PROG_NAME;

			// create the full path to the config file using the PROG_NAME constant
			$configFullPath = LIB_BACKEND_DIR . 'config/' . $configFile . 'MySQL.ini';

			// check if the config file exists
			if(!file_exists($configFullPath) || !is_file($configFullPath))
			{
				ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

				return false;
			}

			// read the config file, and extract the variables
			$settings = array();

			$ini = new Ini($configFullPath);

			if(!isset($host))
				$settings[] = 'host';

			if(!isset($userName))
				$settings[] = 'userName';

			if(!isset($password))
				$settings[] = 'password';

			if(!isset($dataBase))
				$settings[] = 'dataBase';

			$settings = $ini -> iniGet($settings);

			foreach($settings as $key => $value)
			{
				switch($key) 
				{
					case 'host' :
					case 'userName' :
					case 'password' :
					case 'dataBase' :
						$$key = $value;

					break;
				}
			}

			unset($key);
			unset($value);
			unset($settings);
			unset($ini);
		}

		// check if any of the connection variables are not present, if so set an error and return false
		if(!isset($host) && !isset($userName) && !isset($password) && !isset($dataBase))
		{
			ErrorStore :: errorSet('error' , $error2 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			return false;
		}

		// create a new mysqli connection
		self :: $db = @new mysqli($host , $userName , $password , $dataBase);

		// check for an error after trying to create the connection to the data base, if there was an error set an error
		if(mysqli_connect_errno())
		{
			ErrorStore :: errorSet('error' , mysqli_connect_error() , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($host);
			unset($userName);
			unset($password);
			unset($dataBase);

			return false;
		}

		// set class variables
		if(isset($host))
			self :: $storedHost = $host;

		if(isset($userName))
			self :: $storedUserName = $userName;

		if(isset($password))
			self :: $storedPassword = $password;

		if(isset($dataBase))
			self :: $storedDataBase = $dataBase;

		if(isset($config))
			self :: $storedConfigFile = $config;

		// return the data base connection
		return self :: $db;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	17 July 2010
Function name :	query

Description :
calls all the necessary functions to do a query and extract all the results

Input :
[1] sql = the query you want to do, mandatory
[2] config = array, optional
		the keys in the function will be turned into variables, with their corresponding values
		possible keys for the array
		host = the mysql server
		userName = the mysql user name
		password = the mysql password
		dataBase = the data base you want to connect to
		configFile = a config file which will hold the above variables

Output :
false if there is an error creating the data base connection, else an array of the results

Error messages :
Sql string passed is blank.
Could not connect to data base.

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function query($sql , $config = array())
	{
		// define errors
		$error1 = 'Sql string passed is blank.';
		$error2 = 'Could not connect to data base.';

		// check if the sql string passed is blank, if so set an error and return false
		if(!InputValidation :: validateNotBlank($sql))
		{
			ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			return false;
		}

		// check if there is a data base connection present, if not try to connect
		if(!self :: $db || 0 != self :: $db -> connect_errno)
			self :: connect($config);

		// if there still isn't a data base connection, set an error and return false
		if(!self :: $db || 0 != self :: $db -> connect_errno)
		{
			ErrorStore :: errorSet('error' , $error2 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			return false;
		}

		$returned = array();

		// do the query, get the results and store them in the array $returned
		if(self :: $db -> multi_query($sql))
		{
			do
			{
				if($result = self :: $db -> use_result())
				{
					while($data = $result -> fetch_assoc())
						$returned[] = $data;

					$result -> close();

					unset($result);
				}
			} while(self :: $db -> next_result());
		}

		// return the output
		return $returned;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	07 July 2010
Function name :	closeConnection

Description :
closes the connection to the data base

Input :

Output :

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function closeConnection()
	{
		if(self :: $db && 0 == self :: $db -> connect_errno)
			mysqli_close(self :: $db);

		self :: $db = false;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	07 July 2010
Function name :	getVars

Description :
gets variables from the mysqli class

Input :
[1] varName = the name of the variable being retrieved, mandatory

Output :
the value of the variable

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function getVars($varName)
	{
		// define errors
		$error1 = 'Variable name not recognized.';

		// make sure the variable name passed is one of the variables that have a value
		switch($varName)
		{
			case 'affected_rows' :
			case 'client_info' :
			case 'client_version' :
			case 'connect_errno' :
			case 'connect_error' :
			case 'errno' :
			case 'error' :
			case 'field_count' :
			case 'host_info' :
			case 'info' :
			case 'insert_id' :
			case 'server_info' :
			case 'server_version' :
			case 'sqlstate' :
			case 'protocol_version' :
			case 'thread_id' :
			case 'warning_count' :
				break;

			default :
				ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__ , -1);

				return false;

				break;
		}

		// return the variable
		return self :: $db -> $varName;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	08 September 2017
Function name :	checkInput

Description :
this function checks the input for potentially malicious code
NOTE ********************************************************************************************************************
this function doesn't fully protect against SQL injection hacks
it's a temporary solution that will work currently
this function could be made better if we used a little regX
and also found x = x scenarios
but that isn't necessary for right now
NOTE ********************************************************************************************************************

Input :
[1] input = the input that you want to check, mandatory

Output :
the input with potential errors fixed

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function checkInput($input , $config = array())
	{
		// define errors
		$error1 = 'Variable name not recognized.';

		// before escaping the string
		// we must make sure that there is a connection to the data base
		self :: connect($config);

		// first escape the string
		$input = mysqli_real_escape_string(self :: $db , $input);

		// next remove any semi colons ;
		$input = str_replace(';' , '' , $input);

		// return the fixed input
		return $input;
	}
}
?>