#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Stopping thttpd" ${is_rss}

sh /cb3pp/etc/init.d/*S80thttpd stop

nice_exit 0 ${is_rss}


