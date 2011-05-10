#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Starting transmission" ${is_rss}

/cb3pp/etc/init.d/*S90transmission-daemon stop
/cb3pp/etc/init.d/*S90transmission-daemon start

nice_exit 0 ${is_rss}


