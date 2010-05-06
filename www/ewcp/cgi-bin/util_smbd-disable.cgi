#!/bin/sh

. ./common.sh

nice_start "Disabling samba"

chmod -x /opt/etc/init.d/S08samba
if [ $? -eq 0 ]
then
    echo "samba will no longer start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 
