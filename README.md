PIrouter
end user documentation

PIrouter is meant to be a user friendly mobile router. It can be run on any Raspberry PI device that has built-in or attached wireless local area network adapter. More advanced users can also adapt it on their own, to various linux running devices. It provides various usage possibilities:
creating wireless hotspot from any Ethernet based local network, in hotel, school or university, dorm etc.
	- sharing user files with another privileged users via popular protocols

	- playing local and / or Spotify audio files through 3.5 mini-jack connection

	- lookup system status and monitor basic device activity (central processing unit statistics, dynamic memory usage)

	- allows end user to test his or hers available Internet connection bandwidth (via speedtest.net)

	- easily manage configuration files via friendly device responsive web based GUI protected by secure login system (with ability to change username and / or password)

	- ability to connect to your Spotify account, play music and manage your playlists

	- it allows user to rearrange network interfaces, access point and authentication configuration to match every situation

	- provides feature called captive page which role is catching new users that has been newly authenticated to access point and inform them about basic information needed by end user to maintain the device

	- administration panel with safe guest access


PIrouter
technical documentation

Base code that runs GUI can be found on github.com/KBTMPL/PIrouter, the whole project consists of many linux software packages and libraries - but only open source ones -  and their config files stored inside of /etc/ directory (all processes run as system services and begin their work on startup) Below there are listed programing languages and frameworks used to write the PIrouter front and backend.
	- PHP
	- HTML
	- CSS
	- Javascript
	- Bootstrap
	- Python
	- Bash

Additional packages and libraries listed below also have been used and properly configured:
	- hostapd - for running secure access point

	- apache2 - as a web server with Common Gateway Interface support

	- nodogsplash - implementation of captive page portal

	- dnsmasq - providing DHCP and DNS service

	- smbd - sharing user files via common network file sharing protocol

	- cron - to schedule some system based commands

	- proftpd - sharing files via FTP

	- speedtest-cli - command line tool for checking speed of Internet connection

	- python based mopidy and its extensions mopidy-spotify, mopidy-iris - to allow end user to use Spotify without issues

	- python libraries: psutil, os, cgi, ipaddress, netifaces 

