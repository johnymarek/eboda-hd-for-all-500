#!/bin/sh

. ./common.sh

nice_start "Stopping lighttpd"

/opt/etc/init.d/S80lighttpd stop

nice_exit 0 

