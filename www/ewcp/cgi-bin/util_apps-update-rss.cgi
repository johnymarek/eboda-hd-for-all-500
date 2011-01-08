#!/bin/sh

component=cb3pp
description="binaries compiled by cipibad"


. ./common.sh

rss_start "Updating ${description}"

check_update ${component}
if [ $? -eq 0 ]
then
    perform_update ${component}


fi

rss_exit 0 
