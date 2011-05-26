#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Starting mediatomb" ${is_rss}

/cb3pp/etc/init.d/*S95mediatomb stop
/cb3pp/etc/init.d/*S95mediatomb start

nice_exit 0 ${is_rss}


