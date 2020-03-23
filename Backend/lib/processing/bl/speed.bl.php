<?php
    // require the file with all the paths in it
	require_once($_SERVER['DOCUMENT_ROOT'] . '/paths.php');
	
	require_once(LIB_BACKEND_DIR . 'misc/time_diff.class.php');
	require_once(LIB_BACKEND_DIR . 'db/MysqlSingleton.class.php');

	function query_proc($bodyTextLimit , $blogLimit)
	{
		// create SQL string
		$sql = 'CALL s_get_data();';

		// run the SQL
		$return = MysqlSingleton :: query($sql);

		// return the data
		return $return;
	}
	
	function simple_query_proc($bodyTextLimit , $blogLimit)
	{
		$sql = 'CALL simple_s_get_data();';
		
		$return = MysqlSingleton :: query($sql);
		
		return $return;
	}

	function query_sql($bodyTextLimit , $blogLimit)
	{
		// create SQL string
		$sql = 'SELECT c.name AS "Comp name" , p.name AS "Pro name" , w.name AS "Wigit name" , pw.quantity AS "Wigit quantity" , i.num_in_stock AS "Num stock"
				FROM s_company AS c
				JOIN s_product AS p
				ON c.id = p.ifk_company
				JOIN s_product_wigit AS pw
				ON p.id = pw.ifk_product
				JOIN s_wigit AS w
				ON pw.ifk_wigit = w.id
				JOIN s_inventory AS i
				ON p.id = i.ifk_product;';

		// run the SQL
		$return = MysqlSingleton :: query($sql);

		// return the data
		return $return;
	}
	
	function simple_query_sql($bodyTextLimit , $bloglimit)
	{
		//create SQL string
		$sql = 'SELECT * FROM s_company';
		
		$return = MysqlSingleton :: query($sql);
		
		return $return;
	}

	$iLoops = $_POST['loop'];
	
	//PROC
	cl_time_diff :: fn_add_point('p1');
	for ($iCount=0; $iCount < $iLoops; $iCount++) 
	{
		for ($iCountInner=0; $iCountInner < $iLoops; $iCountInner++) 
		{ 
			query_proc(2000, 10);
		}
	} 
	cl_time_diff :: fn_add_point('p2');
	
	//SQL Query
	cl_time_diff :: fn_add_point('p3');
	for ($iCount=0; $iCount < $iLoops; $iCount++) 
	{
		for ($iCountInner=0; $iCountInner < $iLoops; $iCountInner++) 
		{ 
			query_sql(2000, 10);
		}
	} 
	cl_time_diff :: fn_add_point('p4');
	
	//Simple Query
	cl_time_diff :: fn_add_point('p5');
	for ($iCount=0; $iCount < $iLoops; $iCount++) 
	{
		for ($iCountInner=0; $iCountInner < $iLoops; $iCountInner++) 
		{ 
			simple_query_sql(2000, 10);
		}
	} 
	cl_time_diff :: fn_add_point('p6');
	
	//Simple Proc
	cl_time_diff :: fn_add_point('p7');
	for ($iCount=0; $iCount < $iLoops; $iCount++) 
	{
		for ($iCountInner=0; $iCountInner < $iLoops; $iCountInner++) 
		{ 
			simple_query_proc(2000, 10);
		}
	} 		
	cl_time_diff :: fn_add_point('p8');
	
	$proc = (cl_time_diff :: fn_get_time_diff('p1' , 'p2'))/1e+6;
	$sql = (cl_time_diff :: fn_get_time_diff('p3' , 'p4'))/1e+6;
	$simple_sql = (cl_time_diff :: fn_get_time_diff('p5' , 'p6'))/1e+6;
	$simple_proc = (cl_time_diff :: fn_get_time_diff('p7' , 'p8'))/1e+6;
?>