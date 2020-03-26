<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/paths.php');
	
	require_once(LIB_BACKEND_DIR . '/processing/bl/speed.bl.php');
    
    $includeJS_frontend = 'y';
    
    $includeJS_Random_Index = 'n';
	
	include(HTML_DIR . 'header.inc.php');
?>
		<div class="site-body">
			<p>Results :</p>
			<hr>
  			<p>Simple SQL : <?php echo $simple_sql ?></p>
  			<p>Simple Proc : <?php echo $simple_proc ?></p>
  			<hr>
  			<p>SQL : <?php echo $sql ?></p>
  			<p>Proc : <?php echo $proc ?></p>
  			<hr>
  			<p>Loops : <?php echo $iLoops ?></p>
  		  		
  			<div style="text-align: center;">
				<input type="button" class="button1" id="but_rerun"  value="Re-Run" />
        		<input type="button" class="button1" id="but_back" value="Back" >	
				</button>
			</div>
		</div>
		<?php
			// the tags for the footer
			include(HTML_DIR . 'footer.inc.php');
		?>
	</div><!-- overall__container -->
</html>


