#!/usr/bin/env python3
import psutil as ps

print("Content-Type: text/html")
print()

print(ps.virtual_memory()[2])
