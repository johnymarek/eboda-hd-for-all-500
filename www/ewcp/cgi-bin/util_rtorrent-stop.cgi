#!/bin/sh

basename $0 | grep -v \\-rss &> /dev/null 
is_rss=$?

. ./common.sh

nice_start "Stopping rtorrent" ${is_rss}

sh /cb3pp/etc/init.d/*S90rtorrent stop

nice_exit 0 ${is_rss}


