#!/bin/sh

. ./common.sh

nice_start "Starting lighttpd"

sh /cb3pp/etc/init.d/*S80lighttpd stop
sh /cb3pp/etc/init.d/*S80lighttpd start

nice_exit 0 


