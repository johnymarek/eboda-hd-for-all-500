#!/bin/sh
# PlayOn!HD InfoSite
# Author: mikka [mika.hellmann@gmail.com]
# Version: 0.2

echo "Content-type: text/html"
echo
echo "<html><head><title>PlayOn!HD InfoSite</title></head><body bgcolor="#000000" text="#FFFFFF"><center><a href="system.cgi">System</a>&nbsp&nbsp|&nbsp&nbsp[<a href="disk.cgi"><b>DISK</b></a>]&nbsp&nbsp|&nbsp&nbsp<a href="network.cgi">Network</a><br><h1>Disk</h1></center><hr><br><br><br>"

echo "<b>Available partitions:</b><pre>"
/sbin/fdisk -l /dev/sda
/sbin/fdisk -l /dev/sdb
/sbin/fdisk -l /dev/sdc
/sbin/fdisk -l /dev/sdd
echo "</pre><br>"

echo "<b>Mounted partitions:</b><pre>"
/bin/cat /proc/mounts
echo "</pre><br>"

echo "<b>Disk usage:</b><pre>"
/bin/df -h
echo "</pre><br>"

echo "<br></body></html>"