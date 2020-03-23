<?php
/************************************************************************************************************************
Creator :       Daniel Dinnie
Date created :  10 October 2008
Script name :   time_diff.class.php

Description :
this script contains a class used to calculate the time difference between points in your script

Function list :
add_point
get_time_diff

Input :
[0] FOLDER_PATH = the path to the root folder, optional
[1] LIB_DIR = the path to the lib directory

Output :

Error code :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/


  // get folder path, folder path is how to get back to the root / htdocs directory, through the folder structure
  if(!defined('FOLDER_PATH'))
    define('FOLDER_PATH' , $_SERVER['DOCUMENT_ROOT'] . '/');

  // define the location of the lib directories
  if(!defined('LIB_DIR'))
    define('LIB_DIR' , FOLDER_PATH . '../lib/');

  // include the mics functions (for time_micro)
//  require_once(LIB_DIR . 'misc/misc.fns.php');


  class cl_time_diff {
    private static $a_values = array();
/************************************************************************************************************************
Creator :       Daniel Dinnie
Date created :  10 October 2008
Function name : fn_add_point

Description :
adds a new point to capture the time

Input :
[0] s_name = the name of the point

Output :

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
    function fn_add_point($s_name) {
      self :: $a_values[$s_name] = hrtime(true);
    }

/************************************************************************************************************************
Creator :       Daniel Dinnie
Date created :  10 October 2008
Function name : fn_get_time_diff

Description :
get the time difference between two points

Input :
[0] s_point_1 = the name of one of the points
[1] s_point_2 = the name of the other point

Output :

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
    function fn_get_time_diff($s_point_1 , $s_point_2) {
      // the reason i did this as opposed to using abs() is because abs() cant always handle numbers with so many digits of precision
      if(array_key_exists($s_point_1 , self :: $a_values) && array_key_exists($s_point_2 , self :: $a_values)) {
        if(self :: $a_values[$s_point_1] > self :: $a_values[$s_point_2]) {
          $value_1 = self :: $a_values[$s_point_2];
          $value_2 = self :: $a_values[$s_point_1];
        } else {
          $value_1 = self :: $a_values[$s_point_1];
          $value_2 = self :: $a_values[$s_point_2];
        }

        return bcsub($value_2 , $value_1 , 6);
      }
	  //Casted values as int's here instead of in the speed.php
		$value_2 = (int)$value_2;
		$value_1 = (int)$value_1;
      return false;
    }
  }
?>