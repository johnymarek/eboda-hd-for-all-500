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

/tmp/hdd/root/opt/bin/ipkg-opt install rtorrent
/tmp/hdd/root/opt/bin/ipkg-opt install dtach
/tmp/hdd/root/opt/bin/ipkg-opt install lighttpd
/tmp/hdd/root/opt/bin/ipkg-opt install php-fcgi
/tmp/hdd/root/opt/bin/ipkg-opt install gzip
/tmp/hdd/root/opt/bin/ipkg-opt install php-xmlrpc
/tmp/hdd/root/opt/bin/ipkg-opt install php-mbstring


#a little kernel  tunning

cat > /opt/etc/init.d/S01kernel <<EOF
#!/bin/sh

echo 15 > /proc/sys/vm/swappiness
echo 3 > /proc/sys/vm/dirty_background_ratio
echo 40 > /proc/sys/vm/dirty_ratio
echo 6144 > /proc/sys/vm/min_free_kbytes
EOF
chmod +x /opt/etc/init.d/S01kernel
sh /opt/etc/init.d/S01kernel

rm -f /opt/etc/init.d/S??rtorrent
cat > /opt/etc/init.d/S90rtorrent <<EOF
#!/bin/sh
PATH=/sbin:/bin:/usr/bin:/usr/sbin:/opt/bin:/opt/sbin

RTORRENT_SOCKET=/tmp/rtorrent
RTORRENT_CONF=/opt/etc/rtorrent.conf


start() {
        if [ -e \${RTORRENT_SOCKET} ]; then
                echo "Socket \${RTORRENT_SOCKET} exist. rtorrent not started."
                exit 1
        fi
        echo "Starting rtorrent with dtach on \${RTORRENT_SOKET} ..."
				sleep 10
        /opt/bin/dtach -n \${RTORRENT_SOCKET} nice -n 20 /opt/bin/rtorrent -n -o import=\${RTORRENT_CONF}
        echo "Configuration's setting are located in \${RTORRENT_CONF}"
        echo "done. Issue"
        echo "\$0 attach"
        echo "  to attach to terminal and ^\ to dtach."
}

stop() {
        echo -n "Shutting down rtorrent... "
        killall rtorrent
        sleep 2
        rm -f /tmp/rpc.socket
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
        attach)
                dtach -a \${RTORRENT_SOCKET}
                ;;
        *)
                echo "Usage: \$0 (start|stop|restart|attach)"
                exit 1
                ;;
esac
EOF
chmod +x /opt/etc/init.d/S90rtorrent
echo rtorrent startup script prepared
[ -f /opt/etc/rtorrent.conf ] && cp /opt/etc/rtorrent.conf /opt/etc/rtorrent.conf.old
echo '

min_peers = 4
max_peers = 16
max_uploads = 4


#change 1
#download_rate = 512
download_rate = 768
upload_rate = 32

dht = auto
encryption = allow_incoming,enable_retry,prefer_plaintext
ip = home.cipex.ro
directory = /tmp/hdd/volumes/HDD1/rtorrent/download
session = /tmp/hdd/volumes/HDD1/rtorrent/config
schedule = watch_directory,5,5,load_start=/tmp/hdd/volumes/HDD1/rtorrent/watch/*.torrent

scgi_local = /tmp/rpc.socket

#send_buffer_size = 4096
#receive_buffer_size = 4096
send_buffer_size = 4096
receive_buffer_size = 4096

#change 2
#max_memory_usage = 64M
max_memory_usage = 96M
#max_memory_usage = 134217728
max_open_files = 128

#hash_read_ahead = 8
#hash_max_tries = 5
#hash_interval = 200

max_open_files = 128

#check_hash = no

session_lock = no

'> /opt/etc/rtorrent.conf


cat >/opt/etc/lighttpd/conf.d/11-rtorrent-rpc.conf <<EOF
server.modules += ( "mod_scgi" )
scgi.server = (
                "/RPC2" =>
                  ( "127.0.0.1" =>
                    (
                      "socket" => "/tmp/rpc.socket",
                      "check-local" => "disable",
                      "disable-time" => 0,  # don't disable scgi if connection fails
                    )
                  )
              )
EOF

cat >/opt/etc/lighttpd/conf.d/00.event-handler.conf <<EOF
server.event-handler = "poll"
EOF

echo lighttp prepared
#prepare transmission directories

if [ ! -d /tmp/hdd/volumes/HDD1/rtorrent ]
then
	echo Creating transmission directories
	mkdir /tmp/hdd/volumes/HDD1/rtorrent/watch
	mkdir /tmp/hdd/volumes/HDD1/rtorrent/config
	mkdir /tmp/hdd/volumes/HDD1/rtorrent/download
else
	if [ ! -d /tmp/hdd/volumes/HDD1/rtorrent/config ]
	then
		echo Creating transmission config directory
		mkdir /tmp/hdd/volumes/HDD1/rtorrent/config
	else
		echo config directory found
	fi
	if [ ! -d /tmp/hdd/volumes/HDD1/rtorrent/download ]
	then
		echo Creating transmission download directory
		mkdir /tmp/hdd/volumes/HDD1/rtorrent/download
	else
		echo download directory found
	fi
        if [ ! -d /tmp/hdd/volumes/HDD1/rtorrent/watch ]
        then
                echo Creating transmission watch directory
                mkdir /tmp/hdd/volumes/HDD1/rtorrent/watch
        else
                echo download watch found
        fi

fi


#web gui install

cd /opt/share/www
rm -rf rtgui*
wget http://rtgui.googlecode.com/files/rtgui-0.2.7.tgz
/opt/bin/gunzip rtgui-0.2.7.tgz
tar xvf rtgui-0.2.7.tar
cd /opt/share/www/rtgui

cat > config.php <<EOF
<?php

include "config.php.example";

// Connect string for your local RPC/rTorrent connection:
\$rpc_connect="http://localhost:8081/RPC2";

// rtorrent 'watch' directory (used for upload torrent)
\$watchdir="/tmp/hdd/volumes/HDD1/rtorrent/watch";

// Path to report disk usage
\$downloaddir="/tmp/hdd/volumes/HDD1/rtorrent/download";

?>
EOF
cd ..
rm rtgui-0.2.7.tar

# second web gui install
cd /opt/share/www
rm -rf rutorrent*
wget http://rutorrent.googlecode.com/files/rutorrent-3.0.tar.gz
/opt/bin/gunzip rutorrent-3.0.tar.gz
tar xvf rutorrent-3.0.tar
cd rutorrent/conf
mv config.php config.php.dist
cat > config.php <<EOF
<?php

include "config.php.dist";

\$scgi_port = 0;
\$scgi_host = "unix:///tmp/rpc.socket";
?>
EOF
cd ../..
rm rutorrent-3.0.tar

sh /opt/etc/init.d/S90rtorrent start
sh /opt/etc/init.d/S80lighttpd restart

echo !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
echo !
echo !  Note this: you are be able to access rtorrent at address:
echo !  http://\<your_box_ip\>:8081/rtgui
echo !  You need to replace \<your_box_ip\> with the IP address of your box 
echo !  that you can find in setup menu, network section
echo !
echo !!!!!!!!!!!!!!!!!!!!!!!!!!!!!

echo We will reboot in 10 seconds, press CTRL+C to stop
sleep 5
echo 5 seconds to go
sleep 5
reboot

