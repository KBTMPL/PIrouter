<?php

	exec ("ls /media/", $samba_shares);
	
	$i = 1;
	foreach ($samba_shares as $row) {
		echo($row.' ');
	}
	
?>
