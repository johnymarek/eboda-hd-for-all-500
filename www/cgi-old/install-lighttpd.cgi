#!/bin/sh


mexit ()
{
	ls -l /
	pwd
	ls -l .
	df -h
	ps wwaux
        echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '
	exit $1
}


echo "Content-type: text/html"
echo
echo "<html><head><title>Eboda Web Control Panel update</title></head><body bgcolor=\"#000000\" text=\"#FFFFFF\"><br><br><br><pre>"

echo Eboda Web Control Panel is installing Lighttpd and php.

#check if internal HDD present
if [ ! -d /tmp/hdd/volumes/HDD1 -o ! -d /tmp/hdd/root ]
then 
	echo Cannot find internal HDD standard installation. Exiting
	mount
	exit 3
else
	echo Internal HDD found, continuing
fi
	

#check and update optware
if [ -f /tmp/hdd/root/opt/bin/ipkg-opt ]
then
	echo  -e "You already installed optware, good show!\nI will execute an update"
    	/tmp/hdd/root/opt/bin/ipkg-opt update
else
      	echo -e "Optware is not installed... go back to previous page and install it\n"
	mexit 1
fi

#install lightttpd and php

/tmp/hdd/root/opt/bin/ipkg-opt install lighttpd
/tmp/hdd/root/opt/bin/ipkg-opt install php-fcgi

#don't know if following are nedded
#/tmp/hdd/root/opt/bin/ipkg-opt install php-xmlrpc
#/tmp/hdd/root/opt/bin/ipkg-opt install php-mbstring

cat >/cb3pp/etc/lighttpd/conf.d/00.event-handler.conf <<EOF
server.event-handler = "poll"
EOF

cat >/cb3pp/etc/lighttpd/conf.d/02.follow-scripts.conf <<EOF
server.follow-symlink="enable"
EOF

rm -f /opt/share/www/scripts
ln -s /tmp/hdd/volumes/HDD1/scripts /opt/share/www/scripts

sh /cb3pp/etc/init.d/S80lighttpd stop
sh /cb3pp/etc/init.d/S80lighttpd start

echo '<form action="reboot.cgi" method="post"><button style="background-color:lightgreen">Reboot</button></form>'
echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '

echo "</pre><br></body></html>"
