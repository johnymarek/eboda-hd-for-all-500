#!/bin/sh

. ./common.sh

nice_start "Enabling rtorrent"

chmod +x /cb3pp/etc/init.d/S90rtorrent
if [ $? -eq 0 ]
then
    echo "rtorrent will start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 
