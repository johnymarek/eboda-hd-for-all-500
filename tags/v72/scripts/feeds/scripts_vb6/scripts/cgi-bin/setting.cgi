#!/bin/sh
# Dreambox Live

c_param1=`echo $QUERY_STRING | cut -d'&' -f1 | cut -d= -f1`
c_value1=`echo $QUERY_STRING | cut -d'&' -f1 | cut -d= -f2`

echo "Content-type: text/html"
echo
echo "<html><head>"
echo "<title>E-Boda HD500</title>"
echo "<link type='text/css' rel='stylesheet' href='../cube_web_management.css' />"
echo "</head>"
echo "<body>"

	echo "<!-- "
	cd /usr/local/bin/
	REV=`./DvdPlayer -h 2>/dev/null | sed '/Version:/!d' | cut -d' ' -f3`
	echo "--> "
	echo "<h1>E-Boda HD500 firmware version $REV</h1><hr><br>"
if [ $c_value1 = "swapon" ]
then
	swapsize=`grep SwapTotal /proc/meminfo | tr -s ' ' | cut -d ' ' -f 2`
	partition=`fdisk -l | grep "Linux swap" | cut -d ' ' -f 1`
	psize=`fdisk -l | grep "Linux swap" | tr -s ' ' | cut -d ' ' -f 4`
	echo "<h2>Info swap HDD</h2><br>"
	echo !!!!!!!!!!!!!!!!!!
	echo "<br>"
	echo ! Your swap size is $swapsize kB.
	echo "<br>" 
	echo ! Your swap partition size is $psize kB
	echo "<br>"
	if [ $swapsize -lt $psize ]
	then
		echo ! Probably swap partition not used
		echo "<br>"
	else
		echo ! Everything looks ok, swap partition probably already activated
		echo "<br>"
	fi
fi
if [ $c_value1 = "filme" ]
then
	echo "<h2>Instalare HDD Links</h2><br>"
	if [ -d /tmp/usbmounts/sda1/scripts ]
	then
	  echo "HDD Links pe usb1"
	  echo "<br>"
	  cd /usr/local/etc/www/cgi-bin
	  rm -f scripts
	  ln -s /tmp/usbmounts/sda1/scripts scripts
	  cd /tmp/usbmounts/sda1/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/usbmounts/sdb1/scrips ]
	then
	  echo "HDD Links pe usb1"
	  echo "<br>"
	  cd /usr/local/etc/www/cgi-bin
	  rm -f scripts
	  ln -s /tmp/usbmounts/sdb1/scripts scripts
	  cd /tmp/usbmounts/sdb1/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/usbmounts/sdc1/scrips ]
	then
	  echo "HDD Links pe usb1"
	  echo "<br>"
	  cd /usr/local/etc/www/cgi-bin
	  rm -f scripts
	  ln -s /tmp/usbmounts/sdc1/scripts scripts
	  cd /tmp/usbmounts/sdc1/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/usbmounts/sda2/scripts ]
	then
	  echo "HDD Links pe usb2"
	  echo "<br>"
	  cd /usr/local/etc/www/cgi-bin
	  rm -f scripts
	  ln -s /tmp/usbmounts/sda2/scripts scripts
	  cd /tmp/usbmounts/sda2/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/usbmounts/sdb2/scripts ]
	then
	  echo "HDD Links pe usb2"
	  echo "<br>"
	  cd /usr/local/etc/www/cgi-bin
	  rm -f scripts
	  ln -s /tmp/usbmounts/sdb2/scripts scripts
	  cd /tmp/usbmounts/sdb2/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/usbmounts/sdc2/scripts ]
	then
	  echo "HDD Links pe usb2"
	  echo "<br>"
	  cd /usr/local/etc/www/cgi-bin
	  rm -f scripts
	  ln -s /tmp/usbmounts/sdc2/scripts scripts
	  cd /tmp/usbmounts/sdc2/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/hdd/root/scripts ]
	then
	  echo "HDD Links pe HDD (partia linux)"
	  echo "<br>"
	  cd /usr/local/etc/www/cgi-bin
	  rm -f scripts
	  ln -s /tmp/hdd/root/scripts scripts
	  cd /tmp/hdd/root/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/hdd/volumes/HDD1/scripts ]
	then
	  echo "HDD Links pe HDD (partia NTFS)"
	  echo "<br>"
	  cd /usr/local/etc/www/cgi-bin
	  rm -f scripts
	  ln -s /tmp/hdd/volumes/HDD1/scripts scripts
	  cd /tmp/hdd/volumes/HDD1/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	else
	  echo "Scripturile HDD Links <b>NU</b> au fost instalate.<br>Verificati daca directorul scripts este pe USB, HDD(partitia NTFS) sau HDD(partitia linux)."
	  echo "<br>"
	fi
