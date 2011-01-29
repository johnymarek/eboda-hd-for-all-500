#!/bin/sh

to_wait=0
basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Player will standby in ${to_wait} minutes"  ${is_rss}

/cb3pp/bin/nohup /cb3pp/sbin/resetafter-now > /tmp/nohup.out 2>&1 </dev/null &

nice_exit 0 ${is_rss}
