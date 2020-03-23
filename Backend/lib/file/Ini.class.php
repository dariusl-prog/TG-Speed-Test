<?php
/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	07 December 2007
Script name :	Ini.class.php

Description :
this script contains the class for reading and writing custom ini files
************************************************************************************************************************/


// include the ErrorStore class
require_once(LIB_BACKEND_DIR . 'error/ErrorStore.class.php');


class Ini
{
/************************************************************************************************************************
Class variables :
[1] $iniFile = the location of the ini file
************************************************************************************************************************/
	private $iniFile;


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	07 December 2007
Function name : __construct

Description :
set the location of the ini file

Input :
[1] iniFile = the location of the ini file, mandatory

Output :
if an error, return false, else return true

Error codes :
Ini file does not exist or is not a file.

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function __construct($iniFile)
	{
		$error1 = 'Ini file (' . $iniFile . ') does not exist or is not a file.';

		// check if the file passed exists and is a file, if so set the class variable else set an error
		if(!file_exists($iniFile) || !is_file($iniFile))
		{
			ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			return false;
		}

		$this -> iniFile = $iniFile;

		return true;
	}


/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	07 December 2007
Function name : iniGet

Description :
gets variables from the ini file

Input :
[1] a_settings = an array of the settings you want to get from the ini file, mandatory

Output :
if there is an error, return false, else return an array of the settings and values requested
the arrays keys will be the settings names and the corresponding values are the values
eg arrray("userName" => "a user name")

Error codes :
Could not open ini file $this -> iniFile.

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function iniGet($settings)
	{
		$error1 = 'Could not open ini file (' . $this -> iniFile . ').';

		if(false === ($file = @fopen($this -> iniFile , 'r')))
		{
			ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($file);

			unset($settings);

			return false;
		}

		// to make life easier, check if a string is passed, if so turn it into an array with one element
		if(!is_array($settings))
			$settings = array($settings);

		$returnSettings = array();

		foreach($settings as $setting)
			$returnSettings[$setting] = '';

		unset($setting);

		// get the total number of settings to look for, to compare later, so you know if you are finished and can exit
		$foundSettings = 0;
		$totalNumberOfSettings = count($settings);
		$stopYN = 'n';

		// check if there are settings to look for
		if($totalNumberOfSettings > 0)
		{
			// read line by line from the file, till there are no more lines or all settings have been found
			while(($line = fgets($file)) && 'n' == $stopYN)
			{
				// check if the line isn't blank, the first character isn't blank and the first two characters aren't /* or //, these instances are reserved for comments
				if('' != $line && '' != substr($line , 0 , 1) && '/*' != substr($line , 0 , 2) && '//' != substr($line , 0 , 2))
				{
					// look for the = in the line and get its position
					if(false !== ($posEquals = strpos($line , '=')))
					{
						// read the setting
						$setting = substr($line , 0 , $posEquals);

						// if the current setting is in the array passed, get its value
						if(in_array($setting , $settings))
						{
							// set its value in the array to be returned
							$returnSettings[$setting] = trim(substr($line , $posEquals + 1));

							$foundSettings ++;

							// check if the total number of settings found so far is equal to the total number of settings to be found, if so stop reading the file
							if($foundSettings == $totalNumberOfSettings)
							{
								$stopYN = 'y';

								break;
							}
						}
					}
				}
			}
		}

		fclose($file);

		unset($setting);
		unset($posEquals);
		unset($line);
		unset($stopYN);
		unset($totalNumberOfSettings);
		unset($foundSettings);
		unset($file);

		unset($settings);

		return $returnSettings;
	}

/************************************************************************************************************************
Creator :		Daniel Dinnie
Date created :	06 January 2008
Function name : iniSet

Description :
sets variables in the ini file

Input :
[1] a_settings_values = an array of the settings and values you want to set in the ini file, mandatory
each element in the array (ie each setting value pair) is made up of a 2 dimensional array
where the keys are "setting" and "value"

Output :
false, if there is an error
true, if all settings values were changed
an array of setting that weren't changed, if the settings weren't found, and thus not changed

Error codes :
Variable: settings_values must be an array of setting and value pairs.
Ini file $this -> iniFile is not writeable.
Could not open ini file $this -> iniFile.

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
	function ini_set($settingsValues)
	{
		$error1 = 'Variable: ' . $settingsValues . ' must be an array of setting and value pairs.';
		$error2 = 'Ini file (' . $this -> iniFile . ') is not writeable.';
		$error3 = 'Could not open ini file (' . $this -> iniFile . ').';

		// to make life easier, check if a string is passed, if so turn it into an array with one element
		if(!is_array($settingsValues))
		{
			ErrorStore :: errorSet('error' , $error1 , $_SERVER['SCRIPT_NAME'] , __LINE__);

			unset($settingsValues);

			return false;
		}

		// get the total number of settings that you are looking for
		$totalNumberOfSettings = count($settingsValues);

		// check if the total number of settings you are looking for is greater than 0, if so process as below, else don't do anything
		if($totalNumberOfSettings > 0)
		{
			// check if the file is writeable, if no set an error
			if(!is_writable($this -> iniFile))
			{
				ErrorStore :: errorSet('error' , $error2 , $_SERVER['SCRIPT_NAME'] , __LINE__);

				unset($totalNumberOfSettings);

				unset($settingsValues);

				return false;
			}

			// attempt to open the file, and if it doesn't open correctly set an error
			if(false === ($file = @fopen($this -> iniFile , 'r+')))
			{
				ErrorStore :: errorSet('error' , $error3 , $_SERVER['SCRIPT_NAME'] , __LINE__);

				unset($file);
				unset($totalNumberOfSettings);

				unset($settingsValues);

				return false;
			}

			$linesInFile = array();

			while($line = fgets($file))
				$linesInFile[] = trim($line);

			unset($line);

			$linesInFileNum = count($linesInFile);

			// get the new number of settings to look for
			$numberOfSettings = count($settingsValues);

			if(0 != $numberOfSettings)
			{
				// go through each line in the array (that came from reading the file)
				for($countOuter = 0; $countOuter < $linesInFileNum; $countOuter ++)
				{
					// go through each of the settings
					for($countInner = 0; $countInner < $numberOfSettings; $countInner ++)
					{
						// check if the setting matches the current lines setting, if so process as below
						if(0 === (strrpos($linesInFile[$countOuter] , $settingsValues[$countInner]['setting'])))
						{
							// edit the current setting in the array
							$linesInFile[$countOuter] = $settingsValues[$countInner]['setting'] . '=' . $settingsValues[$countInner]['value'];

							// take out the setting that was found from the array of settings and values
							if(0 == $countInner)
								$settingsValues = array_splice($settingsValues , 1);
							else if($countInner == $numberOfSettings - 1)
								$settingsValues = array_splice($settingsValues , 0 , $countInner);
							else
								$settingsValues = array_merge(array_splice($settingsValues , 0 , $countInner) , array_splice($settingsValues , $countInner + 1));

							break;
						}
					}

					unset($countInner);
				}

				unset($countOuter);
			}


			$numberOfSettings = count($settingsValues);

			// check if the total number of settings is greater than the new number of settings, if so it means that there is something new to write to the file
			if($totalNumberOfSettings > $numberOfSettings)
			{
				ftruncate($file , 0);
				fseek($file , 0);

				foreach($linesInFile as $line)
				fwrite($file , $line . '\r\n');

				unset($line);

				// update the time modified on the file
				touch($this -> iniFile);
			}

			fclose($file);

			unset($numberOfSettings);
			unset($linesInFileNum);
			unset($linesInFile);
			unset($file);
			unset($totalNumberOfSettings);
		}

		// check if the settings values array has any elements in it, if so return them, else return true
		if(count($settingsValues) > 0)
			return $settingsValues;

		return true;
	}
}
?>