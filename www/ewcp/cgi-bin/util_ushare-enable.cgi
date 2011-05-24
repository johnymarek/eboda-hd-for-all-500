#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?


. ./common.sh

nice_start "Enabling ushare"  ${is_rss}

mv /cb3pp/etc/init.d/off.S95ushare /cb3pp/etc/init.d/S95ushare
if [ $? -eq 0 ]
then
    echo "ushare will start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0  ${is_rss}
