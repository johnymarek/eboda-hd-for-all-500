#!/bin/sh

basename $0 | grep -v \\-rss &> /dev/null 
is_rss=$?

. ./common.sh

nice_start "Stopping transmission" ${is_rss}

/cb3pp/etc/init.d/*S90transmission-daemon stop

nice_exit 0 ${is_rss}


