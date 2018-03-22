#!/usr/bin/env python3
print("Content-Type: text/html")
print()

import cgi, cgitb

def redirect_admin():
	print("<!doctype html>")
	print("<html><head><title>Ustawienie WLAN</title>")
	print("<meta charset='UTF-8'>")
	print("<meta name='viewport' content='initial-scale=1.0'>")
	print("<meta http-equiv='refresh' content='0; url=admin.php'>")
	print("</head></html>")

def redirect_reboot():
	print("<!doctype html>")
	print("<html><head><title>Ustawienie WLAN</title>")
	print("<meta charset='UTF-8'>")
	print("<meta name='viewport' content='initial-scale=1.0'>")
	print("<meta http-equiv='refresh' content='1; url=reboot.php'>")
	print("</head></html>")

#cgi.test()
form = cgi.FieldStorage()

check = "None"
reboot = "None"

name =  str(form.getvalue("ssid"))
chnl = str(form.getvalue("channel"))
pwd  = str(form.getvalue("wpa_passphrase"))

check = str(form.getvalue("check"))
reboot = str(form.getvalue("reboot"))

if check == "1":
	if reboot == "on":
		redirect_reboot()

if check == "None":
	redirect_admin()

if check == "1":
	alines = open('/etc/hostapd/hostapd.conf').read().splitlines()
	alines[2] = "ssid=" + name
	alines[4] = "channel=" + chnl
	alines[9] = "wpa_passphrase=" + pwd
	open('/etc/hostapd/hostapd.conf','w').write('\n'.join(alines))

	blines = open('hostapd.php').read().splitlines()
	blines[1] = name
	blines[2] = chnl
	blines[3] = pwd
	open('hostapd.php','w').write('\n'.join(blines))
	if reboot == "None":
		redirect_admin()