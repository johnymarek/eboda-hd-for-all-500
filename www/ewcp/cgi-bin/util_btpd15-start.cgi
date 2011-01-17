#!/bin/sh

basename $0 | grep -v \\-rss &> /dev/null 
is_rss=$?

. ./common.sh

nice_start "Starting btpd 0.15" ${is_rss}


sh /cb3pp/etc/init.d/*S90btpd15 stop
sh /cb3pp/etc/init.d/*S90btpd15 start

nice_exit 0 ${is_rss}


