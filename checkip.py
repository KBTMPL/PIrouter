#!/usr/bin/env python3
print("Content-Type: text/html")
print()

import cgi, cgitb, os, sys, ipaddress
import netifaces as ni

def netmask_to_cidr(netmask):
    '''
    :param netmask: netmask ip addr (eg: 255.255.255.0)
    :return: equivalent cidr number to given netmask ip (eg: 24)
    '''
    return sum([bin(int(x)).count('1') for x in netmask.split('.')])


client_ip = ipaddress.ip_address(os.environ['REMOTE_ADDR'])
host_ip = ni.ifaddresses('wlan0')[ni.AF_INET][0]['addr']
host_netmask = str(netmask_to_cidr(ni.ifaddresses('wlan0')[ni.AF_INET][0]['netmask']))

host_interface = ipaddress.IPv4Interface(host_ip + '/' + host_netmask)
host_network = ipaddress.IPv4Network(host_interface.network)

print(client_ip in host_network)
