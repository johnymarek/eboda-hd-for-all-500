#!/bin/sh


# CGI wrote by cipibad
# adapted from internet ...
#


. ../ewcp-version.txt
#HOSTNAME=`/bin/hostname`
#LOAD=`/bin/cat /proc/loadavg`

LOCALIP=`/sbin/ifconfig -a | grep -A 1 eth0 | grep inet | tr -s " " | cut -d " " -f 3 | cut -d ":" -f 2`

cat <<EOF
Content-type: text/html

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>E-Boda Web Control Panel $VERSION</title>
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/cp_style.css">
</head>
<body>
<table width="714" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><img src="/eb_imgs/cp_header.jpg" width="714" height="244"></td>
  </tr>
  <tr>
    <td id="content"><div class="pnlContainer">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="7"><img src="/eb_imgs/cp_TL.gif" width="7" height="36"></td>
            <td width="100%" class="pnlHeader">Daemons Status (click to start/stop) </td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>
        <tr height="212">
          <td colspan="3" class="pnlContent"><div class="pnlContentDiv">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
EOF

##############################
# BEGIN OF STATUS SECTION


name_lighttpd="HTTP: Lighttpd webserver"
name_apache="HTTP: Apache webserver"
name_transmission="TORRENT: Transmission"
name_rtorrent="TORRENT: rtorrent"
name_btpd="TORRENT: btpd"
name_btpd15="TORRENT: btpd 0.15"
name_smbd="NAS: Samba"
name_bftpd="NAS: bftpd"
name_DvdPlayer="CORE: DvdPlayer"

#apache transmission not in this scope
for i in lighttpd btpd15 btpd smbd bftpd DvdPlayer 
do
    pic=/eb_imgs/cp_on.gif
    script=util_${i}-stop.cgi
    state=Started
    process=$i
    [ $process == "transmission" ] && process=transmission-daemon
    pidof ${process} >/dev/null
    if [ $? -ne 0 ]
    then
    	pic=/eb_imgs/cp_off.gif 
    	script=util_${i}-start.cgi
    	state=Stopped
    fi
    
    full_name=`eval echo \\$name_${i}`
cat <<EOF
  <tr>
    <td width="11%"><a href="${script}"><img src="$pic" width="24" height="20" border="0"></a></td>
    <td width="89%"><a href="${script}">$full_name ($state)</a></td>
  </tr>
EOF
done


# END OF STATUS SECTION
##############################


cat <<EOF
</table>
</div></td>
          </tr>
        <tr>
          <td><img src="/eb_imgs/cp_BL.gif" width="7" height="6"></td>
            <td class="pnlFooter"><img src="/eb_imgs/spacer.gif" width="6" height="6"></td>
            <td><img src="/eb_imgs/cp_BR.gif" width="7" height="6"></td>
          </tr>
      </table>
    </div>
      <div class="pnlContainer">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="7"><img src="/eb_imgs/cp_TL.gif" width="7" height="36"></td>
            <td width="100%" class="pnlHeader">Utilities </td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>
          <tr height="212">
            <td colspan="3" class="pnlContent"><div class="pnlContentDiv">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

EOF

##############################
# BEGIN OF UTILITIES SECTION

# name_lighttpd="HTTP: Lighttpd webserver"
# name_apache="HTTP: Apache webserver"
# name_transmission-daemon="TORRENT: Transmission"
# name_rtorrent="TORRENT: rtorrent"
# name_btpd15="TORRENT: btpd 0.15"
# name_btpd="TORRENT: btpd"
# name_smbd="NAS: Samba"
# name_smbd="NAS: bftpd"
# name_DvdPlayer="CORE: DvdPlayer"
name_ewcp="WWW: Eboda Web Control Panel"
name_vb6="RSS: vb6rocod php scripts"
name_apps="APPS: extra apps"

for i in ewcp vb6 apps 
do
    script=util_${i}-update.cgi
    full_name=`eval echo \\$name_${i}`
    cat <<EOF
                <tr height="21">
                  <td width="8%"><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td width="92%">${full_name} <a href="${script}">Update</a></td>
                </tr>
EOF
done

startfile_lighttpd="/cb3pp/etc/init.d/S80lighttpd"
startfile_apache="/cb3pp/etc/init.d/S08apache"
startfile_transmission="/cb3pp/etc/init.d/S90transmission"
startfile_rtorrent="/cb3pp/etc/init.d/S90rtorrent"
startfile_btpd15="/cb3pp/etc/init.d/S90btpd15"
startfile_btpd="/tmp/package/script/btpd"
startfile_smbd="/tmp/package/script/samba"
startfile_bftpd="/cb3pp/etc/init.d/S70bftpd"

#apache transmission not in this scope
for i in lighttpd btpd15 btpd smbd bftpd
do
    full_name=`eval echo \\$name_${i}`
    script="#"
    state="Not installed"
    action="N/A"
    
    startfile=`eval echo \\$startfile_${i}`
    if [ -f $startfile ] 
    then
    	if [ -x $startfile ]
    	then
    		script=util_${i}-disable.cgi
    		state="Enabled"
    		action=Disable
    	else
    		script=util_${i}-enable.cgi
    		state="Disabled"
    		action=Enable
    	fi
    fi

    cat <<EOF
                <tr height="21">
                  <td><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td>${full_name} ($state) <a href="${script}">${action}</a> </td>
                </tr>
