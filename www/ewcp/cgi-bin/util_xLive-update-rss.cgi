#!/bin/sh

component=xLive
description="Xtreamer Live"


. ./common.sh

rss_start "Updating ${description}"

check_update ${component}
if [ $? -eq 0 ]
then
    perform_update ${component}


fi

rss_exit 0 
