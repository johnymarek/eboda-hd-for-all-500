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

# it seems something is needed ???
# TODO
# /tmp/hdd/root/opt/bin/ipkg-opt install

# if lighttpd not installed, go back and install

# put the new menu (no need to overmount as we add few lines and two pics)

echo "*Download menu*"
cd /usr/local/bin/
wget http://eboda-hd-for-all-500.googlecode.com/files/menu.tar 

echo "*Extract menu*"
tar xvf menu.tar 
rm menu.tar

# Metafeeds CGIs
echo "*Install stream_fix cgi-scripts (optware is required)*"
cd /tmp/hdd/root/unicgi/cgi-bin/
wget http://eboda-hd-for-all-500.googlecode.com/files/vb6-cgi-bin.tar
tar xvf vb6-cgi-bin.tar
rm vb6-cgi-bin.tar
chmod +x *





#Download binaries for cgi-stream-fix : separate download because they are pretty big.
if [ ! -f $USER_DIR/rss_scripts/bin/mplayer ];then
  echo "*Download mplayer for cgi-stream-fix"
    wget http://dl.dropbox.com/u/1225177/metafeeds/metafeeds-binaries.tar -O ./metafeeds-binaries.tar
    mkdir $USER_DIR/rss_scripts/bin
    tar -C $USER_DIR/rss_scripts/bin/ -xf metafeeds-binaries.tar
fi


# vb6 CGIs

#vb6 scripts to HDD



echo "*Install Done , (enjoy your feeds)*"
