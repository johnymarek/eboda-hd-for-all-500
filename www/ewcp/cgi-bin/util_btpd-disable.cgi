#!/bin/sh

basename $0 | grep -v \\-rss &> /dev/null 
is_rss=$?

. ./common.sh

nice_start "Disabling btpd" ${is_rss}

chmod -x /tmp/package/script/btpd

if [ $? -eq 0 ]
then
    echo "btpd will no longer start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0  ${is_rss}
