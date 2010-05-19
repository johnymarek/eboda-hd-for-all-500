#!/bin/sh

. ./common.sh

nice_start "Enabling bftpd"

chmod +x /cb3pp/etc/init.d/S70bftpd 

if [ $? -eq 0 ]
then
    echo "btfpd will start automatically after reboot"
else
    echo "error occured"
fi

nice_exit 0 
