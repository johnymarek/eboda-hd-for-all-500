#!/bin/sh

. ./common.sh

nice_start "Disabling samba"

chmod -x /tmp/package/script/samba 
if [ $? -eq 0 ]
then
    echo "samba will no longer start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 
