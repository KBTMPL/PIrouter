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
	print("<html><head><title>Ustawienie LAN</title>")
	print("<meta charset='UTF-8'>")
	print("<meta name='viewport' content='initial-scale=1.0'>")
	print("<meta http-equiv='refresh' content='0; url=admin.php'>")
	print("</head></html>")

def redirect_reboot():
	print("<!doctype html>")
	print("<html><head><title>Ustawienie LAN</title>")
	print("<meta charset='UTF-8'>")
	print("<meta name='viewport' content='initial-scale=1.0'>")
	print("<meta http-equiv='refresh' content='1; url=reboot.php'>")
	print("</head></html>")
	
#cgi.test()
form = cgi.FieldStorage()

check = "None"
reboot = "None"

adres = str(form.getvalue("adres"))
maska = str(form.getvalue("maska"))

poczatekd = str(form.getvalue("poczatekd"))
koniecd = str(form.getvalue("koniecd"))
czas = str(form.getvalue("czas"))

check = str(form.getvalue("check"))
reboot = str(form.getvalue("reboot"))

cidr = str(netmask_to_cidr(maska))
start = ipaddress.ip_address(poczatekd)
end = ipaddress.ip_address(koniecd)
net = ipaddress.IPv4Interface(adres + "/" + cidr)

condition = (start < end) and (start in net) and (end in net)

if condition:
	if check == "1":
		if reboot == "on":
			redirect_reboot()

	if check == "None":
		redirect_admin()

	if check == "1":
		alines = open('/etc/network/interfaces').read().splitlines()
		alines[15] = "address " + adres
		alines[16] = "netmask " + maska
		open('/etc/network/interfaces','w').write('\n'.join(alines))

		blines = open('interfaces.php').read().splitlines()
		blines[1] = adres
		blines[2] = maska
		open('interfaces.php','w').write('\n'.join(blines))

		clines = open('/etc/dnsmasq.conf').read().splitlines()
		clines[0] = "dhcp-range=" + poczatekd + "," + koniecd + "," + czas
		open('/etc/dnsmasq.conf','w').write('\n'.join(clines))

		dlines = open('dnsmasq.php').read().splitlines()
		dlines[1] = poczatekd
		dlines[2] = koniecd
		dlines[3] = czas
		open('dnsmasq.php','w').write('\n'.join(dlines))

		elines = open('/etc/samba/smb.conf').read().splitlines()
		elines[37] = "  hosts allow = " + net.network.with_netmask
		open('/etc/samba/smb.conf','w').write('\n'.join(elines))
		if reboot == "None":
			redirect_admin()
else:
	redirect_admin()
