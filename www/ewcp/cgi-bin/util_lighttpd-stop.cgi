#!/bin/sh

. ./common.sh

nice_start "Stopping lighttpd"

/cb3pp/etc/init.d/S80lighttpd stop

nice_exit 0 


