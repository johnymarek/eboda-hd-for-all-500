#!/bin/sh

. ./common.sh

nice_start "Starting bftpd"

sh /cb3pp/etc/init.d/S70bftpd stop
sh /cb3pp/etc/init.d/S70bftpd start

nice_exit 0 


