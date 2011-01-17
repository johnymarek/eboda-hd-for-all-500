#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Disabling btpd 0.15" ${is_rss}

mv /cb3pp/etc/init.d/S90btpd15 /cb3pp/etc/init.d/off.S90btpd15 
if [ $? -eq 0 ]
then
    echo "btpd 0.15 will no longer start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0  ${is_rss}
