#!/bin/sh

. ./common.sh

nice_start "Stopping rtorrent"

/opt/etc/init.d/S90rtorrent stop

nice_exit 0 


