<?php
    session_start();
    if(!isset($_SESSION['login'])) {
        header('LOCATION:index.php'); die();
    }
	
	// load data forms currently set
	
	$hostapd_data = file('hostapd.php', FILE_IGNORE_NEW_LINES); // name channel pwd 1-3
	$interfaces_data = file('interfaces.php', FILE_IGNORE_NEW_LINES); // adres maska 1-2
	$dnsmasq_data = file('dnsmasq.php', FILE_IGNORE_NEW_LINES); // poczatekd koniecd czas 1-3
	$interfaces2_data = file('interfaces2.php', FILE_IGNORE_NEW_LINES); // isenabled adres maska brama dns 1-5
    $spotify_data = file('spotify.php', FILE_IGNORE_NEW_LINES); // login pass id secret

?>
<!doctype html>
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

<body onload="update_test_image()">

	<header id="TOP">
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		
			<a onclick="activate('')" class="navbar-brand <?php if(!isset($_SESSION['guest']) && isset($_SESSION['login'])) { echo('text-danger'); } elseif(isset($_SESSION['guest']) && isset($_SESSION['login'])) { echo('text-warning'); } ?>" href="#TOP">PIrouter</a>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
				
                    <li class="nav-item" id="pimusic">
						<a class="text-success nav-link active" href="#" onclick="myWindow=window.open('http://' + lan_ip + ':6680/iris/','','height=768, width=1024');">PImusic</a>
                    </li>
					<li class="nav-item" id="stat">
						<a class="nav-link" onclick="activate('stat')"  href="#STAT">Status</a>
					</li>
					<li class="nav-item" id="ap">
						<a class="nav-link" onclick="activate('ap')" href="#AP">Punkt dostępu</a>
					</li>
					<li class="nav-item" id="lan">
						<a class="nav-link" onclick="activate('lan')" href="#LAN">Sieć lokalna</a>
					</li>
					<li class="nav-item" id="wan">
						<a class="nav-link" onclick="activate('wan')" href="#WAN">Sieć rozległa</a>
					</li>
                    <li class="nav-item" id="spotify">
						<a class="nav-link" onclick="activate('spotify')" href="#SPOTIFY">Spotify</a>
					</li>
					<li class="nav-item active">
						<a class="text-warning nav-link" href="reboot.php">Uruchom ponownie</a>
					</li>
					<li class="nav-item active">
						<a onclick="fcall('poweroff.php');" class="text-danger nav-link" href="#">Wyłącz</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link text-info" href="logout.php">Wyloguj się</a>
					</li>
					
				</ul>
			</div>
		</nav>
	</header>

	<main class="container" id="main">

<div id="STAT">
	<h3 class="mt-5 text-center">Status urządzenia</h3>
	
	<div class="alert alert-info">
		<div class="row text-center mb-2">
			<div id="lan_ip" class="col-md-12 text-center">
				Adres IP LAN:
			</div>
		</div>
		
		<div class="row text-center mb-2">
			<div id="wan_ip" class="col-md-12 text-center">
				Adres IP WAN:
			</div>
		</div>
	</div>
	
	<div id="test_success" class="alert alert-info text-center">
		Router posiada połączenie z internetem
	</div>
	
	<div id="test_failure" class="alert alert-danger text-center">
		Router nie posiada połączenia z internetem
	</div>
	
	<div id="test_ability" class="alert alert-info">
		<div class="row text-center mb-2">
			<div class="col-md-12 text-center">
				Test prędkości internetu
			</div>
		</div>
		
		<div class="row text-center" id="test">
			<div class="col-md-12 text-center">
				<img id="test_img" alt="test_img" class="img-fluid mt-2 mb-2" src="testoutput.png" />
			</div>
		</div>
		
		<div class="row text-center mt-2">
			<div class="col-md-12">
				<button type="button" class="btn btn-default btn-sm btn-dark" onclick="$(test).toggle()">Pokaż wynik</button>
				
				<button id="perform_speedtest_button" type="button" class="btn btn-default btn-sm btn-dark" onclick="perform_speedtest()">Uruchom test</button>
			</div>
		</div>
	</div>
	
	<div class="alert alert-info text-center">
		<p>Aktywne udziały serwera samba</p>
	
		<div id="samba"></div>
		
	</div>
	
