#!/bin/sh

basename $0 | grep -v \\-rss &> /dev/null 
is_rss=$?

. ./common.sh

nice_start "Starting btpd" ${is_rss}

sh /tmp/package/script/*btpd stop
sh /tmp/package/script/*btpd start

nice_exit 0 ${is_rss}