fi
if [ $c_value1 = "filme1" ]
then
	echo "<h2>Actualizare HDD Links</h2><br>"
	if [ -d /tmp/usbmounts/sda1/scripts ]
	then
	  echo "HDD Links pe usb1"
	  echo "<br>"
	  cd /tmp/usbmounts/sda1/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/usbmounts/sdb1/scrips ]
	then
	  echo "HDD Links pe usb1"
	  echo "<br>"
	  cd /tmp/usbmounts/sdb1/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/usbmounts/sdc1/scrips ]
	then
	  echo "HDD Links pe usb1"
	  echo "<br>"
	  cd /tmp/usbmounts/sdc1/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/usbmounts/sda2/scripts ]
	then
	  echo "HDD Links pe usb2"
	  echo "<br>"
	  cd /tmp/usbmounts/sda2/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/usbmounts/sdb2/scripts ]
	then
	  echo "HDD Links pe usb2"
	  echo "<br>"
	  cd /tmp/usbmounts/sdb2/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/usbmounts/sdc2/scripts ]
	then
	  echo "HDD Links pe usb2"
	  echo "<br>"
	  cd /tmp/usbmounts/sdc2/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/hdd/root/scripts ]
	then
	  echo "HDD Links pe HDD (partia linux)"
	  echo "<br>"
	  cd /tmp/hdd/root/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	elif [ -d /tmp/hdd/volumes/HDD1/scripts ]
	then
	  echo "HDD Links pe HDD (partia NTFS)"
	  echo "<br>"
	  cd /tmp/hdd/volumes/HDD1/scripts
		for i in $( find -name '*.php' )
		do
		chmod +x $i
		done
		for i in $( find -name '*.cgi' )
		do
		chmod +x $i
		done
	  echo "Scripturile HDD Links au fost instalate."
	  echo "<br>"
	else
	  echo "Scripturile HDD Links <b>NU</b> au fost actualizate.<br>Verificati daca directorul scripts este pe USB, HDD(partitia NTFS) sau HDD(partitia linux)."
	  echo "<br>"
	fi
fi
if [ $c_value1 = "filme2" ]
then
		echo "<h2>Stergere HDD Links</h2><br>"
		rm -f /usr/local/etc/www/cgi-bin/scripts
		if [ -d /tmp/hdd/root/scripts ]
			then
			rm -rf /tmp/hdd/root/scripts
			echo "Scripturile HDD Links au fost sterse de pe partitia linux."
		fi
fi
if [ $c_value1 = "ftp" ]
then
	echo "<h2>Start/Stop ftp server - mod expert</h2><br>"
	bftpdPID=$(pidof "bftpd")
	if test $? -eq 0
	then
	killall -9 pidof "bftpd" >/dev/null 2>&1
	echo "FTP is Stopped."
	else
	/sbin/bftpd -d -c /usr/local/bin/bftpd.conf
	echo "FTP is Running."
	fi
fi
if [ $c_value1 = "transmission_status" ]
then
	echo "<h2>Transmission Status</h2><br>"
	echo "Intefata web: http://eboda:9091<br>"
	echo "Username : torrentuser<br>Password : webtorrent<br>"
	if [ `grep -c "Transmission" /usr/local/etc/rcS` -ne "1" ]; then
	echo "Autostart is disable.<br>"
	else
	echo "Autostart in enable<br>"
	fi
	PSP=`ps | grep 'transmission-daemon' | grep -v grep`
	if [ -n "$PSP" ]; then
	echo "Transmission is Running.<br>"
	else
	echo "Transmission is Stopped.<br>"
	fi
