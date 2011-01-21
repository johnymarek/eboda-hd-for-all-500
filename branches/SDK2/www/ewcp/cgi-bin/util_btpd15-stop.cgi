#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Stopping btpd 0.15" ${is_rss}


sh /cb3pp/etc/init.d/*S90btpd15 stop

nice_exit 0 ${is_rss}


