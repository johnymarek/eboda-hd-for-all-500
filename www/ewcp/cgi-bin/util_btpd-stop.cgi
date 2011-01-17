#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Stopping btpd" ${is_rss}

sh /tmp/package/script/*btpd stop

nice_exit 0 ${is_rss}


