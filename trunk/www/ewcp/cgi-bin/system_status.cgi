#!/bin/sh

DATA=`/bin/date`
MASZYNA=`/bin/hostname`
OBCIAZENIE=`/bin/cat /proc/loadavg`

echo "Content-type: text/html"
echo
echo "<html><head><title>Eboda Web Control Panel</title></head><body bgcolor="#000000" text="#FFFFFF"><center>[<a href="system.cgi"><b>SYSTEM</b></a>]&nbsp&nbsp|&nbsp&nbsp<a href="disk.cgi">Disk</a>&nbsp&nbsp|&nbsp&nbsp<a href="network.cgi">Network</a><br><h1>System</h1></center><hr>Welcome on <b>$MASZYNA</b> machine! Average load at this moment ($DATA) is: $OBCIAZENIE<br><br><br>"
echo "<b>Kernel:</b><pre>"
/bin/cat /proc/version
echo "</pre><br>"

echo "<b>Modules:</b><pre>"
/bin/cat /proc/modules
echo "</pre><br>"

echo "<b>Processor:</b><pre>"
/bin/cat /proc/cpuinfo
echo "</pre><br>"

echo "<b>Memory usage:</b><pre>"
/usr/bin/free
echo "</pre><br>"

echo "<b>Memory map:</b><pre>"
/bin/cat /proc/iomem
echo "</pre><br>"

echo '<form action="reboot.cgi" method="post"><button style="background-color:lightgreen">Reboot</button></form>'
echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '
echo "<br></body></html>"