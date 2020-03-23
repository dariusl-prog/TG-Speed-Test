<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/paths.php');
    
    include(HTML_DIR . 'header.inc.php');
?>

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="site-body">
        <p>Amount of loops to run :<p>
            <div id="search-section">
              	<form name="input_form" method="post" action="speed_frontend.php">
                    <div>                 
                        <input type="number" class="loops-bar" name="loop" placeholder="Amount...">                 
                    </div>
                        <input type="submit" class="button1" value="Run">
                </form>
            </div>
    </div>
        <?php
        // the tags for the footer
        include(HTML_DIR . 'footer.inc.php');
        ?>
  </body>
</html>

<!-- <ul>
<li><label><input type="checkbox" name="simple_sql" value="1"><span>Simple SQL</span></label></li>
<li><label><input type="checkbox" name="simple_proc" value="1"><span>Simple Proc</span></label></li>
<li><label><input type="checkbox" name="sql" value="1"><span>SQL</span></label></li>
<li><label><input type="checkbox" name="proc" value="1"><span>Proc</span></label></li>
</ul> -->