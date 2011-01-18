#!/bin/sh
basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?

. ./common.sh

nice_start "Starting DvdPlayer" ${is_rss}

cd /usr/local/bin
./RootApp DvdPlayer


nice_exit 0 ${is_rss}




