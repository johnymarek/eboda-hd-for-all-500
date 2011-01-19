#!/bin/sh

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Player will standby in ${to_wait} minutes"  ${is_rss}

/cb3pp/sbin/standbycancel

nice_exit 0 ${is_rss}
