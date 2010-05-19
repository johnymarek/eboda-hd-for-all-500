#!/bin/sh

. ./common.sh

nice_start "Enabling btpd 0.15"

chmod +x /cb3pp/etc/init.d/S90btpd15
if [ $? -eq 0 ]
then
    echo "btpd 0.15 will start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 