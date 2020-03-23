function speed_frontend_startup () 
{
	var Rerun = document.getElementById('but_rerun');

	Rerun.onclick = function()
	{
    	window.location.reload();
	};

	var Back = document.getElementById('but_back');

	Back.onclick = function()
	{
    	window.location.href = 'index.php';	
	};	
}

addToMasterArray(speed_frontend_startup);