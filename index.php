<?php
    session_start();
    if(isset($_SESSION['login'])) {
      header('LOCATION:admin.php');
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#343a40">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#343a40">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		
	<title>PIrouter</title>

	<link rel="stylesheet" href="bootstrap.min.css">
	<link href="style.css" rel="stylesheet">
</head>

<body>

	<header id="TOP">
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand active" href="#TOP">PIrouter</a>
            
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
				
					<li class="nav-item" id="pimusic">
						<a class="text-success nav-link active" href="#" onclick="myWindow=window.open('http://' + lan_ipaddr + ':6680/iris/','','height=768, width=1024');">PImusic</a>
                    </li>
					
				</ul>
			</div>
		</nav>
    </header>
	
	<main class="container">
	
		<h3 class="mt-5 text-center">PIrouter</h3>

		<?php
			$user_data = file('auth', FILE_IGNORE_NEW_LINES);

			if(isset($_POST['submit'])){
				$username = $_POST['username']; $password = $_POST['password'];
			if(hash('sha256', $username) === $user_data[0] && hash('sha256', $password) === $user_data[1]){
				$_SESSION['login'] = true; header('LOCATION:admin.php'); die();
			} elseif (hash('sha256', $username) === '84983c60f7daadc1cb8698621f802c0d9f9a3c3c295c810748fb048115c186ec' && hash('sha256', $password) === '84983c60f7daadc1cb8698621f802c0d9f9a3c3c295c810748fb048115c186ec'){
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
			<span class="text-muted"><a class="text-muted" target="_blank" href="https://github.com/KBTMPL/PIrouter">PIrouter</a> - Krzysztof Bulanda 2018</span>
		</div>
    </footer>
	
	<script src="jquery-3.3.1.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script>
        var lan_ipaddr = '';
        $.get('ip_addr', function(data) {
            var i = 0;
            while(data[i] != " ") {
                    i++;
            }

                    i++;
            
            while(data[i] != " ") {
                lan_ipaddr += data[i];
                    i++;
                }
        });
        
        function pimusic_check() {
            $.get('checkip.py', function(data) {
                    if(data.trim() == 'True') {
                        $(pimusic).show();
                    }
					if(data.trim() == 'False'){
                        $(pimusic).hide();
					}
				});
            }
        
            // default visibility of pimusic
                $(pimusic).hide();
                pimusic_check();
    </script>
</body>
</html>
