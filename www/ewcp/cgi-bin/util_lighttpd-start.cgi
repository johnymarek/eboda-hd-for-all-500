#!/bin/sh

. ./common.sh

nice_start "Starting lighttpd"

/cb3pp/etc/init.d/S80lighttpd stop
/cb3pp/etc/init.d/S80lighttpd start

nice_exit 0 


