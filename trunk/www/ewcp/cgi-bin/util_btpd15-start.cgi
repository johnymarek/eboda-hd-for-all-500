#!/bin/sh

. ./common.sh

nice_start "Starting btpd 0.15"


sh /cb3pp/etc/init.d/*S90btpd15 stop
sh /cb3pp/etc/init.d/*S90btpd15 start

nice_exit 0 


