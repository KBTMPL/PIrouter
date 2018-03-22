<?php
    session_start();
    if(!isset($_SESSION['login']) or isset($_SESSION['guest'])) {
        header('LOCATION:index.php'); die();
    }

	exec ("sudo poweroff", $output);
?>
