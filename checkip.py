#!/usr/bin/env python3
import os
import ipaddress
import netifaces as ni

print("Content-Type: text/html")
print()


def netmask_to_cidr(netmask):
    return sum([bin(int(x)).count('1') for x in netmask.split('.')])


client_ip = ipaddress.ip_address(os.environ['REMOTE_ADDR'])
host_ip = ni.ifaddresses('wlan0')[ni.AF_INET][0]['addr']
host_netmask = str(netmask_to_cidr(ni.ifaddresses('wlan0')[ni.AF_INET][0]['netmask']))

host_interface = ipaddress.IPv4Interface(host_ip + '/' + host_netmask)
host_network = ipaddress.IPv4Network(host_interface.network)

print(client_ip in host_network)
