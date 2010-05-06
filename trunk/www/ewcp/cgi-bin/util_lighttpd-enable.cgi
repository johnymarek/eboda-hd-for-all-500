#!/bin/sh

. ./common.sh

nice_start "Enabling lighttpd"

chmod +x /opt/etc/init.d/S80lighttpd
if [ $? -eq 0 ]
then
    echo "lighttpd will start automatically after reboot"
else
    echo "error occured"
fi


nice_exit 0 
