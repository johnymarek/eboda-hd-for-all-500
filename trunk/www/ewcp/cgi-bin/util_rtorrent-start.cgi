#!/bin/sh

. ./common.sh

nice_start "Starting rtorrent"

/opt/etc/init.d/S90rtorrent stop
/opt/etc/init.d/S90rtorrent start

nice_exit 0 


