#!/usr/bin/env python3
import psutil as ps

print("Content-Type: text/html")
print()

# print out ram load in %
print(ps.virtual_memory()[2])
