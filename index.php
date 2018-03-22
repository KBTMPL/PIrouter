<?php
    session_start();
/*    echo isset($_SESSION['login']);
    if(isset($_SESSION['login'])) {
      header('LOCATION:index.php'); die();
    }*/
?>
<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>PIrouter</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link href="style.css" rel="stylesheet">
	</head>

	<body>

	<header id="TOP">
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#TOP">PIrouter</a>
		</nav>
    </header>
	
	<main class="container">
	
		<h3 class="mt-5 text-center">PIrouter</h3>

		<?php
			if(isset($_POST['submit'])){
				$username = $_POST['username']; $password = $_POST['password'];
			if($username === 'krzysztof' && hash('sha256', $password) === 'ef392bb64b73a01bfa321f8f8779bddef3965c953ac7e8271642fb250da364bd'){
				$_SESSION['login'] = true; header('LOCATION:admin.php'); die();
			} elseif ($username === 'guest' && hash('sha256', $password) === '84983c60f7daadc1cb8698621f802c0d9f9a3c3c295c810748fb048115c186ec'){
				$_SESSION['login'] = true; $_SESSION['guest'] = true; header('LOCATION:admin.php'); die();
			} {
				echo "<div class='alert alert-danger'>Login lub hasło się nie zgadza.</div>";
			}
			}
		?>
	
    <form method="post">
	
		<div class="form-group">
			<label for="username">Login:</label>
			<input type="text" class="form-control" id="username" name="username" placeholder="guest" required>
		</div>
		
		<div class="form-group">
			<label for="pwd">Hasło:</label>
			<input type="password" class="form-control" id="pwd" name="password" placeholder="guest" required>
		</div>
		
		<div class="text-center">
			<button type="submit" name="submit" class="btn btn-default">Login</button>
		</div>
		
    </form>
	
		<h6 class="mt-5 text-center text-danger">w trybie gościa zablokowane jest ingerowanie w ustawienia routera</h6>
	
	</main>

	<footer class="footer">
		<div class="container">
			<span class="text-muted">PIrouter - Krzysztof Bulanda 2018</span>
		</div>
    </footer>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
