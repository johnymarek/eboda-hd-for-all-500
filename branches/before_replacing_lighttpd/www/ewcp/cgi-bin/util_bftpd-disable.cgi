#!/bin/sh

. ./common.sh

nice_start "Disabling bftpd"

mv /cb3pp/etc/init.d/S70bftpd /cb3pp/etc/init.d/off.S70bftpd 
if [ $? -eq 0 ]
then
    echo "bftpd will no longer start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 