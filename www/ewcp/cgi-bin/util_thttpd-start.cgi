#!/bin/sh

. ./common.sh

nice_start "Starting thttpd"

sh /cb3pp/etc/init.d/*S80thttpd stop
sh /cb3pp/etc/init.d/*S80thttpd start

nice_exit 0 


