#!/bin/sh

. ./common.sh

nice_start "Stopping transmission"

/cb3pp/etc/init.d/*S90transmission-daemon stop

nice_exit 0 


