#!/bin/sh


basename $0 | grep -v \\-rss &> /dev/null 
is_rss=$?

. ./common.sh

nice_start "Enabling btpd 0.15" ${is_rss}

mv  /cb3pp/etc/init.d/off.S90btpd15 /cb3pp/etc/init.d/S90btpd15
if [ $? -eq 0 ]
then
    echo "btpd 0.15 will start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 ${is_rss}
