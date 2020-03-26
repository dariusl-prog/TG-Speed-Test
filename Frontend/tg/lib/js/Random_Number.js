function index_random_number()
{
	var Random = document.getElementById('but_fill');
	
	Random.onclick = function()
	{
  		return Math.floor(Math.random() * (100 - 1) ) + min;
	};
}