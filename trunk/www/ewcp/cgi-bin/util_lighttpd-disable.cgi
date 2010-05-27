#!/bin/sh

. ./common.sh

nice_start "Disabling lighttpd"

mv /cb3pp/etc/init.d/S80lighttpd /cb3pp/etc/init.d/off.S80lighttpd 
if [ $? -eq 0 ]
then
    echo "lighttpd will no longer start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 
