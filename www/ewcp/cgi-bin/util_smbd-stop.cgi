#!/bin/sh

. ./common.sh

nice_start "Stopping samba"

sh /tmp/package/script/*samba stop

nice_exit 0 


