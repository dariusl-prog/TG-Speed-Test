<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/paths.php');
	
	require_once(LIB_BACKEND_DIR . '/processing/bl/speed.bl.php');
	
	//$proc = (int)$proc;
	//$sql = (int)$sql;
	
	echo 'Proc : '. $proc/1e+6 . '<br />';
	echo 'Simple Proc : '. $simple_proc/1e+6 . '<br />';
	echo '---------<br />';
	echo 'SQL : '. $sql/1e+6 . '<br />';
	echo 'Simple SQL : '. $simple_sql/1e+6 . '<br />';
	echo '---------<br />';
	echo 'Loops : '. $iLoops;
		
?>
<br />
<br />
<input type="button" value="Re-Run" onClick="window.location.reload();"/>
<button onclick="window.location.href = 'index.php'">
	Back	
</button>
