#!/bin/sh

. ./common.sh

nice_start "Starting btpd"

/tmp/package/script/btpd stop
/tmp/package/script/btpd start

nice_exit 0 


