#!/bin/sh

basename $0 | grep -v \\-rss &> /dev/null 
is_rss=$?

. ./common.sh

nice_start "Enabling lighttpd" ${is_rss}

mv /cb3pp/etc/init.d/off.S80lighttpd /cb3pp/etc/init.d/S80lighttpd
if [ $? -eq 0 ]
then
    echo "lighttpd will start automatically after reboot"
else
    echo "error occured"
fi


nice_exit 0  ${is_rss}
