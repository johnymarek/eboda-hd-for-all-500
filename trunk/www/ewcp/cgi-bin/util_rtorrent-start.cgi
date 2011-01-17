#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Starting rtorrent" ${is_rss}

sh /cb3pp/etc/init.d/*S90rtorrent stop
sh /cb3pp/etc/init.d/*S90rtorrent start

nice_exit 0 ${is_rss}


