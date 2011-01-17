#!/bin/sh

basename $0 | grep -v \\-rss &> /dev/null 
is_rss=$?

. ./common.sh

nice_start "Stopping samba" ${is_rss}

sh /tmp/package/script/*samba stop

nice_exit 0 ${is_rss}


