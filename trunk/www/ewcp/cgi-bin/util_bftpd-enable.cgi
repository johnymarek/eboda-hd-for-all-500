#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Enabling bftpd" ${is_rss}

mv /cb3pp/etc/init.d/off.S70bftpd /cb3pp/etc/init.d/S70bftpd 

if [ $? -eq 0 ]
then
    echo "btfpd will start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 ${is_rss}
