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

echo Eboda Web Control Panel is updating vb6 scripts.

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
