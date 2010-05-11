#!/bin/sh

. ./common.sh

nice_start "Starting rtorrent"

/cb3pp/etc/init.d/S90rtorrent stop
/cb3pp/etc/init.d/S90rtorrent start

nice_exit 0 


