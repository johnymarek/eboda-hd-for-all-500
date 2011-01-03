#!/bin/sh

component=xLive
description="Xtreamer Live"


. ./common.sh

nice_start "Updating ${description}"

check_update ${component}
if [ $? -eq 0 ]
then
    perform_update ${component}


fi

nice_exit 0 
