#!/usr/bin/env python3
print("Content-Type: text/html")
print()

import cgi, cgitb
import psutil as ps

print(ps.virtual_memory()[2])
