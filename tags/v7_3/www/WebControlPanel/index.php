<head>
  <title>Astone AP300 - Control Panel</title>
  <link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico">
  <style type="text/css">
    table {border:1px solid black}
    .shaded {background-color:#c0c0c0}
    .small {font-size:8pt}
    .thead {font-weight:bold; background-color:black; color:yellow; text-align:center}
  </style>
</head>

<body bgcolor = #B6B5B3>
<div style="text-align: center;"><span style="font-family: Tahoma; font-weight: bold; font-size: 18pt;"></span><img border="0px" alt="Astone AP300 Media Player Control Panel" title="Astone AP300 Media Player Control Panel" src="img/astone_banner.jpg" /><br style="font-family: Tahoma;" />
  </div>
<table width="" align="center" style="border: 1px solid black; width: 782px; font-family: Tahoma; height: 232px; border-collapse: collapse; background-color: rgb(255, 255, 255);">
  <tbody>
    <tr>
      <td style="border: 1px solid black; width: 260px; text-align: left; vertical-align: top; letter-spacing: 0pt; word-spacing: 0pt;"><span style="font-weight: bold;">
		<img border="0px" src="img/title_daemons.png" title="Daemons Running" alt="Daemons Running" /></span><br />
		<span style="font-size: 12pt;">
          <img src="img/<? print (shell_exec("pidof lighttpd")> 0 ? "started" : "stopped"); ?>_daemon.gif"> HTTP: Lighttpd Web Server<br />
		  <img src="img/<? print (shell_exec("pidof pure-ftpd")> 0 ? "started" : "stopped"); ?>_daemon.gif"> FTP: Pure FTP<br />
		  <img src="img/<? print (shell_exec("pidof dropbear")> 0 ? "started" : "stopped"); ?>_daemon.gif"> SSH: Dropbear SSH<br />
		  <img src="img/<? print (shell_exec("pidof cron")> 0 ? "started" : "stopped"); ?>_daemon.gif"> CRON: Cron Scheduling<br />
		  <img src="img/<? print (shell_exec("pidof transmission-daemon")> 0 ? "started" : "stopped"); ?>_daemon.gif"> TORRENT: Transmission<br />
		  <img src="img/<? print (shell_exec("pidof btpd")> 0 ? "started" : "stopped"); ?>_daemon.gif"> TORRENT: BTPD Torrent<br />
		  <img src="img/<? print (shell_exec("pidof smbd")> 0 ? "started" : "stopped"); ?>_daemon.gif"> NAS: Samba File Sharing<br />
		  <img src="img/<? print (shell_exec("pidof DvdPlayer")> 0 ? "started" : "stopped"); ?>_daemon.gif"> CORE: DvdPlayer Media<br />		  
        <br />
        <br />
		<img border="0px" src="img/title_utilities.png" title="Utilities" alt="Utilities" /></span><br />
        <span style="font-size: 12pt;">Transmission Torrent - <a href="util_transmission-start.php">Start</a> / <a href="util_transmission-stop.php">Stop</a><br />
          Lighttpd Web Server - <a href="util_lighttpd-stop.php">Stop</a><br />
          HDD (sdb6) - <a href="util_force-hdd-spindown.php">Force Spindown</a></span><br />
		  Optware - <a href="optware/">Change Configuration</a></span><br />
        <br />
        <br />
        <span style="font-weight: bold;"><img border="0px" src="img/title_infologs.png" title="Information/Logs" alt="Information/Logs" /></span><br />
        <a href="info_SMB.php">Samba Settings</a><br />
        <a href="info_cron.php">Cron Settings</a><br />
        <a href="info_mounttable.php">Mount Table</a><br />
        <a href="info_ps.php">Process List</a><br />
        <a href="info_diskusage.php">Disk Usage</a><br />
        <a href="log_SpindownLog.php">JLSD Spindown Log</a><br />
		<a href="info_runPMPscript.php">View RunPMP Startup Script</a><br />
        <br />
        <br />
        <img border="0px" alt="Links" title="Links" src="img/title_links.png" /><br />
        <a href="http://192.168.1.74:9091/transmission/web/">Transmission Web Interface</a><br />
        <a href="http://www.astone.com.au/forum/viewforum.php?f=21">Astone Community Forum</a><br />
        <a href="http://code.google.com/p/astone/">Astone Code Project</a><br />
        <a href="http://www.astone.com.au/products_files/AP-300%20User%20Manual_EN.pdf">User Manual</a><br />
        <br />
		<br />
		<img border="0px" alt="Links" title="Disk Stats" src="img/title_diskstats.png" /><br />
		<?php

function sizefix($s) {

  $t=$s*1024;

  $postfix=Array("B","kB","MB","GB","TB");
  $i=0;

  while($t>1024){
    $t=$t/1024;
    $i++;
  }

  if ($i>0) $t=substr(number_format($t,4),0,5);
  return "$t $postfix[$i]";
}

  exec("df", $output);

  for ($i=1;$i<count($output);$i++) {
    $cols=preg_split("/\s+/", $output[$i]);

    $percent=100*$cols[2]/$cols[1];

    for($j=1;$j<4;$j++){
      $cols[$j]=sizefix($cols[$j]);
    }

    if ($percent>=1) {
      if ($percent<99) {
        $pb="<table width='100%'><tr><td width='$cols[4]' class='shaded'>&nbsp;</td><td>&nbsp;</td></tr></table>";
      } else {
        $pb="<table width='100%'><tr><td class='shaded'>&nbsp;</td></table>";
      }
    } else {
      $pb="<table width='100%'><tr><td>&nbsp;</td></table>";
    }

    echo "<table width='255'>\n  <tr class='thead'><td>$cols[0] &nbsp;&nbsp;&nbsp; --- &nbsp;&nbsp;&nbsp; $cols[5]</td></tr>\n";
    echo "  <tr><td>$pb</td></tr>\n";
    echo "  <tr><td class='small' align='center'><font size='-1'>Total: $cols[1] &nbsp;&nbsp; Used: $cols[2] &nbsp;&nbsp; <br /> Free: $cols[3]</font></td></tr>\n";
    echo "</table>\n<br>";
  }

?>
        </td>
      <td style="border: 1px solid black; text-align: left; vertical-align: top; letter-spacing: 0pt; word-spacing: 0pt;"><img border="0px" alt="Product Information" title="Product Information" src="img/title_productinfo.png" /><br />
        <br />
		<img width="520" border="0" alt="Connections" title="Connections" src="img/info_a.jpg" /><br />
		<br />
		<br />
		<img width="520" border="0" alt="Rear View" title="Rear View" src="img/info_c.jpg" /><br />
        <br />
		<br />
        <img width="520" border="0" alt="Front View" title="Front View" src="img/info_b.jpg" /><br />
        <br />
		<br />
		</td>
    </tr>
  </tbody>
</table>
</body>