#!/bin/sh

. ./common.sh

nice_start "Starting lighttpd"

/opt/etc/init.d/S80lighttpd stop
/opt/etc/init.d/S80lighttpd start

nice_exit 0 


