<?php

	exec ("fping -t 200 149.156.114.3", $ping_res);
		
	$pattern = "149.156.114.3 is alive";
	$string = "";
	
	foreach ($ping_res as $val) {
				$string .= $val;
			}
	
	// if ($pattern == $string) { echo('<div id="test_src" class="alert alert-info text-center">Router posiada połączenie z internetem</div>');  } else { echo('<div id="test_src" class="alert alert-danger text-center">Router nie posiada połączenia z internetem</div>'); }
	if ($pattern == $string) { echo('1'); } else { echo('0'); }
?>
