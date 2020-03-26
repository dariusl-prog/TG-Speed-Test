<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/paths.php');
    
    $includeJS_Random_Index = 'y';
    
    $includeJS_frontend = 'n';
    
    include(HTML_DIR . 'header.inc.php');
    
    include(LIB_BACKEND_DIR . '/processing/pl/random_number.php');        
?>

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="site-body">
        <p>Amount of loops to run :<p>
            <div id="search-section">
              	<form name="input_form" method="post" action="speed_frontend.php">
                    <div>                 
                        <input type="number" class="loops-bar" name="loop" placeholder="Amount..." >                 
                    </div>
                        <input type="submit" class="button1" value="Run" >               
                </form>
                <form name="random_button" method="post" action="speed_frontend.php">
                    <input type="hidden" class="button1" value="<?php echo $random_loops ?>" name="loop" >
                    <input type="submit" class="button1" id="but_fill" value="Random" >
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