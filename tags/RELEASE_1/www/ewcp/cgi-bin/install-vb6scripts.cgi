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

echo Eboda Web Control Panel is installing vb6 scripts and Metafeeds.

#check if internal HDD present
if [ ! -d /tmp/hdd/volumes/HDD1 -o ! -d /tmp/hdd/root ]
then 
	echo Cannot find internal HDD standard installation. Exiting
	mount
	mexit 3
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

# it seems something is needed ???
# TODO
# /tmp/hdd/root/opt/bin/ipkg-opt install

# if lighttpd not installed, go back and install

# put the new menu (no need to overmount as we add few lines and two pics)


if [ -f /usr/local/bin/scripts/.overmounted ]
then
    echo overmount already activated
else

#create/activate overmount
echo "#!/bin/sh
#Waiting for HDD-plugin to finish...
echo '#overmount:/usr/local/bin/scripts'
n=1
while [ ! -d  /tmp/hdd/root/opt ] ; do
 sleep 3
 [ \$n -gt 30 ] && break
 let n+=1
 echo '#waiting for hdd..'
 echo \$n
done
#bind rss scripts directory:
if [ ! -f /usr/local/bin/scripts/.overmounted ];then
    echo '#overmount start'
    mount -o bind /tmp/hdd/root/scripts_overmounted /usr/local/bin/scripts
    touch /usr/local/bin/scripts/.overmounted
    echo '#overmount end'
fi
" > /tmp/hdd/root/opt/etc/init.d/S01scriptsovermount
chmod +x /tmp/hdd/root/opt/etc/init.d/S01scriptsovermount

[ -d /tmp/hdd/root/scripts_overmounted/ ] || mkdir /tmp/hdd/root/scripts_overmounted/
cp -r /usr/local/bin/scripts/* /tmp/hdd/root/scripts_overmounted/

sh /tmp/hdd/root/opt/etc/init.d/S01scriptsovermount

echo overmount created for /usr/local/bin/scripts

fi




echo "*Download menu*"
cd /tmp/hdd/root/scripts_overmounted/
wget http://eboda-hd-for-all-500.googlecode.com/files/menu.zip 
[ $? == 0 ] || mexit 2

echo "*Extract menu*"
unzip -o menu.zip 
rm menu.zip

# Metafeeds CGIs
echo "*Install stream_fix cgi-scripts (optware is required)*"
cd /tmp/hdd/root/unicgi/cgi-bin/
wget http://eboda-hd-for-all-500.googlecode.com/files/mf-cgi-bin.zip
[ $? == 0 ] || mexit 2
unzip -o mf-cgi-bin.zip
rm mf-cgi-bin.zip
chmod +x *


# vb6 CGIs
# Metafeeds CGIs
echo "*Install stream_fix cgi-scripts (optware is required)*"
cd /tmp/hdd/root/unicgi/cgi-bin/
wget http://eboda-hd-for-all-500.googlecode.com/files/vb6-cgi-bin.zip
[ $? == 0 ] || mexit 2
unzip -o vb6-cgi-bin.zip
rm vb6-cgi-bin.zip
chmod +x *


cd /opt/bin
wget http://eboda-hd-for-all-500.googlecode.com/files/mf-binaries.zip
[ $? == 0 ] || mexit 2
unzip -o mf-binaries.zip
rm mf-binaries.zip
chmod +x *


#vb6 scripts to HDD
cd /tmp/hdd/volumes/HDD1
if [ -d scripts ]
then
        echo scripts already existing, removing it
        rm -rf scripts
fi
wget http://eboda-hd-for-all-500.googlecode.com/files/hdd_scripts.zip
[ $? == 0 ] || mexit 2
unzip -o hdd_scripts.zip
rm hdd_scripts.zip

echo "*Install Done , (enjoy your feeds)*"
echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '

echo "</pre><br></body></html>"
