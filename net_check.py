#!/usr/bin/env python3
print("Content-Type: text/html")
print()

import cgi, cgitb

print('<html><head><title>Stan internetu</title>')
print('<meta charset="UTF-8">')
print('<meta name="viewport" content="initial-scale=1.0">')
print('</head><body>')
print('<div class="alert alert-info text-center">Router posiada połączenie z internetem</div>')
print('<div class="alert alert-warning text-center">Router nie posiada połączenia z internetem</div>')
print('</body></html>')