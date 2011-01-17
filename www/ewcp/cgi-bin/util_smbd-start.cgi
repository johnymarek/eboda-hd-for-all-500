#!/bin/sh

basename $0 | grep -v \\-rss &> /dev/null 
is_rss=$?

. ./common.sh

nice_start "Starting samba" ${is_rss}

sh /tmp/package/script/*samba stop
sh /tmp/package/script/*samba start

nice_exit 0 ${is_rss}


