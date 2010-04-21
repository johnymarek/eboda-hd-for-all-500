#!/bin/sh
# PlayOn!HD InfoSite
# Author: mikka [mika.hellmann@gmail.com]
# Version: 0.2

echo "Content-type: text/html"
echo
echo "<html><head><title>PlayOn!HD InfoSite</title></head><body bgcolor="#000000" text="#FFFFFF"><center><a href="system.cgi">System</a>&nbsp&nbsp|&nbsp&nbsp<a href="disk.cgi">Disk</a>&nbsp&nbsp|&nbsp&nbsp[<a href="network.cgi"><b>NETWORK</b></a>]<br><h1>Network</h1></center><hr><br><br><br>"

echo "<b>Internet status:</b><pre>"
/bin/ping www.google.com
echo "</pre><br>"

echo "<b>Network devices:</b><pre>"
/sbin/ifconfig
echo "</pre><br>"

echo "<b>Active connections:</b><pre>"
/bin/netstat -a
echo "</pre><br>"

echo "<br></body></html>"