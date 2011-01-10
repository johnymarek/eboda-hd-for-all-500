#!/bin/sh

. ./common.sh

nice_start "Stopping thttpd"

sh /cb3pp/etc/init.d/*S80thttpd stop

nice_exit 0 


