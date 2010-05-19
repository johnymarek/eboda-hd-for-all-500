#!/bin/sh

. ./common.sh

nice_start "Stopping btpd 0.15"


sh /cb3pp/etc/init.d/S90btpd15 stop

nice_exit 0 


