#!/bin/sh

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
Reboot command will be send, go back to previous page.
<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> 
<br></body></html>

EOT
/sbin/reboot