#!/bin/sh

to_wait=`basename $0 | sed -e 's/-rss//' -e  's/.*-//' -e 's/\..*//'`
basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Player will standby in ${to_wait} minutes"  ${is_rss}

/cb3pp/bin/nohup /cb3pp/sbin/standbyafter-${to_wait}&

nice_exit 0 ${is_rss}
