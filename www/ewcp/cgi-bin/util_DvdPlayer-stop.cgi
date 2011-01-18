#!/bin/sh
basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?


. ./common.sh

nice_start "Stopping DvdPlayer" ${is_rss}

/usr/bin/stopall

nice_exit 0 ${is_rss}

