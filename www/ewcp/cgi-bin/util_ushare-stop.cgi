#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Stopping ushare" ${is_rss}

/cb3pp/etc/init.d/*S95ushare stop

nice_exit 0 ${is_rss}