</div>

	<hr />

<div id="AP">
	
	<h3 class="mt-5 text-center">Punkt dostępu</h3>
    
    <form action="<?php if(!isset($_SESSION['guest'])) { echo('wlan.py'); } ?>" method="post">
	
    <?php if(isset($_SESSION['login'])) { echo('<input id="check1" name="check" type="hidden" value="1">'); } ?>
        
		<div class="form-group">
			<label for="ssid">SSID:</label>
			<input type="text" class="form-control" id="ssid" name="ssid" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,50}$" autocomplete="off" value="<?php echo($hostapd_data[1]); ?>" placeholder="przynajmniej jeden znak" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>
		
		<div class="form-group">
			<label for="wpa_passphrase">Hasło:</label>
			<input type="password" class="form-control" id="wpa_passphrase" name="wpa_passphrase" pattern=".{8,63}" autocomplete="off" value="<?php echo($hostapd_data[3]); ?>" placeholder="od 8 do 63 znaków" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>
		
		<div class="form-group text-center row">
			<div class="col-md-6">
				<label for="channel">Kanał:</label>
				<select id="channel" name="channel" <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>>
					<?php for ($i = 1; $i <= 11; $i++) { if ($i == $hostapd_data[2]) { echo('<option value="'.$i.'" selected="selected">'.$i.'</option>'); } else { echo('<option value="'.$i.'">'.$i.'</option>'); } } ?>
				</select>
			</div>
			
		<?php if(!isset($_SESSION['guest'])) { echo('
		
			<div class="col-md-6">
				<label for="reboot1">Zastosować konfigurację?</label>
				<input type="checkbox" name="reboot" id="reboot1">
			</div>
            
        '); } ?> 
            
		</div>
        
		<?php if(!isset($_SESSION['guest'])) { echo('
        
		<div class="text-center">
			<button type="submit" name="submit" class="btn btn-dark">Zapisz</button>
		</div>
		
		'); } ?>  
    
            
    </form>
        
</div>

	<hr />
	
<div id="LAN">

<h3 class="mt-5 text-center">Sieć lokalna</h3>
    
    <form action="<?php if(!isset($_SESSION['guest'])) { echo('addr.py'); } ?>" method="post">
        
    <?php if(isset($_SESSION['login'])) { echo('<input id="check2" name="check" type="hidden" value="1">'); } ?>

		<div class="form-group">
			<label for="adres">Adres IP:</label>
			<input type="text" class="form-control" id="adres" name="adres" placeholder="xxx.xxx.xxx.xxx" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" autocomplete="off" value="<?php echo($interfaces_data[1]); ?>" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>
		
		<div class="form-group">
			<label for="maska">Maska podsieci:</label>
			<input type="text" class="form-control" id="maska" name="maska" placeholder="xxx.xxx.xxx.xxx" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" autocomplete="off" value="<?php echo($interfaces_data[2]); ?>" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>	
	
		<div class="form-group">
			<label for="poczatekd">Pierwszy adres puli DHCP:</label>
			<input type="text" class="form-control" id="poczatekd" name="poczatekd" placeholder="xxx.xxx.xxx.xxx" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" autocomplete="off" value="<?php echo($dnsmasq_data[1]); ?>" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>	
	
		<div class="form-group">
			<label for="koniecd">Ostatni adres puli DHCP:</label>
			<input type="text" class="form-control" id="koniecd" name="koniecd" placeholder="xxx.xxx.xxx.xxx" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" autocomplete="off" value="<?php echo($dnsmasq_data[2]); ?>" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>	
	
		<div class="form-group">
			<label for="czas">Czas trwania dzierżawy adresu:</label>
			<input type="text" class="form-control" id="czas" name="czas" pattern="[\d]{1,10}[s]|[\d]{1,10}[m]|[\d]{1,10}[h]" placeholder="np. 120s 30m 1h" autocomplete="off" value="<?php echo($dnsmasq_data[3]); ?>" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>	
	
		<?php if(!isset($_SESSION['guest'])) { echo('
	
		<div class="form-group text-center row">
			<div class="col-md-12">
				<label for="reboot2">Zastosować konfigurację?</label>
				<input type="checkbox" name="reboot" id="reboot2">
			</div>
		</div>
	
		<div class="text-center">
			<button type="submit" name="submit" class="btn btn-dark">Zapisz</button>
		</div>
		
		'); } ?>
    
	</form>

</div>

	<hr />
	
<div id="WAN">

<h3 class="mt-5 text-center">Sieć rozległa</h3>
    
    <form action="<?php if(!isset($_SESSION['guest'])) { echo('addr2.py'); } ?>" method="post">
        
    <?php if(isset($_SESSION['login'])) { echo('<input id="check3" name="check" type="hidden" value="1">'); } ?>
		
		<div class="form-group text-center">
			<p class="small">aby skonfigurować adres statyczny wyłącz klienta DHCP</p>
				<label for="dhcp">Klient DHCP:</label>
				<select onchange="sh_wan_static_field()" id="dhcp" name="dhcp" <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>>
					<?php  if ($interfaces2_data[1] == 'tak') {
						echo('<option value="tak" selected="selected">tak</option>');
						echo('<option value="nie">nie</option>');
						} else {
						echo('<option value="tak">tak</option>');
						echo('<option value="nie" selected="selected">nie</option>');
						} 
					?>
				</select>
		</div>
        
    <div id="wan_static">
        
		<div class="form-group">
			<label for="adresw">Adres IP:</label>
			<input type="text" class="form-control" id="adresw" name="adres" placeholder="xxx.xxx.xxx.xxx" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" autocomplete="off" value="<?php echo($interfaces2_data[2]); ?>" <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>
		
		<div class="form-group">
			<label for="maskaw">Maska podsieci:</label>
			<input type="text" class="form-control" id="maskaw" name="maska" placeholder="xxx.xxx.xxx.xxx" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" autocomplete="off" value="<?php echo($interfaces2_data[3]); ?>" <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>	
	
		<div class="form-group">
			<label for="brama">Brama domyślna:</label>
			<input type="text" class="form-control" id="brama" name="brama" placeholder="xxx.xxx.xxx.xxx" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" autocomplete="off" value="<?php echo($interfaces2_data[4]); ?>" <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>	
	
		<div class="form-group">
			<label for="dns">Serwer nazw domenowych:</label>
			<input type="text" class="form-control" id="dns" name="dns" placeholder="xxx.xxx.xxx.xxx" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" autocomplete="off" value="<?php echo($interfaces2_data[5]); ?>"  <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>	
	
    </div>    
        
		<?php if(!isset($_SESSION['guest'])) { echo('
		
		<div class="form-group text-center row">
			<div class="col-md-12">
				<label for="reboot3">Zastosować konfigurację?</label>
				<input type="checkbox" name="reboot" id="reboot3">
			</div>
		</div>
	
		<div class="text-center">
			<button type="submit" name="submit" class="btn btn-dark">Zapisz</button>
		</div>
		
		'); } ?>
    
	</form>

</div>
    
<hr />
	
<div id="SPOTIFY">

<h3 class="mt-5 text-center">Konfiguracja Spotify</h3>
    
    <div class="form-group text-center">
        <p class="small">aby skonfigurować dostęp do Spotify wprowadź dane pozyskane z <a href="https://www.mopidy.com/authenticate/#spotify" target="_blank">tej</a> strony</p>
    </div>
        
    <form action="<?php if(!isset($_SESSION['guest'])) { echo('spotify.py'); } ?>" method="post">
        
    <?php if(isset($_SESSION['login'])) { echo('<input id="check4" name="check" type="hidden" value="1">'); } ?>

		<div class="form-group">
			<label for="login">Login:</label>
			<input type="text" class="form-control" id="login" name="login"  autocomplete="off" value="<?php echo($spotify_data[1]); ?>" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>
		
		<div class="form-group">
			<label for="pass">Hasło:</label>
			<input type="password" class="form-control" id="pass" name="pass"  autocomplete="off" value="<?php if(!isset($_SESSION['guest'])) { echo($spotify_data[2]); } ?>" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>	
	
        <div class="form-group">
			<label for="cid">ID użytkownika:</label>
			<input type="text" class="form-control" id="cid" name="cid"  autocomplete="off" value="<?php echo($spotify_data[3]); ?>" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>
        
        <div class="form-group">
			<label for="cse">Skrót użytkownika:</label>
			<input type="text" class="form-control" id="cse" name="cse"  autocomplete="off" value="<?php echo($spotify_data[4]); ?>" required <?php if(isset($_SESSION['guest'])) { echo('disabled '); } ?>/>
		</div>	
	
		<?php if(!isset($_SESSION['guest'])) { echo('
	
		<div class="form-group text-center row">
			<div class="col-md-12">
				<label for="reboot3">Zastosować konfigurację?</label>
				<input type="checkbox" name="reboot" id="reboot4">
			</div>
		</div>
	
		<div class="text-center">
			<button type="submit" name="submit" class="btn btn-dark">Zapisz</button>
		</div>
		
		'); } ?>
    
	</form>

</div>


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
		/* global variables */
		
			var tRefresh = 5000 // [ms]
			var tSpeedTest = 40000 // [ms]
	
	
		// running scripts in background
		function fcall(file) {
			$.get(file);
			return false;
		}
		
		// animation of active anchors in navbar
		function activate(id) {
			var anchors = ["stat", "ap", "lan", "wan", "top", "spotify"];
			for ( i=0; i<=anchors.length; i++) {
				if (anchors[i] == id) {
				document.getElementById(id).classList.add("active");
				} else {
				document.getElementById(anchors[i]).classList.remove("active")
				}
			}
		}
		
		// onevent change of static conf visibility
		function sh_wan_static_field() {
			if (document.getElementById("dhcp").value == "tak") { $(wan_static).hide(); } else { $(wan_static).show(); }
		}
		
		// reload speedtest image func
		function update_test_image() {
			var d = new Date();				
			document.getElementById("test_img").src="testoutput.png?=" + d.getTime();
		}
		
		// onclick speedtest perform and image reload
		function perform_speedtest() {
			fcall('speed.php')
			window.alert("Test prędkości w trakcie - odczekaj mniej niż minutę.");
			setTimeout(function(){
			update_test_image();
			$(test).show();
			}, tSpeedTest);
			
			
		}
		
		function check_net_status() {
			$.get('net_check.php', function(data) {
					if(data == '1') {
						$(test_success).show();
						$(test_failure).hide();
						$(perform_speedtest_button).show();
						document.getElementById('test_ability').classList = 'alert alert-info';
					} else if(data == '0'){
						$(test_success).hide();
						$(test_failure).show();
						$(perform_speedtest_button).hide();
						document.getElementById('test_ability').classList = 'alert alert-danger';
					}
				});
		}
		
		// refreshes certain parts of admin panel
		
		var repeater;
		function siteRefresher() {
			// keep network status up to date
			check_net_status();
			
			// update info on samba shares
			$('#samba').load('samba.php');
			
			repeater = setTimeout(siteRefresher, tRefresh);
		}
		
        var lan_ip = '';
        $.get('ip_addr', function(data) {
            var i = 0;
            while(data[i] != " ") {
                document.getElementById('wan_ip').innerHTML += data[i];
                    i++;
            }

                    i++;
            
            while(data[i] != " ") {
                document.getElementById('lan_ip').innerHTML += data[i];
                    i++;
                }
            
            lan_ip = document.getElementById('lan_ip').innerHTML;
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
		
		/* first run */
        
            // get clients ip
                //window.alert("My public IP address is: ", getRemoteHost());
               
        
			// start siteRefresher
				siteRefresher();
				
			// first load of conectivity status
				$(test_success).hide();
				$(test_failure).hide();

			// default visibility of static conf
				var wan_static_field = document.getElementById("dhcp").value;
				if (wan_static_field == "tak") { $(wan_static).hide(); }
			
			// default visibility of speedtest img div
				$(test).hide();
		
            // default visibility of pimusic
                $(pimusic).hide();
                pimusic_check();

	</script>
</body>
</html>

