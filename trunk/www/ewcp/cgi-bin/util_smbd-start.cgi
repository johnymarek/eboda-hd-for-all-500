#!/bin/sh

. ./common.sh

nice_start "Starting samba"

sh /tmp/package/script/*samba stop
sh /tmp/package/script/*samba start

nice_exit 0 


