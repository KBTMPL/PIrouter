#!/usr/bin/env python3
import psutil as ps

print("Content-Type: text/html")
print()

# print out cpu load in %
print(ps.cpu_percent())
