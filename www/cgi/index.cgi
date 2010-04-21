#!/bin/sh
# CIPIBAD
# adapted from internet ...
#TODO fill LOCALIP
HOSTNAME=`/bin/hostname`
LOAD=`/bin/cat /proc/loadavg`

cat <<EOT
Content-type: text/html


<head>
  <title>E-boda HD for all 500/500+ - Control Panel</title>
  <link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico">
  <style type="text/css">
    table {border:1px solid black}
    .shaded {background-color:#c0c0c0}
    .small {font-size:8pt}
    .thead {font-weight:bold; background-color:black; color:yellow; text-align:center}
  </style>
</head>

<body bgcolor = #B6B5B3>
<div style="text-align: center;"><span style="font-family: Tahoma; font-weight: bold; font-size: 18pt;">Welcome to $HOSTNAME <br> </span><img border="0px" alt="Eboda Media Player Control Panel" title="Eboda Media Player Control Panel" src="img/eboda_banner.jpg" /><br style="font-family: Tahoma;" />
  </div>
<table width="" align="center" style="border: 1px solid black; width: 782px; font-family: Tahoma; height: 232px; border-collapse: collapse; background-color: rgb(255, 255, 255);">
  <tbody>

    <tr>
      <td style="border: 1px solid black; width: 260px; text-align: left; vertical-align: top; letter-spacing: 0pt; word-spacing: 0pt;"><span style="font-weight: bold;">
		<img border="0px" src="img/title_daemons.png" title="Daemons Running" alt="Daemons Running" /></span><br />
		<span style="font-size: 12pt;">
EOT
   echo "<pre style=\"font-size: 8pt;\">"
   uptime   
   echo "</pre>"

#to add new applications just modify here
   

    pidof lighttpd >/dev/null && echo -n "<img src=\"img/started_daemon.gif\" alt=\"Started: \">"  
    pidof lighttpd >/dev/null  || echo -n "<img src=\"img/stopped_daemon.gif\" alt=\"Stopped: \">"  
    echo "HTTP: Lighttpd Web Server <br />"

    pidof transmission-daemon >/dev/null  && echo -n "<img src=\"img/started_daemon.gif\" alt=\"Started: \">"  
    pidof transmission-daemon >/dev/null  || echo -n "<img src=\"img/stopped_daemon.gif\" alt=\"Stopped: \">"  
    echo "TORRENT: transmission <br />"

    pidof rtorrent >/dev/null  && echo -n "<img src=\"img/started_daemon.gif\" alt=\"Started: \">"  
    pidof rtorrent >/dev/null  || echo -n "<img src=\"img/stopped_daemon.gif\" alt=\"Stopped: \">"  
    echo "TORRENT: rtorrent <br />"

    pidof btpd >/dev/null  && echo -n "<img src=\"img/started_daemon.gif\" alt=\"Started: \">"  
    pidof btpd >/dev/null  || echo -n "<img src=\"img/stopped_daemon.gif\" alt=\"Stopped: \">"  
    echo "TORRENT: btpd <br />"

    pidof smbd >/dev/null  && echo -n "<img src=\"img/started_daemon.gif\" alt=\"Started: \">"  
    pidof smbd >/dev/null  || echo -n "<img src=\"img/stopped_daemon.gif\" alt=\"Stopped: \">"  
    echo "NAS: samba <br />"

    pidof DvdPlayer >/dev/null  && echo -n "<img src=\"img/started_daemon.gif\" alt=\"Started: \">"  
    pidof DvdPlayer >/dev/null  || echo -n "<img src=\"img/stopped_daemon.gif\" alt=\"Stopped: \">"  
    echo "CORE: DvdPlayer <br />"

cat <<EOT
        <br />

        <br />
		<span style="font-weight: bold;"><img border="0px" src="img/title_utilities.png" title="Utilities" alt="Utilities" /></span><br />
        <span style="font-size: 12pt;">

Transmission Torrent - <a href="util_transmission-start.cgi">Start</a> / <a href="util_transmission-stop.cgi">Stop</a><br />

Lighttpd Web Server - <a href="util_lighttpd-stop.cgi">Stop</a><br />

rtorrent - <a href="util_rtorrent-start.cgi">Start</a> / <a href="util_rtorrent-stop.cgi">Stop</a><br />

DvdPlayer - <a href="util_dvdplayer-start.cgi">Start</a> / <a href="util_dvdplayer-stop.cgi">Stop</a><br />
Optware - <a href="optware/">Change Configuration</a></span><br />

        <br />
        <br />
        <span style="font-weight: bold;"><img border="0px" src="img/title_infologs.png" title="Information/Logs" alt="Information/Logs" /></span><br />
        <a href="system_status.cgi">System Status</a><br />
        <a href="info_ps.cgi">Lighttpd log</a><br />
        <br />
        <br />


        <span style="font-weight: bold;"> <img border="0px" alt="Links" title="Links" src="img/title_links.png" /></span><br />

        <a href="http://$LOCALIP:8080">Transmission Web Interface</a><br />
        <a href="http://$LOCALIP:8081/rtgui">rtorrent rtGui</a><br />
        <a href="http://$LOCALIP:8081/rutorrent">rutorrent</a><br />
        <a href="http://forum.softpedia.com/index.php?showtopic=640751">Sofpedia forum dedicated topic(ro)</a><br />
        <a href="http://code.google.com/p/eboda-hd-for-all-500/"> Related Google Code project</a><br />

        <br />
		<br />


		<span style="font-weight: bold;"> <img border="0px" alt="Disk Stats" title="Disk Stats" src="img/title_diskstats.png" /></span> <br />
EOT
   echo "<pre style=\"font-size: 8pt;\">"
   df -h
   echo "</pre>"
cat <<EOT


<br>        </td>
    </tr>
  </tbody>
</table>
</body>

EOT