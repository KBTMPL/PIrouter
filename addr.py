#!/usr/bin/env python3
import cgi
import ipaddress

print("Content-Type: text/html")
print()


def netmask_to_cidr(netmask):
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
    print("<meta http-equiv='refresh' content='0; url=reboot.php'>")
    print("</head></html>")


# access post data sent from html
form = cgi.FieldStorage()

reboot = "None"

adres = str(form.getvalue("adres"))
maska = str(form.getvalue("maska"))

poczatekd = str(form.getvalue("poczatekd"))
koniecd = str(form.getvalue("koniecd"))
czas = str(form.getvalue("czas"))
check = str(form.getvalue("check"))

reboot = str(form.getvalue("reboot"))

cidr = str(netmask_to_cidr(maska))

adresip = ipaddress.ip_address(adres)
start = ipaddress.ip_address(poczatekd)
end = ipaddress.ip_address(koniecd)
inter = ipaddress.IPv4Interface(adres + "/" + cidr)
net = ipaddress.IPv4Network(inter.network)

# check if configuration makes sense
condition = (start < end) and (start in net) and (end in net) and (adresip in net)
# if so proceed with editing the configuration files

# condition = 1

if check == '1':
    if condition:
        alines = open('/etc/network/interfaces').read().splitlines()
        alines[15] = "address " + adres
        alines[16] = "netmask " + maska
        open('/etc/network/interfaces', 'w').write('\n'.join(alines))

        blines = open('interfaces.php').read().splitlines()
        blines[1] = adres
        blines[2] = maska
        open('interfaces.php', 'w').write('\n'.join(blines))

        clines = open('/etc/dnsmasq.conf').read().splitlines()
        clines[0] = "dhcp-range=" + poczatekd + "," + koniecd + "," + czas
        open('/etc/dnsmasq.conf', 'w').write('\n'.join(clines))

        dlines = open('dnsmasq.php').read().splitlines()
        dlines[1] = poczatekd
        dlines[2] = koniecd
        dlines[3] = czas
        open('dnsmasq.php', 'w').write('\n'.join(dlines))

        elines = open('/etc/samba/smb.conf').read().splitlines()
        elines[41] = "  hosts allow = " + str(net)
        open('/etc/samba/smb.conf', 'w').write('\n'.join(elines))

        flines = open('/etc/nodogsplash/nodogsplash.conf').read().splitlines()
        flines[1] = "GatewayAddress " + adres
        open('/etc/nodogsplash/nodogsplash.conf', 'w').write('\n'.join(flines))

        glines = open('/etc/mopidy/mopidy.conf').read().splitlines()
        glines[51] = "hostname = " + adres
        open('/etc/mopidy/mopidy.conf', 'w').write('\n'.join(glines))

        if reboot == "None":
            redirect_admin()
        elif reboot == "on":
            redirect_reboot()

    else:
        redirect_admin()
