<?php
    session_start();
    if(!isset($_SESSION['login'])) {
        header('LOCATION:index.php'); die();
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

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
				<div id="dynamic" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
					<span id="current-progress"></span>
				</div>
			</div>
	   
		<?php /* if(isset($_SESSION['guest'])) { echo('<h6 class="mt-5 text-center">w trybie gościa nie :)</h6>'); } */ ?>
		
</main>

	<footer class="footer">
		<div class="container">
			<span class="text-muted"><a class="text-muted" target="_blank" href="https://github.com/KBTMPL/PIrouter">PIrouter</a> - Krzysztof Bulanda 2018</span>
		</div>
    </footer>

	<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script> 
	function fcall(file) {
			setTimeout(function(){
			//kod
			}, 3000);
	    $.get(file);
	    return false;
	}
	$(function() {
	var current_progress = 0;
	var interval = setInterval(function() {
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
