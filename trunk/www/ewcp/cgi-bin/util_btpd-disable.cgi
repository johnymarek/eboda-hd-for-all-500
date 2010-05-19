#!/bin/sh

. ./common.sh

nice_start "Disabling btpd"

chmod -x /tmp/package/script/btpd

if [ $? -eq 0 ]
then
    echo "btpd will no longer start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 
