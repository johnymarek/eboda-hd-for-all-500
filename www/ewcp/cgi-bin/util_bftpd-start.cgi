#!/bin/sh

. ./common.sh

nice_start "Starting bftpd"

/cb3pp/etc/init.d/S70bftpd stop
/cb3pp/etc/init.d/S70bftpd start

nice_exit 0 


