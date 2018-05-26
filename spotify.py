#!/usr/bin/env python3
import cgi

print("Content-Type: text/html")
print()


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
    print("<meta http-equiv='refresh' content='0; url=reboot.php'>")
    print("</head></html>")


# cgi.test()
form = cgi.FieldStorage()

reboot = "None"

login = str(form.getvalue("login"))
password = str(form.getvalue("pass"))
client_id = str(form.getvalue("cid"))
client_secret = str(form.getvalue("cse"))
check = str(form.getvalue("check"))

reboot = str(form.getvalue("reboot"))

###

if check == '1':
    alines = open('/etc/mopidy/mopidy.conf').read().splitlines()
    alines[30] = "username= " + login
    alines[31] = "password= " + password
    alines[32] = "client_id= " + client_id
    alines[33] = "client_secret= " + client_secret
    open('/etc/mopidy/mopidy.conf', 'w').write('\n'.join(alines))

    blines = open('spotify.php').read().splitlines()
    blines[1] = login
    blines[2] = password
    blines[3] = client_id
    blines[4] = client_secret
    open('spotify.php', 'w').write('\n'.join(blines))

    if reboot == "None":
        redirect_admin()
    elif reboot == "on":
        redirect_reboot()
