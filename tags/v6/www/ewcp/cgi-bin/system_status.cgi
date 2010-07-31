#!/bin/sh


# CGI wrote by cipibad
# adapted from internet ...
#

#VERSION=`grep VERSION /tmp/hdd/root/ewcp/current_version.txt  | cut -d'=' -f 2` 2>/dev/null
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
<title>E-Boda Web Control Panel</title>
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
            <td width="100%" class="pnlHeader">Kernel</td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>
        <tr height="212">
          <td colspan="3" class="pnlContent"><div class="pnlContentDiv">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td> <pre>
EOF

/bin/cat /proc/version

cat <<EOF
</pre>
</td>
  </tr>
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
            <td width="100%" class="pnlHeader">Modules </td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>
          <tr height="212">
            <td colspan="3" class="pnlContent"><div class="pnlContentDiv">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td><pre>
EOF

/bin/cat /proc/modules

cat <<EOF
</pre></td></tr>
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
            <td width="100%" class="pnlHeader">CPU </td>
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
                  <td>
<pre>
EOF

/bin/cat /proc/cpuinfo

cat <<EOF

</pre>

</td>
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
            <td width="100%" class="pnlHeader">Memory</td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>
          <tr>
            <td colspan="3" class="pnlContent"><div class="pnlContentDiv">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">


EOF
##############################
# BEGIN OF LINKS SECTION
cat <<EOF
                <tr>
                  <td>


<b>Memory usage:</b>
<pre>

EOF
/usr/bin/free

cat <<EOF
</pre>

<b>Memory map:</b><pre>
EOF

/bin/cat /proc/iomem
cat <<EOF

</pre><br></td>
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
            <td width="100%" class="pnlHeader">Actions</td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>

EOF

##############################
# BEGIN OF actions SECTION

                <tr height="21">
                  <td width="8%"><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td width="92%">${full_name} <a href="util_reboot.cgi">reboot</a></td>
                </tr>
                <tr height="21">
                  <td width="8%"><img src="/eb_imgs/cp_arr.gif" width="21" height="17" border="0"></td>
                  <td width="92%">${full_name} <a href="/cgi-bin/ewcp.cgi"}">Back to main page</a></td>
                </tr>



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



# old and ugly

# DATA=`/bin/date`
# MASZYNA=`/bin/hostname`
# OBCIAZENIE=`/bin/cat /proc/loadavg`

# echo "Content-type: text/html"
# echo
# echo "<html><head><title>Eboda Web Control Panel</title></head><body bgcolor="#000000" text="#FFFFFF"><center>[<a href="system.cgi"><b>SYSTEM</b></a>]&nbsp&nbsp|&nbsp&nbsp<a href="disk.cgi">Disk</a>&nbsp&nbsp|&nbsp&nbsp<a href="network.cgi">Network</a><br><h1>System</h1></center><hr>Welcome on <b>$MASZYNA</b> machine! Average load at this moment ($DATA) is: $OBCIAZENIE<br><br><br>"
# echo "<b>Kernel:</b><pre>"
# /bin/cat /proc/version
# echo "</pre><br>"

# echo "<b>Modules:</b><pre>"
# /bin/cat /proc/modules
# echo "</pre><br>"

# echo "<b>Processor:</b><pre>"
# /bin/cat /proc/cpuinfo
# echo "</pre><br>"

# echo "<b>Memory usage:</b><pre>"
# /usr/bin/free
# echo "</pre><br>"

# echo "<b>Memory map:</b><pre>"
# /bin/cat /proc/iomem
# echo "</pre><br>"

# echo '<form action="reboot.cgi" method="post"><button style="background-color:lightgreen">Reboot</button></form>'
# echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '
# echo "<br></body></html>"