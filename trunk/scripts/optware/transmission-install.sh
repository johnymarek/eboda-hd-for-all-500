#!/bin/sh

#check if already installed by us
# done by cipibad, take good care of it


#check if internal HDD present
if [ ! -d /tmp/hdd/volumes/HDD1 -o ! -d /tmp/hdd/root ]
then 
	echo Cannot find internal HDD standard installation. Exiting
	mount
	exit 3
else
	echo Internal HDD found, continuing
fi
	

#install optware
if [ -f /tmp/hdd/root/opt/bin/ipkg-opt ]
then
	echo  -e "You already installed optware, good show!\nI will execute an update"
    	/tmp/hdd/root/opt/bin/ipkg-opt update
else
      	echo -e "Optware is not installed... Please do installt it\n"
	exit 1
      
fi

#install transmission

/tmp/hdd/root/opt/bin/ipkg-opt install transmission

rm -f /opt/etc/init.d/S??transmission
cat > /opt/etc/init.d/S91transmission <<EOF
#!/bin/sh
PATH=/sbin:/bin:/usr/bin:/usr/sbin:/opt/bin:/opt/sbin

start() {
        fi
        echo "Starting transmission"
        /opt/bin/transmission-daemon --config-dir /tmp/hdd/volumes/HDD1/transmission/config --port 8080 --no-auth --download-dir /tmp/hdd/volumes/HDD1/transmission/download --dht --peerport 51413 -a "*" --encryption-tolerated --peerlimit-global 64 --peerlimit-torrent 32

}

stop() {
        echo -n "Shutting down transmission... "
        killall transmission-daemon
        echo "done"
}

case "\$1" in
        start)
                start
                ;;
        stop)
                stop
                ;;
        restart)
                stop
                sleep 1
                start
                ;;
        *)
                echo "Usage: \$0 (start|stop|restart)"
                exit 1
                ;;
esac
EOF
chmod +x /opt/etc/init.d/S91transmission
echo transmission startup script prepared

#prepare transmission directories
if [ ! -d /tmp/hdd/volumes/HDD1/transmission ]
then
        echo Creating transmission directories
        mkdir /tmp/hdd/volumes/HDD1/transmission
        mkdir /tmp/hdd/volumes/HDD1/transmission/config
        mkdir /tmp/hdd/volumes/HDD1/transmission/download
else
        if [ ! -d /tmp/hdd/volumes/HDD1/transmission/config ]
        then
                echo Creating transmission config directory
                mkdir /tmp/hdd/volumes/HDD1/transmission/config
        else
                echo config directory found
        fi
        if [ ! -d /tmp/hdd/volumes/HDD1/transmission/download ]
        then
                echo Creating transmission download directory
                mkdir /tmp/hdd/volumes/HDD1/transmission/download
        else
                echo download directory found
        fi
fi


echo !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
echo !
echo !  Note this: you are be able to access rtorrent at address:
echo !  http://\<your_box_ip\>:8080
echo !  You need to replace \<your_box_ip\> with the IP address of your box 
echo !  that you can find in setup menu, network section
echo !
echo !!!!!!!!!!!!!!!!!!!!!!!!!!!!!

echo We will reboot in 10 seconds-not required to run transmission, but good to be sure installation is ok
echo You can press CTRL+C to stop
sleep 5
echo 5 seconds to go
sleep 5
reboot

