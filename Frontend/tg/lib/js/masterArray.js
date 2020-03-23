/************************************************************************************************************************
this array will be used in the following two functions (add_to_master_array and master_window_loader)
its purpose is to hold all the functions that need to be run when the page is loaded, in order
************************************************************************************************************************/
masterLoaderArray = new Array();


/************************************************************************************************************************
Creator :       Daniel Dinnie
Date created :  25 August 2008
Function name : add_to_master_array

Description :
adds functions to the master loader array

Input :
[0] the_func = the name function you want to add to the master array

Output :

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
function addToMasterArray(theFunction , theArguments)
{
	var masterLoaderArrayLength = masterLoaderArray.length;

	masterLoaderArray[masterLoaderArrayLength] = {};

	masterLoaderArray[masterLoaderArrayLength]['function'] = theFunction;

	if(undefined == theArguments)
		masterLoaderArray[masterLoaderArrayLength]['arguments'] = {};
	else if('array' != typeof(theArguments))
		masterLoaderArray[masterLoaderArrayLength]['arguments'] = new Array(theArguments);
	else
		masterLoaderArray[masterLoaderArrayLength]['arguments'] = theArguments;
}


/************************************************************************************************************************
Creator :       Daniel Dinnie
Date created :  25 August 2008
Function name : master_window_loader

Description :
calls all the functions in the master loader array

Input :
[0] the_func = the name function you want to add to the master array

Output :

Error codes :

Assumptions :

Limitations :

Change log :
************************************************************************************************************************/
function masterWindowLoader()
{
	var masterLoaderArrayLength = masterLoaderArray.length;

	for(var count = 0; count < masterLoaderArrayLength; count ++)
	{
		theFunction = masterLoaderArray[count]['function'];
		theArguments = masterLoaderArray[count]['arguments'];

		theFunction.apply(this , theArguments);
	}
}

// add an event so the master_window_loader function is run once the page is loaded
jQuery(document).ready(function($){masterWindowLoader();});