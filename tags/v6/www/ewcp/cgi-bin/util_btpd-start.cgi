#!/bin/sh

. ./common.sh

nice_start "Starting btpd"

sh /tmp/package/script/btpd stop
sh /tmp/package/script/btpd start

nice_exit 0 


