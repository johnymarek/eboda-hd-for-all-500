#!/bin/sh

. ./common.sh

nice_start "Starting transmission"

/cb3pp/etc/init.d/*S90transmission-daemon stop
/cb3pp/etc/init.d/*S90transmission-daemon start

nice_exit 0 


