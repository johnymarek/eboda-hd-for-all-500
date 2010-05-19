#!/bin/sh

. ./common.sh

nice_start "Stopping btpd"

sh /tmp/package/script/btpd stop

nice_exit 0 


