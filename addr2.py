#!/usr/bin/env python3
print("Content-Type: text/html")
print()

import cgi, cgitb, ipaddress

# code to convert netmask ip to cidr number
def netmask_to_cidr(netmask):
    '''
    :param netmask: netmask ip addr (eg: 255.255.255.0)
    :return: equivalent cidr number to given netmask ip (eg: 24)
    '''
    return sum([bin(int(x)).count('1') for x in netmask.split('.')])
	
def redirect_admin():
	print("<!doctype html>")
	print("<html><head><title>Ustawienie WAN</title>")
	print("<meta charset='UTF-8'>")
	print("<meta name='viewport' content='initial-scale=1.0'>")
	print("<meta http-equiv='refresh' content='0; url=admin.php'>")
	print("</head></html>")

def redirect_reboot():
	print("<!doctype html>")
	print("<html><head><title>Ustawienie WAN</title>")
	print("<meta charset='UTF-8'>")
	print("<meta name='viewport' content='initial-scale=1.0'>")
	print("<meta http-equiv='refresh' content='0; url=reboot.php'>")
	print("</head></html>")

#cgi.test()
form = cgi.FieldStorage()

reboot = "None"

dhcp = str(form.getvalue("dhcp"))
adres = str(form.getvalue("adres"))
maska = str(form.getvalue("maska"))
brama = str(form.getvalue("brama"))
dns = str(form.getvalue("dns"))

check = str(form.getvalue("check"))
reboot = str(form.getvalue("reboot"))

if dhcp == "tak":
	alines = open('/etc/network/interfaces').read().splitlines()
	alines[10] = "allow-hotplug eth0"
	alines[11] = "iface eth0 inet dhcp"
	alines[19] = "#allow-hotplug eth0"
	alines[20] = "#iface eth0 inet static"
	alines[21] = "#address"
	alines[22] = "#netmask"
	alines[23] = "#gateway"
	alines[24] = "#dns-nameservers"
	open('/etc/network/interfaces','w').write('\n'.join(alines))

	blines = open('interfaces2.php').read().splitlines()
	blines[1] = "tak"
	blines[2] = ""
	blines[3] = ""
	blines[4] = ""
	blines[5] = ""
	open('interfaces2.php','w').write('\n'.join(blines))

elif adres == "None":
	redirect_admin()
elif maska == "None":
	redirect_admin()
elif dhcp == "nie":
	alines = open('/etc/network/interfaces').read().splitlines()
	alines[10] = "#allow-hotplug eth0"
	alines[11] = "#iface eth0 inet dhcp"
	alines[19] = "allow-hotplug eth0"
	alines[20] = "iface eth0 inet static"
	alines[21] = "address " + adres
	
	if brama != "None":
		alines[23] = "gateway " + brama
	else:
		alines[23] = "#gateway "
	if dns != "None":
		alines[24] = "dns-nameservers " + dns
	else:
		alines[24] = "#dns-nameservers "	
		
	open('/etc/network/interfaces','w').write('\n'.join(alines))

	blines = open('interfaces2.php').read().splitlines()
	blines[1] = "nie"
	blines[2] = adres
	blines[3] = maska
	if brama == "None":
		blines[4] = ""
	else:
		blines[4] = brama
	if dns == "None":
		blines[5] = ""
	else:
		blines[5] = dns
	open('interfaces2.php','w').write('\n'.join(blines))

if reboot == "None":
	redirect_admin()
elif reboot == "on":
	redirect_reboot()