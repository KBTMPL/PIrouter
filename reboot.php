<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('LOCATION:index.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv='refresh' content='45; url=admin.php'>

    <title>PIrouter</title>

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#343a40">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#343a40">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link rel="stylesheet" href="bootstrap.min.css">
    <link href="style.css" rel="stylesheet">
</head>

<body onload="fcall('rbt.php')">

<header id="TOP">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#TOP">PIrouter</a>
    </nav>
</header>

<main class="container">

    <h3 class="mt-5 text-center">PIrouter</h3>

    <h6 class="mt-5 text-center">urządzenie uruchamia się ponownie</h6>

    <div class="progress">
        <div id="dynamic" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
            <span id="current-progress"></span>
        </div>
    </div>

    <?php if (isset($_SESSION['guest'])) {
        echo('<h6 class="mt-5 text-center">w trybie gościa nie :)</h6>');
    } ?>

</main>

<footer class="footer">
    <div class="container">
        <span class="text-muted"><a class="text-muted" target="_blank" href="https://github.com/KBTMPL/PIrouter">PIrouter</a> - Krzysztof Bulanda 2018</span>
    </div>
</footer>

<script src="jquery-3.3.1.js"></script>
<script src="popper.min.js"></script>
<script src="bootstrap.min.js"></script>
<script>
    function fcall(file) {
        setTimeout(function () {
            //kod
        }, 3000);
        $.get(file);
        return false;
    }

    $(function () {
        var current_progress = 0;
        var interval = setInterval(function () {
            current_progress += 5;
            $("#dynamic")
                .css("width", current_progress + "%")
                .attr("aria-valuenow", current_progress)
                .text(current_progress + "%");
            if (current_progress >= 100)
                clearInterval(interval);
        }, 2000);
    });
</script>
</body>
</html>
