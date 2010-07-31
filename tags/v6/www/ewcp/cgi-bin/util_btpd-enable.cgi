#!/bin/sh

. ./common.sh

nice_start "Enabling btpd"

chmod +x /tmp/package/script/btpd

if [ $? -eq 0 ]
then
    echo "btpd will start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 
