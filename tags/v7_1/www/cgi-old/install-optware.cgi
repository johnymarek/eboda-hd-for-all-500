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

echo Eboda Web Control Panel is installing optware.

#check if internal HDD present
if [ ! -d /tmp/hdd/volumes/HDD1 -o ! -d /tmp/hdd/root ]
then 
	echo Cannot find internal HDD standard installation. Exiting
	mount
	mexit 1
else
	echo Internal HDD found, continuing
fi
	

#create opt stuff on HDD
##create firectory
if [ -d /tmp/hdd/root/opt ]
then 
	echo /tmp/hdd/root/opt directory already existing, using it
else
	mkdir /tmp/hdd/root/opt
	if [ $? -eq 0 ]
	then
		echo opt directory was created in /tmp/hdd/root
	else
		echo Cannot create optware directory in /tmp/hdd/root. Exiting
		mexit 2
	fi
fi
## create/check bind directory

if [ -e /opt ]
then
	if [ -d /opt ]
	then
		echo /opt directory already existing, using it
	else
		echo /opt exists but it is not a directory link. Check and correct this/remove. Exiting.
		mexit 3
	fi
else
	echo "/opt directory not existing, I'll try to create one"
	mount -o remount,rw /
	mkdir /opt
	if [ $? -eq 0 ]
	then
		/opt directory was created
		mount -o remount,ro /
	else
		echo Cannot create /opt directory. Exiting
		mount -o remount,ro /
		mexit 4

	fi
fi

mkdir -p /tmp/hdd/root/cb3pp/etc/init.d
#creating and activating global /opt startup script
echo '#!/bin/sh


# Start all init scripts in /cb3pp/etc/init.d
# executing them in numerical order.
#


PATH=$PATH:/opt/bin:/opt/sbin
export PATH

for i in /tmp/hdd/root/cb3pp/etc/init.d/S??* ;do
     # Ignore dangling symlinks (if any).
     [ ! -f "$i" ] && continue

     case "$i" in
        *.sh)
            # Source shell script for speed.
            (
                trap - INT QUIT TSTP
                set start
                . $i
            )
            ;;
        *)
            # No sh extension, so fork subprocess.
            $i start
            ;;
    esac
done' > /tmp/hdd/root/cb3pp/etc/init.d/rcS

echo /opt startup script prepared

# check/add script in /usr/local/etc/rcS
sed -e "/^#BEGIN CBA_OPT_STARTUP/,/^#END CBA_OPT_STARTUP/d" /usr/local/etc/rcS > /tmp/tmpfile$$

if [ $? -eq 0 ]
then
	echo '#BEGIN CBA_OPT_STARTUP
# wait HDD to start (should be no issue if no internal HDD) and run rcS from opt if present
opt_startup=/tmp/hdd/root/cb3pp/etc/init.d/rcS
n=1
while [ ! -f $opt_startup ] ; do
sleep 3
[ $n -gt 30 ] && break
let n+=1
echo "#waiting for hdd.."
done
[ -f $opt_startup ] && /bin/sh $opt_startup
#END CBA_OPT_STARTUP' >> /tmp/tmpfile$$

cp /tmp/tmpfile$$ /usr/local/etc/rcS
rm /tmp/tmpfile$$
fi

echo Script added to /usr/local/etc/rcS for auto startup

#create/activate overmount
echo "#!/bin/sh
#Waiting for HDD-plugin to finish...
echo '#overmount:/opt'
n=1
while [ ! -d  /tmp/hdd/root/opt ] ; do
 sleep 3
 [ \$n -gt 30 ] && break
 let n+=1
 echo '#waiting for hdd..'
 echo \$n
done
#bind rss scripts directory:
if [ ! -f /opt/.overmounted ];then
    echo '#overmount start'
    mount -o bind /tmp/hdd/root/opt /opt
    touch /opt/.overmounted
    echo '#overmount end'
fi
" > /tmp/hdd/root/cb3pp/etc/init.d/S00optovermount
chmod +x /tmp/hdd/root/cb3pp/etc/init.d/S00optovermount
sh /tmp/hdd/root/cb3pp/etc/init.d/S00optovermount

echo overmount created for /opt

#install optware
if [ -f /tmp/hdd/root/opt/bin/ipkg-opt ]
then
	echo  -e "You already installed optware, good show!\nI will execute an update"
    	/tmp/hdd/root/opt/bin/ipkg-opt update
	if [ $? -eq 0 ]
	then
		echo Finished
	else
		echo Something is wrong, please reboot and try again
	fi
else
      	echo -e "Optware is not installed... Let's install it\n"
      
	cd /tmp/hdd/root/opt
	wget http://ipkg.nslu2-linux.org/feeds/optware/oleg/cross/stable/uclibc-opt_0.9.28-13_mipsel.ipk
	ipkg-cl install uclibc-opt_0.9.28-13_mipsel.ipk
	wget http://ipkg.nslu2-linux.org/feeds/optware/oleg/cross/stable/ipkg-opt_0.99.163-10_mipsel.ipk
	ipkg-cl install ipkg-opt_0.99.163-10_mipsel.ipk
	rm uclibc-opt_0.9.28-13_mipsel.ipk ipkg-opt_0.99.163-10_mipsel.ipk
          
fi
     

echo '<form action="reboot.cgi" method="post"><button style="background-color:lightgreen">Reboot</button></form>'
echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '

echo "</pre><br></body></html>"
