#!/bin/sh

. ./common.sh

nice_start "Disabling lighttpd"

chmod -x /cb3pp/etc/init.d/S80lighttpd
if [ $? -eq 0 ]
then
    echo "lighttpd will no longer start automatically after reboot"
else
    echo "error occured"


nice_exit 0 
