#!/bin/sh

echo "Content-type: text/html"
echo
echo "<html><head><title>Eboda Web Control Panel update</title></head><body bgcolor=\"#000000\" text=\"#FFFFFF\"><br><br><br><pre>"

echo Eboda Web Control Panel is updating.

#ewcp
cd /tmp/hdd/root
if [ -d ewcp ]
then
        echo ewcp already existing, removing it
        rm -rf ewcp
fi
wget http://eboda-hd-for-all-500.googlecode.com/files/ewcp-latest.zip
[ $? == 0 ] || mexit 2
unzip -o ewcp.zip
rm ewcp.zip

echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '

echo "</pre><br></body></html>"

