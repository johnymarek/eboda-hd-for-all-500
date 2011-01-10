#!/bin/sh

. ./common.sh

nice_start "Stopping rtorrent"

sh /cb3pp/etc/init.d/*S90rtorrent stop

nice_exit 0 