fi
if [ $c_value1 = "transmission_enable" ]
then
	echo "<h2>Autostart Transmission</h2><br>"
	echo "Intefata web: http://eboda:9091<br>"
	echo "Username : torrentuser<br>Password : webtorrent<br>"
	if [ `grep -c "Transmission" /usr/local/etc/rcS` -ne "1" ]; then
	echo "/opt/init/S80Transmission start" >> /usr/local/etc/rcS
	echo "Transmission will autostart with the device."
	else
	echo "Transmission already in autostart<br>"
	fi
fi
if [ $c_value1 = "transmission_disable" ]
then
	echo "<h2>Disable Transmission</h2><br>"
	cd /usr/local/etc/
	sed -e "/S80Transmission/d" rcS >rcS2 ; mv rcS2 rcS ; chmod +x rcS
	echo "Transmission disabled from autostart."
fi
if [ $c_value1 = "transmission_start" ]
then
	echo "<h2>Start/Stop Transmission</h2><br>"
	echo "Intefata web: http://eboda:9091<br>"
	echo "Username : torrentuser<br>Password : webtorrent<br>"
	PSP=`ps | grep 'transmission-daemon' | grep -v grep`
	if [ -n "$PSP" ]; then
	killall -9 transmission-daemon
	echo "Transmission is Stopped."
	else
	/opt/init/S80Transmission start
	echo "Transmission is Running."
	fi
fi
if [ $c_value1 = "system" ]
then
	echo "<h2>Info System</h2><br>"
	echo "<b>Kernel:</b><pre>"
	/bin/cat /proc/version
	echo "</pre><br>"
	
	echo "<b>Modules:</b><pre>"
	/bin/cat /proc/modules
	echo "</pre><br>"
	
	echo "<b>Processor:</b><pre>"
	/bin/cat /proc/cpuinfo
	echo "</pre><br>"
	
	echo "<b>Memory usage:</b><pre>"
	/usr/bin/free
	echo "</pre><br>"
	
	echo "<b>Memory map:</b><pre>"
	/bin/cat /proc/iomem
	echo "</pre><br>"	
fi
if [ $c_value1 = "network" ]
then
	echo "<h2>Info Network</h2><br>"
	echo "<b>Internet status:</b><pre>"
	/bin/ping www.google.com
	echo "</pre><br>"
	
	echo "<b>Network devices:</b><pre>"
	/sbin/ifconfig
	echo "</pre><br>"
	
	echo "<b>Active connections:</b><pre>"
	/bin/netstat -a
	echo "</pre><br>"
fi
if [ $c_value1 = "df" ]
then
	echo "<h2>File System</h2><br>"
	echo "<b>File System:</b><pre>"
	/bin/df -h
	echo "</pre><br>"
fi
if [ $c_value1 = "stop_dvdplayer" ]
then
	echo "<pre>"
	echo "<H1><b>Stop DVDPlayer...</b></H1>"
	echo "<H2><b>Done ...</b></H2>"
	echo "<br>"
	/usr/bin/stopall > /dev/null
fi
if [ $c_value1 = "reboot" ]
then
	echo "<pre>"
	echo "<H1><b>Reboot DVDPlayer...</b></H1>"
	echo "<H2><b>Done ...</b></H2>"
	echo "<br>"
	/sbin/reboot
fi
if [ $c_value1 = "shutdown" ]
then
	echo "<pre>"
	echo "<H1><b>Shutdown DVDPlayer...</b></H1>"
	echo "<H2><b>Done ...</b></H2>"
	echo "<br>"
                echo -n "O" >> /tmp/ir
				sleep 5
                echo -n "O" >> /tmp/ir
fi
############################################

############################################
echo "<br></body></html>"
