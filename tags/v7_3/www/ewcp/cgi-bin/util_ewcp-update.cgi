#!/bin/sh

component=ewcp4
description="E-boda Web Control Panel"

basename $0 | grep -v \\-rss >/dev/null 2>&1 
is_rss=$?


. ./common.sh

nice_start "Updating ${description}" ${is_rss}

check_update ${component} ${is_rss}
if [ $? -eq 0 ]
then
    perform_update ${component} ${is_rss}


fi

nice_exit 0  ${is_rss}