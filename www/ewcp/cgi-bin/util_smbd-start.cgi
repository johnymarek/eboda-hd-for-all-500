#!/bin/sh

. ./common.sh

nice_start "Starting samba"

/tmp/package/script/samba stop
/tmp/package/script/samba start

nice_exit 0 


