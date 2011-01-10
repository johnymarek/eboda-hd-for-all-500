#!/bin/sh

. ./common.sh

nice_start "Stopping bftpd"

sh /cb3pp/etc/init.d/*S70bftpd stop

nice_exit 0 


