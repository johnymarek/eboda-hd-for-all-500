#!/bin/sh

nice_start()
{

cat <<EOF
Content-type: text/html

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>E-Boda Web Control Panel</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/cp_style.css">
</head>
<body>
<table width="714" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><img src="/eb_imgs/cp_header.jpg" width="714" height="244"></td>
  </tr>
  <tr>
    <td id="content">
      <div class="pnlContainerBig">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="pnlTableBig">
          <tr>
            <td width="7"><img src="/eb_imgs/cp_TL.gif" width="7" height="36"></td>
            <td width="100%" class="pnlHeader">${1}</td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>
          <tr>
            <td colspan="3" class="pnlContent"><div class="pnlContentDiv2">
              <pre>
EOF

}

nice_exit()
{
cat <<EOF
	    </pre>
	     <h2><a href="/cgi-bin/ewcp.cgi">Click here to go back to main page<a></h2>
           <td>
          </tr>
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

exit $1

}

