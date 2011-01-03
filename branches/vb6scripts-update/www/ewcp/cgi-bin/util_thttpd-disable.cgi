#!/bin/sh

. ./common.sh

nice_start "Disabling thttpd"

mv /cb3pp/etc/init.d/S80thttpd /cb3pp/etc/init.d/off.S80thttpd 
if [ $? -eq 0 ]
then
    echo "thttpd will no longer start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 
