<?php
session_start();
/*    
    if(!isset($_SESSION['login'])) {
        header('LOCATION:index.php'); die();
    }
*/


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PImedia</title>

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#343a40">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#343a40">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link rel="stylesheet" href="bootstrap.min.css">
    <link href="style.css" rel="stylesheet">
</head>

<body>

<header id="TOP">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

        <a class="navbar-brand text-success active" href="#TOP">PImedia</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="<?php if (!isset($_SESSION['guest']) && isset($_SESSION['login'])) {
                        echo('text-danger');
                    } elseif (isset($_SESSION['guest']) && isset($_SESSION['login'])) {
                        echo('text-warning');
                    } ?> nav-link active" href="admin.php">PIrouter</a>
                </li>

            </ul>
        </div>
    </nav>
</header>


<main class="container">


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

</script>
</body>
</html>
