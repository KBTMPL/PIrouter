<?php

session_start();
if (!isset($_SESSION['login'])) {
    header('LOCATION:index.php');
    die();
}

/*
if(isset($_SESSION['guest'])) {
    die();
}
*/

exec("speedtest --simple --share", $output);
$img = "testoutput.png";

$i = 1;
$j = 1;
foreach ($output as $row) {
    if ($i++ == 4) {
        $url = substr($row, 15);
    }
}

file_put_contents($img, file_get_contents($url));

?>
