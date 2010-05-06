#!/bin/sh

. ./common.sh

nice_start "Enabling samba"

chmod +x /opt/etc/init.d/S08samba
if [ $? -eq 0 ]
then
    echo "samba will start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 
