#!/bin/sh

. ./common.sh

nice_start "Starting rtorrent"

sh /cb3pp/etc/init.d/S90rtorrent stop
sh /cb3pp/etc/init.d/S90rtorrent start

nice_exit 0 


