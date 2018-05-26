<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('LOCATION:index.php');
    die();
}

if (!isset($_SESSION['guest'])) {
    exec('sudo reboot', $output);
}
?>