EOF
done
# END OF UTILITIES SECTION
##############################

cat <<EOF
              </table>
            </div></td>
          </tr>
          <tr>
            <td><img src="/eb_imgs/cp_BL.gif" width="7" height="6"></td>
            <td class="pnlFooter"><img src="/eb_imgs/spacer.gif" width="6" height="6"></td>
            <td><img src="/eb_imgs/cp_BR.gif" width="7" height="6"></td>
          </tr>
        </table>
      </div>

      <div class="pnlContainer">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="7"><img src="/eb_imgs/cp_TL.gif" width="7" height="36"></td>
            <td width="100%" class="pnlHeader">Information / Logs </td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>
          <tr>
            <td colspan="3" class="pnlContent"><div class="pnlContentDiv">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">

EOF

##############################
# BEGIN OF LOGS SECTION

cat <<EOF


                <tr>
                  <td width="8%"><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td width="92%"><a href="system_status.cgi">System Status</a> </td>
                </tr>
                <tr>
                  <td><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td><a href="log_system.cgi">System Logs</a> </td>
                </tr>
                <tr>
                  <td><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td><a href="log_lighttpd_access.cgi">Lighttpd access log</a></td>
                </tr>
                <tr>
                  <td><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td><a href="log_lighttpd_error.cgi">Lighttpd error log</a></td>
                </tr>

EOF

# END OF LOGS SECTION
##############################
cat <<EOF
              </table>
            </div></td>
          </tr>
          <tr>
            <td><img src="/eb_imgs/cp_BL.gif" width="7" height="6"></td>
            <td class="pnlFooter"><img src="//eb_imgs/spacer.gif" width="6" height="6"></td>
            <td><img src="/eb_imgs/cp_BR.gif" width="7" height="6"></td>
          </tr>
        </table>
      </div>
      <div class="pnlContainer">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="7"><img src="/eb_imgs/cp_TL.gif" width="7" height="36"></td>
            <td width="100%" class="pnlHeader">Links </td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>
          <tr>
            <td colspan="3" class="pnlContent"><div class="pnlContentDiv">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">


EOF
##############################
# BEGIN OF LINKS SECTION
                # <tr>
                #   <td width="8%"><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                #   <td width="92%"><a href="http://$LOCALIP:8082">Transmission Web Interface</a> </td>
                # </tr>
	        #<tr>
                  #<td><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  #<td><a href="http://$LOCALIP:8081/rtgui">rtGui</a></td>
                #</tr>
                #<tr>
                  #<td><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  #<td><a href="http://$LOCALIP:8081/rutorrent">rutorrent </a></td>
                #</tr>

cat <<EOF
                <tr>
                  <td><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td><a href="http://$LOCALIP">Default web interface</a></td>
                </tr>
                <tr>
                  <td><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td><a href="http://$LOCALIP:8081/webui">btpd 0.15 web interface</a></td>
                </tr>
                <tr>
                  <td><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td><a href="http://forum.softpedia.com/index.php?showtopic=640751">Sofpedia forum dedicated topic (ro)</a></td>
                </tr>
                <tr>
                  <td><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td><a href="http://code.google.com/p/eboda-hd-for-all-500/">Google Code project page </a></td>
                </tr>

EOF

# END OF LINKS SECTION
##############################

cat <<EOF


              </table>
            </div></td>
          </tr>
          <tr>
            <td><img src="/eb_imgs/cp_BL.gif" width="7" height="6"></td>
            <td class="pnlFooter"><img src="/eb_imgs/spacer.gif" width="6" height="6"></td>
            <td><img src="/eb_imgs/cp_BR.gif" width="7" height="6"></td>
          </tr>
        </table>
      </div>
      <div class="pnlContainerBig">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="pnlTableBig">
          <tr>
            <td width="7"><img src="/eb_imgs/cp_TL.gif" width="7" height="36"></td>
            <td width="100%" class="pnlHeader">Disk Stats </td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>

EOF

##############################
# BEGIN OF DISK SECTION

cat <<EOF
          <tr>
            <td colspan="3" class="pnlContent"><div class="pnlContentDiv2">
EOF

   echo "<pre style=\"font-size: 8pt;\">"
	df -h |  tr -s ' ' | cut -d ' ' -f 2-6 | tr ' ' '\t' | sed -e 's/Available/Avail/'
   echo "</pre>"
cat <<EOF
           <td>
          </tr>
EOF
# END OF DISK SECTION
##############################

cat <<EOF
          <tr>
            <td><img src="/eb_imgs/cp_BL.gif" width="7" height="6"></td>
            <td class="pnlFooter"><img src="/eb_imgs/spacer.gif" width="6" height="6"></td>
            <td><img src="/eb_imgs/cp_BR.gif" width="7" height="6"></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td><img src="/eb_imgs/cp_footer.gif" width="714" height="65"></td>
  </tr>
</table>
</body>
</html>
EOF
