#!/bin/sh


basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Enabling btpd" ${is_rss}

chmod +x /tmp/package/script/btpd

if [ $? -eq 0 ]
then
    echo "btpd will start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 ${is_rss}
