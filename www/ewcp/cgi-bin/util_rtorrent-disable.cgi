#!/bin/sh

. ./common.sh

nice_start "Disabling rtorrent"

mv /cb3pp/etc/init.d/S90rtorrent /cb3pp/etc/init.d/off.S90rtorrent 

if [ $? -eq 0 ]
then
    echo "rtorrent will no longer start automatically after reboot"
else
    echo "error occured"
fi
nice_exit 0 