#!/bin/sh

. ./common.sh

nice_start "Enabling samba"

chmod +x /tmp/package/script/samba 

if [ $? -eq 0 ]
then
    echo "samba will start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 
